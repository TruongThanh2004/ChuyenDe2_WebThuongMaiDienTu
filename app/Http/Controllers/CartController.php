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

        return redirect()->route('cart.index')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
    }

    // hiển thị giỏ hàng
    public function index()
    {

        if (!Auth::check()) {
            return redirect("login")->with('error', 'Bạn cần đăng nhập.');
        }

        $userId = Auth::id();

        $order = Order::where('user_id', $userId)
            ->where('status', 'pending')
            ->with('orderItems.product')
            ->first();

        if ($order) {
            $cartItems = $order->orderItems;

            // Tính tổng tiền
            $totalAmount = $cartItems->sum(function ($item) {
                return $item->product->price;
            });

            // Định dạng tổng tiền để hiển thị
            $totalAmountFormatted = number_format($totalAmount, 0, ',', '.'); // Định dạng không có số thập phân
        } else {
            $cartItems = collect();
            $totalAmount = 0; // Giỏ hàng trống, tổng tiền là 0
            $totalAmountFormatted = number_format($totalAmount, 0, ',', '.'); // Định dạng cho giỏ hàng trống
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
            return redirect()->route('cart.index')->with('success', 'Tất cả sản phẩm được chọn đã được xóa khỏi giỏ hàng và giỏ hàng đã được xóa vì không còn sản phẩm nào.');
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

        $totalAmount = 0; // Biến để lưu tổng số tiền của các sản phẩm đã chọn

        // Tính tổng số tiền của các sản phẩm đã chọn
        foreach ($selectedItems as $itemId) {
            $orderItem = OrderItem::where('order_id', $order->order_id)->where('order_items_id', $itemId)->first();
            if ($orderItem) {
                $totalAmount += $orderItem->price ;
                // $totalAmount += $orderItem->price ;

                // Cập nhật số lượng sản phẩm trong bảng products
                $product = Product::find($orderItem->product_id); // Giả sử OrderItem có trường product_id
                if ($product) {
                    $product->quantity -= $orderItem->quantity; // Giảm số lượng theo số lượng đã thanh toán
                    $product->save();
                }
            }
        }

        // Tạo đơn hàng mới với total_amount
        $newOrder = Order::create([
            'user_id' => $userId,
            'status' => 'shipped',
            'total_amount' => $totalAmount // Lưu tổng số tiền vào đơn hàng mới
        ]);

        // Chuyển các sản phẩm đã chọn sang đơn hàng mới và xóa khỏi giỏ hàng
        foreach ($selectedItems as $itemId) {
            $orderItem = OrderItem::where('order_id', $order->order_id)->where('order_items_id', $itemId)->first();
            if ($orderItem) {
                $orderItem->order_id = $newOrder->order_id;
                $orderItem->save();
                $orderItem->delete(); // Xóa mục khỏi bảng order_items của giỏ hàng gốc
            }
        }
        // Kiểm tra nếu giỏ hàng gốc không còn sản phẩm nào thì xóa đơn hàng `pending`
        $remainingItems = OrderItem::where('order_id', $order->order_id)->count();
        if ($remainingItems === 0) {
            $order->delete();
        }

        return redirect()->route('cart.index')->with('success', 'Thanh toán thành công cho các sản phẩm đã chọn.');
    }


}
