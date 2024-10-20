<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

class ColorController extends Controller
{
    public function index()
    {
        $perPage = 7;
        $colordm = Color::paginate($perPage);

        return view('admin.colors.index', compact('colordm'));
    }

    public function create()
    {
        return view('admin.colors.create_colors');
    }

    public function AddNewcolors(Request $request)
    {

        // Nhận dữ liệu từ yêu cầu
        $name = $request->input('name');
        $images = $request->input('images');

        // Tạo một đối tượng mới của mô hình Category
        $color = new color();
        $color->name = $name;
        $color->images = $images;

        if ($request->hasFile('images')) {
            // Handle image upload
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/colors'), $imageName); // Save the image to public/img
            // Update the colors's image
            $color->images = $imageName;
        }
        // Lưu đối tượng mô hình vào cơ sở dữ liệu
        $color->save();

        return redirect()->route('admin_colors.index')->with('success', 'Màu được thêm thành công!');
    }

    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.colors.update_colors', compact('color'));
    }


    public function update(Request $request, $id)
    {
        // Xác thực dữ liệu từ yêu cầu
        $name = $request->input('name');
        $images = $request->input('images');

        // Tìm màu sắc trong cơ sở dữ liệu
        $color = Color::findOrFail($id);

        // Cập nhật tên màu
        $color->name = $name;
        $color->images = $images;

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('images')) {
            // Handle image upload
            $image = $request->file('images');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/colors'), $imageName); // Save the image to public/img
            // Update the colors's image
            $color->images = $imageName;
        }
        // Lưu đối tượng mô hình vào cơ sở dữ liệu
        $color->save();

        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được cập nhật thành công!');
    }


    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được xóa thành công!');
    }
}
