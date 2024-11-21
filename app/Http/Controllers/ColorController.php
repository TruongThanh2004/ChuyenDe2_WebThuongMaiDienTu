<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;
use Hashids\Hashids;

class ColorController extends Controller
{

    // Hiển thị 5 bảng màu trên 1 trang
    public function index()
    {
        $colordm = Color::paginate(5);
        return view('admin.colors.index', compact('colordm'));
    }

    // Hiển thị form thêm bảng màu mới
    public function create()
    {
        return view('admin.colors.create_colors');
    }

    // Hiển thị form chỉnh sửa bảng màu
    public function edit($encryptedId)
    {

        $color = Color::findByHashedId($encryptedId); 

        if (!$color) {
            return redirect()->route('admin_colors.index')->withErrors(['message' => 'Bảng màu không tồn tại!']);
        }
        return view('admin.colors.edit', compact('color'));
    }

    // Thêm bảng màu mới
    public function AddNewcolors(Request $request)
    {
       
        $validatedData = $request->validate(Color::getValidationRules(), trans('validation_colors'));

        if ($request->hasFile('images')) {
            $imageFile = $request->file('images');

            // Kiểm tra nếu tệp không phải là hình ảnh hoặc không hợp lệ

            if (!$imageFile->isValid() || !in_array($imageFile->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()->back()->withErrors(['images' => trans('validation_colors.images.invalid')]);
            }

            $validatedData['images'] = $imageFile;
        }

        // Tiến hành thêm màu mới
        try {
            $color = Color::createNewColor($validatedData, $request->file('images'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['images' => $e->getMessage()]);
        }

        return redirect()->route('admin_colors.index')->with('success', 'Màu được thêm thành công!');
    }

    // hàm update

    public function update(Request $request, $encryptedId)
    {
        // Giải mã ID
        $color = Color::findByHashedId($encryptedId);

        if (!$color) {
            return redirect()->route('admin_colors.index')->withErrors(['message' => 'Bảng màu không tồn tại!']);
        }

        // Xác thực dữ liệu đầu vào và sử dụng thông báo từ file validation_colors.php
        $validatedData = $request->validate(Color::getValidationRules(), trans('validation_colors'));

        // Kiểm tra tệp hình ảnh
        if ($request->hasFile('images')) {
            $imageFile = $request->file('images');

            // Kiểm tra nếu tệp không phải là hình ảnh hoặc không hợp lệ
            if (!$imageFile->isValid() || !in_array($imageFile->getMimeType(), ['image/jpeg', 'image/png', 'image/gif'])) {
                return redirect()->back()->withErrors(['images' => trans('validation_colors.images.invalid')]);
            }

            $validatedData['images'] = $imageFile;
        }

        // Tiến hành cập nhật màu
        try {
            $color->updateColor($validatedData, $request->file('images'));
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['images' => $e->getMessage()]);
        }

        return redirect()->route('admin_colors.index')->with('success', 'Màu được cập nhật thành công!');
    }

    // Xóa bảng màu
    public function destroy($encryptedId)
    {
        $color = Color::findByHashedId($encryptedId); // Giải mã ID
        if (!$color) {
            return redirect()->route('admin_colors.index')->withErrors(['message' => 'Bảng màu không tồn tại!']);
        }
        $color->delete();
        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được xóa thành công!');
    }
    // Tìm kiếm bảng màu

    public function timkiemcolors(Request $request)
    {
        $keyword = $request->input('keyword');
        if (strlen($keyword) > 255) {
            return redirect()->back()->withErrors(['message' => 'Từ khóa không được vượt quá 255 ký tự.']);
        }
        $colordm = Color::searchColors($keyword, 5);
        return view('admin.colors.index', compact('colordm', 'keyword'));
    }
    // Sắp xếp bảng màu
    public function sortToggle(Request $request)
    {
        $direction = $request->get('sort', 'asc');
        $colordm = Color::sortColorsByName($direction, 5);

        return view('admin.colors.index', compact('colordm'))
            ->with('success', $direction === 'asc' ? 'Sắp xếp từ A → Z thành công!' : 'Sắp xếp từ Z → A thành công!');
    }
    // Xóa nhiều bảng màu
    public function deleteSelected(Request $request)
    {
        $selectedItems = explode(',', $request->input('selected_items', ''));
        $messages = Color::deleteSelectedColors($selectedItems);

        return redirect()->route('admin_colors.index')->with('success', implode(' ', $messages));
    }
}
