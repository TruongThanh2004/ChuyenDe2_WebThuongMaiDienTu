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


    // ham them màu sắc
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
    {
        // Kiểm tra xem đối tượng còn tồn tại hay không
        $color = Color::find($id);

        if (!$color) {
            // Nếu không tìm thấy, trả về thông báo lỗi và yêu cầu tải lại trang
            return redirect()->route('admin_colors.index')
                             ->withErrors(['message' => ' update thất bại !!!Đối tượng không tồn tại. Vui lòng tải lại trang.']);
        }

        // Xác thực dữ liệu từ yêu cầu
        $request->validate([
            'name' => [
                'required',
                'string',
                'min:3',
                'max:30',
                'regex:/^[\p{L}0-9]+(?:\s[\p{L}0-9]+)*$/u',
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

        // Cập nhật thông tin màu sắc
        $color->name = $request->input('name');

        if ($request->hasFile('images')) {
            $image = $request->file('images');

            if (!$image->isValid()) {
                return redirect()->back()->withInput()
                                      ->withErrors(['images' => 'Tệp hình ảnh không hợp lệ, vui lòng kiểm tra lại.']);
            }

            // Xóa ảnh cũ nếu có
            if ($color->images && file_exists(public_path('images/colors/' . $color->images))) {
                unlink(public_path('images/colors/' . $color->images));
            }

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/colors'), $imageName);

            $color->images = $imageName;
        }

        $color->save();
        return redirect()->route('admin_colors.index')->with('success', 'Màu đã được cập nhật thành công!');
    }
    // hàm xóa một bảng màu

    public function destroy($id)
    {
        $color = Color::find($id);
    
        if (!$color) {
            return redirect()->route('admin_colors.index')
                             ->withErrors(['message' => ' xóa thất bại !!!Đối tượng không tồn tại! ']);
        }
    
        try {
            if ($color->images && file_exists(public_path('images/colors/' . $color->images))) {
                unlink(public_path('images/colors/' . $color->images));
            }
    
            $color->delete();
            return redirect()->route('admin_colors.index')->with('success', 'Màu đã được xóa thành công!');
        } catch (\Exception $e) {
            return redirect()->route('admin_colors.index')
                             ->withErrors(['message' => 'Xóa thất bại. Vui lòng thử lại!']);
        }
    }
    

     // hàm tìm kiếm theo ap dụng Full-Text Search cho cột name
     public function timkiemcolors(Request $request)
     {
         $keyword = $request->input('keyword'); // Nhận từ khóa từ người dùng
     
         // Kiểm tra độ dài từ khóa
         if (strlen($keyword) > 255) {
             return redirect()->back()->withErrors(['message' => 'Từ khóa không được vượt quá 255 ký tự.']);
         }
     
         // Kiểm tra nếu người dùng không nhập từ khóa
         if (empty($keyword)) {
             return redirect()->back()->with('notification', 'Bạn chưa nhập từ khóa để tìm kiếm.');
         }
     
         // Sử dụng Full-Text Search cho cột `name`
         $colordm = Color::whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$keyword])
             ->orWhere('color_id', $keyword)
             ->paginate(5);
     
         // Kiểm tra nếu không có kết quả
         if ($colordm->isEmpty()) {
             return view('admin.colors.index')->with([
                 'colordm' => $colordm,
                 'keyword' => $keyword,
                 'message' => 'Không có kết quả nào.'
             ]);
         }
     
         return view('admin.colors.index', compact('colordm', 'keyword'));
     }
 
    
     public function deleteSelected(Request $request)
     {
         // Lấy danh sách ID từ request
         $selectedItems = $request->input('selected_items');
     
         // Chia nhỏ chuỗi ID thành mảng
         $ids = explode(',', $selectedItems);
         
         // Khởi tạo mảng để lưu các thông báo
         $messages = [];
     
         foreach ($ids as $id) {
             $color = Color::find($id);
     
             if (!$color) {
                 $messages[] = "Màu với ID $id không tồn tại!";
                 continue; // Bỏ qua ID này và tiếp tục với ID tiếp theo
             }
     
             try {
                 // Xóa ảnh nếu tồn tại
                 if ($color->images && file_exists(public_path('images/colors/' . $color->images))) {
                     unlink(public_path('images/colors/' . $color->images));
                 }
     
                 // Xóa màu
                 $color->delete();
                 $messages[] = "Màu với ID $id đã được xóa thành công!";
             } catch (\Exception $e) {
                 $messages[] = "Xóa màu với ID $id thất bại. Vui lòng thử lại!";
             }
         }
     
         // Chuyển hướng về trang danh sách với thông báo
         return redirect()->route('admin_colors.index')->with('success', implode(' ', $messages));
     }
}
