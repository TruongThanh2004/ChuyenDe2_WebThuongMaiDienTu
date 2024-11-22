<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        // Kiểm tra sản phẩm tồn tại
        $product = Product::findOrFail($id);
        // Xác thực dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
        ]);

         $userName = Auth::user()->username; 

        // Tạo bình luận
        Comment::create([
            'product_id' => $product->product_id,
            'name' => $request->name,
            'comment' => $request->comment,
        ]);

        // Quay lại trang sản phẩm kèm thông báo
        return redirect()->route('product.details', $product->product_id)->with('success', 'Bình luận của bạn đã được gửi!');
    }
}
