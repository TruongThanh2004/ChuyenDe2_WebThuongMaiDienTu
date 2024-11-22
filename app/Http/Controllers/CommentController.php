<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Thêm bình luận
    public function store(Request $request, $id)
    {
        // Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để bình luận.');
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'comment' => 'required|string',
        ]);

        // Thêm bình luận mới thông qua model
        Comment::addComment([
            'product_id' => $product->product_id,
            'name' => Auth::user()->username,
            'comment' => $request->comment,
        ]);

        return redirect()->route('product.details', $product->product_id)->with('success', 'Bình luận của bạn đã được gửi!');
    }

    // Cập nhật bình luận
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        // Kiểm tra quyền của người dùng
        if (!$comment->isOwnedByUser(Auth::user()->username)) {
            return redirect()->back()->with('error', 'Bạn không có quyền sửa bình luận này!');
        }

        $request->validate([
            'comment' => 'required|string',
        ]);

        // Cập nhật bình luận qua model
        $comment->updateComment($request->comment);

        return redirect()->route('product.details', $comment->product_id)->with('success', 'Bình luận đã được cập nhật!');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        // Kiểm tra quyền của người dùng
        if (!$comment->isOwnedByUser(Auth::user()->username)) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa bình luận này!');
        }

        // Xóa bình luận qua model
        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận đã được xóa!');
    }
}
