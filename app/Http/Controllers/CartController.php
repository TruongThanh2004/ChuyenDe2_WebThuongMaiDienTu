<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

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
    // if (!Auth::check()) {
    //     return redirect("login")->with('error', 'Bạn cần đăng nhập.');
    // }

    // $userId = Auth::id();
    // $order = Order::where('user_id', $userId)->where('status', 'pending')->first();

    // if ($order) {
    //     $cartItems = $order->orderItems()->with('product')->get();
    // } else {
    //     $cartItems = collect(); // Giỏ hàng trống
    // }

    // return view('home.cart', ['cartItems' => $cartItems]);




     // Kiểm tra người dùng đã đăng nhập hay chưa
     if (!Auth::check()) {
        return redirect("login")->with('error', 'Bạn cần đăng nhập.');
    }

    $userId = Auth::id();
    
    // Lấy đơn hàng đang chờ của người dùng với eager loading cho orderItems và product
    $order = Order::where('user_id', $userId)
                  ->where('status', 'pending')
                  ->with('orderItems.product')
                  ->first();

    // Kiểm tra xem có đơn hàng hay không
    if ($order) {
        $cartItems = $order->orderItems; // Sử dụng các item đã eager loaded
    } else {
        $cartItems = collect(); // Giỏ hàng trống
    }

    // Trả về view với các mặt hàng trong giỏ hàng
    return view('home.cart', ['cartItems' => $cartItems]);
}

    public function showCart($userId)
    {
        $cartItems = OrderItem::where('UserId', $userId)->get();

        $totalPrice = 0;
        foreach ($cartItems as $item) {
            $totalPrice += $item->quantity * $item->price;
            }
        return view('cart', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }
    public function updateCart(Request $request)
    {
        $cartItems = $request->input('cartItems');

        foreach ($cartItems as $id => $item) {
            $cartItem = OrderItem::findOrFail($id);
            $cartItem->quantity = $item['quantity'];
            $cartItem->price = $item['price'];
            $cartItem->save();
        }
        return redirect()->route('cart.index')->with('message', 'Giỏ hàng đã được cập nhật thành công.');
    }
   
}
