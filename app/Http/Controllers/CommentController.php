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

        // Lấy tên người dùng
        $userName = Auth::user()->username;

        // Tạo bình luận
        Comment::create([
            'product_id' => $product->product_id,
            'name' => $userName, // Lấy tên người dùng
            'comment' => $request->comment,
        ]);

        // Quay lại trang sản phẩm kèm thông báo
        return redirect()->route('product.details', $product->product_id)->with('success', 'Bình luận của bạn đã được gửi!');
    }

    // Cập nhật bình luận
    public function update(Request $request, $id)
    {
        // Lấy bình luận theo id
        $comment = Comment::findOrFail($id);

        // Kiểm tra quyền của người dùng
        if (Auth::user()->username !== $comment->name) {
            return redirect()->back()->with('error', 'Bạn không có quyền sửa bình luận này!');
        }

        // Xác thực dữ liệu đầu vào
        $request->validate([
            'comment' => 'required|string',
        ]);

        // Cập nhật bình luận
        $comment->update([
            'comment' => $request->comment,
        ]);

        // Quay lại trang sản phẩm kèm thông báo
        return redirect()->route('product.details', $comment->product_id)->with('success', 'Bình luận đã được cập nhật!');
    }

    // Xóa bình luận
    public function destroy($id)
    {
        // Lấy bình luận theo id
        $comment = Comment::findOrFail($id);

        // Kiểm tra quyền của người dùng
        if (Auth::user()->username !== $comment->name) {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa bình luận này!');
        }

        // Xóa bình luận
        $comment->delete();

        return redirect()->back()->with('success', 'Bình luận đã được xóa!');
    }
}
