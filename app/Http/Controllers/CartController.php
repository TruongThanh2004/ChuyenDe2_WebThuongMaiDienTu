<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $productId)
    {
        if (!Auth::check()) {
            return redirect("login")->with('error', 'Bạn cần đăng nhập để thêm vào giỏ hàng.');
        }

        $userId = Auth::id();

        // Kiểm tra xem đã có đơn hàng (order) đang chờ xử lý cho người dùng này chưa
        $order = Order::firstOrCreate(
            ['user_id' => $userId, 'status' => 'pending'],
            ['total_amount' => 0]
        );

        // Tìm mục giỏ hàng trong order_items dựa trên order_id và product_id
        $cartItem = OrderItem::where('order_id', $order->order_id)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            $product = Product::findOrFail($productId);
            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $productId,
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }
        return back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
       
    }

    // hiển thị giỏ hàng
    public function index()
    {

       
        if (!Auth::check()) {
            return redirect("login")->with('error', 'Bạn cần đăng nhập.');
        }
    
        $userId = Auth::id();
    
        // Lấy đơn hàng 'pending' của người dùng
        $order = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('orderItems.product')
            ->first();
    
        $hasInvalidItems = false; // Cờ kiểm tra sản phẩm không tồn tại
    
        if ($order) {
            $cartItems = $order->orderItems;
    
            // Kiểm tra từng sản phẩm trong giỏ hàng
            foreach ($cartItems as $item) {
               
                if (!$item->product) {
                    $item->delete(); 
                    $hasInvalidItems = true; 
                }
            }
    
            $cartItems = $order->orderItems;
    
           
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product ? $item->product->price * $item->quantity : 0;
            });
    
        
            $totalAmountFormatted = number_format($totalAmount, 0, ',', '.');
        } else {
            $cartItems = collect();
            $totalAmount = 0; 
            $totalAmountFormatted = number_format($totalAmount, 0, ',', '.');
        }
    
        
        if ($hasInvalidItems) {
            return redirect()->route('cart.index')
                ->with('error');
        }
    
        return view('home.cart', ['cartItems' => $cartItems, 'totalAmount' => $totalAmountFormatted]);
    }

    // hàm cập nhật số lượng 
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:order_items,order_items_id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItem = OrderItem::findOrFail($request->id);

        if ($cartItem->product->stock < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không đủ trong kho.']);
        }

        $cartItem->quantity = $request->quantity;
        $cartItem->price = $cartItem->product->price * $request->quantity;
        $cartItem->save();

        if ($cartItem->save()) {
            return response()->json(['success' => true, 'message' => 'Cập nhật thành công']);
        } else {
            return response()->json(['success' => false, 'message' => 'Lỗi khi lưu dữ liệu']);
        }
    }

    // hàm xóa 1 sản phâm
    public function destroy($id)
    {
        // // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect("login")->with('error', 'Bạn cần đăng nhập để xóa sản phẩm khỏi giỏ hàng.');
        }

        $userId = Auth::id();

        // Tìm đơn hàng đang chờ xử lý của người dùng
        $order = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn hiện đang trống.');
        }

        // Tìm mục trong OrderItem theo order_id và product_id
        $cartItem = OrderItem::where('order_id', $order->order_id)
            ->where('order_items_id', $id) // Sử dụng ID của OrderItem để tìm kiếm
            ->first();

        if (!$cartItem) {
            return redirect()->route('cart.index')->with('error', 'Sản phẩm không tồn tại trong giỏ hàng.');
        }

        // Xóa mục giỏ hàng
        $cartItem->delete();
        // Kiểm tra xem đơn hàng còn sản phẩm nào không
        $remainingItemsCount = OrderItem::where('order_id', $order->order_id)->count();

        // Nếu không còn sản phẩm nào, xóa đơn hàng
        if ($remainingItemsCount === 0) {
            $order->delete(); // Xóa đơn hàng
            return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng và giỏ hàng đã được xóa vì không còn sản phẩm nào.');
        }
        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng.');
    }
    // hàm xóa tất cả sản phẩm đã chọn trong giỏ hàng
    public function destroySelected(Request $request)
    {
        if (!Auth::check()) {
            return redirect("login")->with('error', 'Bạn cần đăng nhập để xóa sản phẩm khỏi giỏ hàng.');
        }

        $userId = Auth::id();
        $selectedIds = json_decode($request->input('selected_items'), true); // Giải mã JSON

        if (empty($selectedIds)) {
            return redirect()->route('cart.index')->with('error', 'Bạn chưa chọn sản phẩm nào để xóa.');
        }

        $order = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->first();

        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn hiện đang trống.');
        }

        OrderItem::where('order_id', $order->order_id)
            ->whereIn('order_items_id', $selectedIds)
            ->delete();

        $remainingItemsCount = OrderItem::where('order_id', $order->order_id)->count();

        if ($remainingItemsCount === 0) {
            $order->delete();
            return redirect()->route('cart.index')->with('success', 'Tất cả sản phẩm được chọn đã được xóa khỏi giỏ hàng');
        }

        return redirect()->route('cart.index')->with('success', 'Các sản phẩm được chọn đã được xóa khỏi giỏ hàng.');
    }
    // hàm tính tổng giá
    public function calculateCartTotal($cartItems)
    {
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['quantity'] * $item['price'];
            // $total +=  $item['price'];
        }
        return $total;
    }

    // thanh toan
    public function Checkout(Request $request)
    {
        $userId = Auth::id();
        $selectedItems = json_decode($request->input('selected_items', '[]'), true);

        if (empty($selectedItems)) {
            return redirect()->back()->with('error', 'Vui lòng chọn sản phẩm để thanh toán.');
        }

        $order = Order::where('user_id', $userId)->where('status', 'pending')->first();
        if (!$order) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn hiện đang trống.');
        }

        // Kiểm tra xem tất cả sản phẩm đã chọn có tồn tại trong giỏ hàng hay không
        foreach ($selectedItems as $itemId) {
            $orderItem = OrderItem::where('order_id', $order->order_id)
                ->where('order_items_id', $itemId)
                ->first();
            if (!$orderItem) {
                return redirect()->route('cart.index')
                    ->with('error', 'sản phẩm không tồn tại trong giỏ hàng. Vui lòng tải lại trang.');
            }
        }

        $totalAmount = 0; // Biến để lưu tổng số tiền của các sản phẩm đã chọn

        // Tính tổng số tiền của các sản phẩm đã chọn và cập nhật số lượng
        foreach ($selectedItems as $itemId) {
            $orderItem = OrderItem::where('order_id', $order->order_id)
                ->where('order_items_id', $itemId)
                ->first();

            if ($orderItem) {
                $totalAmount += $orderItem->price;

                // Cập nhật số lượng sản phẩm trong bảng products
                $product = Product::find($orderItem->product_id);
                if ($product) {
                    $product->quantity -= $orderItem->quantity;
                    $product->save();
                }
            }
        }

        // Tạo đơn hàng mới với total_amount
        $newOrder = Order::create([
            'user_id' => $userId,
            'status' => 'shipped',
            'total_amount' => $totalAmount
        ]);

        // Chuyển các sản phẩm đã chọn sang đơn hàng mới và xóa khỏi giỏ hàng
        foreach ($selectedItems as $itemId) {
            $orderItem = OrderItem::where('order_id', $order->order_id)
                ->where('order_items_id', $itemId)
                ->first();

            if ($orderItem) {
                $orderItem->order_id = $newOrder->order_id;
                $orderItem->save();
                $orderItem->delete(); // Xóa mục khỏi giỏ hàng
            }
        }

        // Kiểm tra nếu giỏ hàng gốc không còn sản phẩm nào thì xóa đơn hàng `pending`
        $remainingItems = OrderItem::where('order_id', $order->order_id)->count();
        if ($remainingItems === 0) {
            $order->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Thanh toán thành công cho các sản phẩm đã chọn.');
    }


    // hàm kiểm tra sản phẩm có tồn tại trong giỏ hàng hay không
    public function checkItemsExist(Request $request)
    {
        $selectedItems = $request->input('selected_items', []);
        $userId = Auth::id();
        $order = Order::where('user_id', $userId)->where('status', 'pending')->first();

        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Giỏ hàng của bạn hiện đang trống.']);
        }

        foreach ($selectedItems as $itemId) {
            $orderItem = OrderItem::where('order_id', $order->order_id)
                ->where('order_items_id', $itemId)
                ->first();

            if (!$orderItem) {
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng. Vui lòng tải lại trang.']);
            }
        }

        return response()->json(['success' => true]);
    }


    // tìm kiếm fulltext 
    public function searchCart(Request $request)
    {
        $query = $request->input('keyword');

        // Kiểm tra xem người dùng đã nhập từ khóa tìm kiếm chưa
        if (empty($query)) {
            return redirect()->back()->with('error', 'Vui lòng nhập từ khóa tìm kiếm.');
        }

        // Kiểm tra độ dài của chuỗi tìm kiếm
        if (strlen($query) > 255) {
            return redirect()->back()->with('error', 'Chuỗi tìm kiếm không được vượt quá 255 ký tự.');
        }

        // Tìm kiếm sản phẩm theo từ khóa
        $searchResults = OrderItem::join('products', 'order_items.product_id', '=', 'products.product_id')
            ->whereRaw("MATCH(products.name) AGAINST(? IN BOOLEAN MODE)", [$query])
            ->orWhere('products.price', 'LIKE', '%' . $query . '%')
            ->select('products.name as product_name', 'products.price', 'order_items.*')
            ->get();

        // Kiểm tra nếu không có kết quả tìm kiếm
        if ($searchResults->isEmpty()) {
            return view('cart.search_results', ['searchResults' => $searchResults])
                ->with('message', 'Không có kết quả nào.');
        } else {
            return view('cart.search_results', ['searchResults' => $searchResults])
                ->with('message', 'Kết quả tìm kiếm');
        }
    }
}
