<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Color;

// hàm hiển thị 7 bảng màu trên 1 trang
class ColorController extends Controller
{
    public function index()
    {
        $perPage = 7;
        $colordm = Color::paginate($perPage);

        return view('admin.colors.index', compact('colordm'));
    }

    // đường dẫn vào form thêm bảng màu mới
    public function create()
    {
        return view('admin.colors.create_colors');
    }



    public function AddNewcolors(Request $request)
    {
        // Xác thực dữ liệu từ yêu cầu

        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[\p{L}0-9]+(?:\s[\p{L}0-9]+)*$/u', // Cho phép chữ cái (có dấu), số và khoảng trắng, không cho phép khoảng trắng ở đầu
            ],
            'images' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif', 
                'max:5120', 

            ],
        ], [

            'name.required' => 'Tên bảng màu không được bỏ trống.',
            'name.regex' => 'Tên bảng màu không hợp lệ, hãy nhập ký tự chữ hoặc số , không nhập khoảng trắng đầu dòng , không nhập ký tự đặt biệt',
            'name.min' => 'Tên quá ngắn, vui lòng nhập ít nhất 3 ký tự.',
            'name.max' => 'Tên quá dài, tối đa 30 ký tự.',
            'images.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif.',
            'images.max' => 'Kích thước ảnh không được vượt quá 5MB.',
            'images.image' => 'Trường này phải là một tệp hình ảnh.',
            'images.uploaded' => 'Upload ảnh thất bại, vui lòng kiểm tra kích thước tệp và thử lại.',
        ]);
        $color = new Color();
        $color->name = $request->input('name');

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('images')) {
            $image = $request->file('images');

            //kiểm tra Thông báo lỗi nếu tệp không hợp lệ
            if (!$image->isValid()) {
                return redirect()->back()->withInput()->withErrors(['images' => 'Tệp hình ảnh không hợp lệ, vui lòng kiểm tra lại.']);
            }
            // Tạo tên file duy nhất cho ảnh
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/colors'), $imageName);

            // Lưu chỉ tên file vào database
            $color->images = $imageName;
        }
        $color->save();
        return redirect()->route('admin_colors.index')->with('success', 'Màu được thêm thành công!');
    }



    // đường dẫn vào update
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        return view('admin.colors.update_colors', compact('color'));
    }

    
    // hàm update bảng màu
    public function update(Request $request, $id)
    { // Xác thực dữ liệu từ yêu cầu
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[\p{L}0-9]+(?:\s[\p{L}0-9]+)*$/u', // Cho phép chữ cái (có dấu), số và khoảng trắng
            ],
            'images' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,gif',
                'max:5120',
            ],
        ], [

            'name.required' => 'Tên bảng màu không được bỏ trống.',
            'name.regex' => 'Tên bảng màu không hợp lệ, hãy nhập ký tự chữ hoặc số, không nhập khoảng trắng đầu dòng hoặc ký tự đặc biệt.',
            'name.min' => 'Tên quá ngắn, vui lòng nhập ít nhất 3 ký tự.',
            'name.max' => 'Tên quá dài, tối đa 30 ký tự.',
            'images.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif.',
            'images.max' => 'Kích thước ảnh không được vượt quá 5MB.',
            'images.image' => 'Trường này phải là một tệp hình ảnh.',
            'images.uploaded' => 'Upload ảnh thất bại, vui lòng kiểm tra kích thước tệp và thử lại.',
        ]);

        // Tìm đối tượng Color theo ID
        $color = Color::findOrFail($id);
        $color->name = $request->input('name');


        // Xử lý upload ảnh nếu có
        if ($request->hasFile('images')) {
            $image = $request->file('images');

            if (!$image->isValid()) {
                return redirect()->back()->withInput()->withErrors(['images' => 'Tệp hình ảnh không hợp lệ, vui lòng kiểm tra lại.']);
            }
            //kiểm tra Xóa ảnh cũ nếu có
            if ($color->images) {
                $oldImagePath = public_path('images/colors/' . $color->images);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Xóa tệp ảnh cũ
                }
                $imageName = time() . '.' . $image->getClientOriginalExtension();


                $image->move(public_path('images/colors'), $imageName);


                $color->images = $imageName;
            }
        }
        $color->save();
        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được cập nhật thành công!');
    }





    // hàm xóa một bảng màu
    public function destroy($id)
    {
        $color = Color::findOrFail($id);


        // Kiểm tra nếu hình ảnh tồn tại và xóa nó
        if ($color->images && file_exists(public_path('images/colors/' . $color->images))) {
            unlink(public_path('images/colors/' . $color->images)); // unlink đường dẫn tuyệt đối trong laravel
        }
        $color->delete();
        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được xóa thành công!');
    }

    // hàm tìm kiếm theo ID, name
    public function timkiemcolors(Request $request)
{
    $keyword = $request->input('keyword'); // Nhận từ khóa từ người dùng

   
    $colors = Color::where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('color_id', $keyword)
                    ->paginate(7);

    // Trả về view cùng với kết quả phân trang
    return view('admin.colors.index', compact('colors', 'keyword'));
}

}
