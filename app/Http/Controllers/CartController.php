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
        // // Kiểm tra người dùng đã đăng nhập hay chưa
        // if (!Auth::check()) {
        //     return redirect("login")->with('error', 'Bạn cần đăng nhập.');
        // }

        // $userId = Auth::id();

        // // Lấy đơn hàng đang chờ của người dùng với eager loading cho orderItems và product
        // $order = Order::where('user_id', $userId)
        //     ->where('status', 'pending')
        //     ->with('orderItems.product')
        //     ->first();

        // // Kiểm tra xem có đơn hàng hay không
        // if ($order) {
        //     $cartItems = $order->orderItems; // Sử dụng các item đã eager loaded

        // } else {
        //     $cartItems = collect(); // Giỏ hàng trống
        // }

        // // Trả về view với các mặt hàng trong giỏ hàng
        // return view('home.cart', ['cartItems' => $cartItems]);



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
                return $item->quantity * $item->product->price;
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

    public function showCart()
    {
        // Kiểm tra người dùng đã đăng nhập hay chưa
        if (!Auth::check()) {
            return redirect("login")->with('error', 'Bạn cần đăng nhập.');
        }
    
        $userId = Auth::id();
    
        $cartItems = OrderItem::whereHas('order', function($query) use ($userId) {
            $query->where('user_id', $userId)
                  ->where('status', 'pending');
        })->with('product')->get();
    
        // Tính tổng tiền
        $totalAmount = $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    
        return view('home.cart', compact('cartItems', 'totalAmount'));
    }



    public function updateCart(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:order_items,order_items_id', // Kiểm tra ID có tồn tại không
            'quantity' => 'required|integer|min:1', // Kiểm tra số lượng
        ]);

        // Tìm OrderItem theo ID
        $cartItem = OrderItem::findOrFail($request->id);

        // Kiểm tra xem sản phẩm còn trong kho không
        if ($cartItem->product->stock < $request->quantity) {
            return response()->json(['success' => false, 'message' => 'Sản phẩm không đủ trong kho.']); // Thông báo lỗi
        }

        // Cập nhật số lượng và giá
        $cartItem->quantity = $request->quantity;
        $cartItem->price = $cartItem->product->price * $request->quantity; // Cập nhật giá
        $cartItem->save();

        return response()->json(['message' => 'Cập nhật thành công', 'status' => 200]);
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



    // hàm xóa tất cả sản phẩm trong giỏ hàng
    // public function destroyAll()
    // {
    //     // Kiểm tra người dùng đã đăng nhập hay chưa
    //     if (!Auth::check()) {
    //         return redirect("login")->with('error', 'Bạn cần đăng nhập để xóa sản phẩm khỏi giỏ hàng.');
    //     }

    //     $userId = Auth::id();

    //     // Tìm đơn hàng đang chờ xử lý của người dùng
    //     $order = Order::where('user_id', $userId)
    //         ->where('status', 'pending')
    //         ->first();

    //     if (!$order) {
    //         return redirect()->route('cart.index')->with('error', 'Giỏ hàng của bạn hiện đang trống.');
    //     }

    //     // Xóa tất cả mục trong giỏ hàng
    //     OrderItem::where('order_id', $order->order_id)->delete();
    //     // Kiểm tra xem đơn hàng còn sản phẩm nào không
    //     $remainingItemsCount = OrderItem::where('order_id', $order->order_id)->count();

    //     // Nếu không còn sản phẩm nào, xóa đơn hàng
    //     if ($remainingItemsCount === 0) {
    //         $order->delete(); // Xóa đơn hàng
    //         return redirect()->route('cart.index')->with('success', 'Tất cả sản phẩm đã được xóa khỏi giỏ hàng và giỏ hàng đã được xóa vì không còn sản phẩm nào.');
    //     }
    //     return redirect()->route('cart.index')->with('success', 'Tất cả sản phẩm đã được xóa khỏi giỏ hàng.');
    // }

    //thanh toán
    public function checkout(Request $request)
    {
        $cartItems = session()->get('cart');

        // Kiểm tra xem giỏ hàng có trống không
        if (empty($cartItems)) {
            return redirect()->back()->with('error', 'Giỏ hàng của bạn hiện đang trống.');
        }

        $total = $this->calculateCartTotal($cartItems);

        DB::beginTransaction();
        try {
            // Lưu đơn hàng và các mục giỏ hàng vào cơ sở dữ liệu
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_amount' => $total,
            ]);
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
                // Cập nhật tồn kho
                $product = Product::find($item['product_id']);
                $product->stock -= $item['quantity']; // Thay đổi 'quantity' thành 'stock'
                $product->save();
            }

            DB::commit();

            // Xóa giỏ hàng sau khi thanh toán thành công
            session()->forget('cart');

            return redirect()->route('checkout.success');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Có lỗi xảy ra khi thanh toán. Vui lòng thử lại.');
        }
    }


    public function calculateCartTotal($cartItems)
    {
        $total = 0;

        foreach ($cartItems as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return $total;
    }
}
