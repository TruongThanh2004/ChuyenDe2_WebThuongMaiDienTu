<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // Hàm thêm sản phẩm vào giỏ hàng
    public function addToCart($id)
    {
        // Lấy thông tin sản phẩm theo ID
        $product = Product::findOrFail($id);

        // Lưu sản phẩm vào session
        $cart = session()->get('cart', []);

        // Nếu sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
        if (isset($cart[$id])) {
            $cart[$id]['quantity']++;

            // Cập nhật vào bảng order_items
            $orderId = session()->get('order_id'); // Lấy order_id từ session
            $orderItem = OrderItem::where('product_id', $id)
                ->where('order_id', $orderId) // Sử dụng order_id từ session
                ->first();
            if ($orderItem) {
                $orderItem->quantity++;
                $orderItem->save();
            }
        } else {
            $cart[$id] = [
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image1
            ];

            // Thêm mới vào bảng order_items
            $orderId = session()->get('order_id');

            // Nếu chưa có order_id, tạo một đơn hàng mới
            if (!$orderId) {
                // Khi tạo một đơn hàng mới
                $order = Order::create([
                    'user_id' => auth()->id(), // Hoặc một user_id mặc định nếu người dùng chưa đăng nhập
                    'status' => 'pending',
                    'total_amount' => 0, // Tổng giá trị sẽ được cập nhật sau
                    'created_at' => now(),
                ]);
                $orderId = $order->id;
                session()->put('order_id', $orderId); // Lưu order_id vào session
            }

            // Thêm sản phẩm vào order_items
            OrderItem::create([
                'order_id' => $orderId, // Sử dụng order_id thực tế
                'product_id' => $id, // Đảm bảo rằng $id đã được truyền vào đây
                'quantity' => 1,
                'price' => $product->price,
            ]);
        }

        session()->put('cart', $cart);  // Cập nhật session

        return redirect()->route('cart')->with('success', 'Product added to cart!');
    }

    // Hàm hiển thị giỏ hàng
    public function viewCart()
    {
        // Lấy dữ liệu giỏ hàng từ session
        $cart = session()->get('cart', []);
        return view('cart', compact('cart'));
    }

    // Hàm cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateQuantity(Request $request, $id)
    {
        // Kiểm tra và lấy giỏ hàng từ session
        $cart = session()->get('cart');

        // Nếu sản phẩm tồn tại trong giỏ hàng
        if (isset($cart[$id])) {
            // Cập nhật số lượng sản phẩm
            $cart[$id]['quantity'] = $request->quantity;

            // Cập nhật vào bảng order_items nếu cần
            $orderItem = OrderItem::where('product_id', $id)
                ->where('order_id', session()->get('order_id')) // Lấy order_id từ session
                ->first();
            if ($orderItem) {
                $orderItem->quantity = $request->quantity;
                $orderItem->save();
            }
        }

        // Cập nhật lại session
        session()->put('cart', $cart);

        return response()->json(['success' => true]);
    }

    // Hàm xóa 1 sản phẩm khỏi giỏ hàng
    public function removeItem($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]); // Xóa sản phẩm khỏi mảng
            session()->put('cart', $cart); // Cập nhật session
        }

        return redirect()->route('cart')->with('success', 'Product removed from cart!');
    }

    // Hàm xóa toàn bộ sản phẩm trong giỏ hàng
    public function removeAllItem()
    {
        session()->forget('cart'); // Xóa toàn bộ giỏ hàng trong session
        session()->forget('order_id'); // Xóa order_id trong session nếu cần
        return redirect()->route('cart')->with('success', 'All products removed from cart!');
    }
}
