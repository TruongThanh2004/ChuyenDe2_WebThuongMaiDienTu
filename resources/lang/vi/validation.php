<?php

return [
   

    'name.required' => 'Tên bảng màu không được bỏ trống.',
    'name.regex' => 'Tên bảng màu không hợp lệ, hãy nhập ký tự chữ hoặc số, không nhập khoảng trắng đầu dòng hoặc ký tự đặc biệt.',
    'name.min' => 'Tên quá ngắn, vui lòng nhập ít nhất 3 ký tự.',
    'name.max' => 'Tên quá dài, tối đa 30 ký tự.',
    'images.mimes' => 'Chỉ chấp nhận ảnh định dạng: jpg, jpeg, png, gif.',
    'images.max' => 'Kích thước ảnh không được vượt quá 5MB.',
    'images.image' => 'Trường này phải là một tệp hình ảnh.',
    'images.uploaded' => 'Upload ảnh thất bại, vui lòng kiểm tra kích thước tệp và thử lại.',



    // Thông báo cho trường 'product_name'
    'product_name' => [
        'required' => 'Tên sản phẩm không được bỏ trống.',
        'string' => 'Tên sản phẩm không hợp lệ. Vui lòng nhập ký tự chữ hoặc số.',
        'regex' => 'Tên sản phẩm không hợp lệ. Vui lòng nhập ký tự chữ hoặc số.',
        'min' => 'Tên sản phẩm phải có ít nhất 3 ký tự.',
        'max' => 'Tên sản phẩm không được vượt quá 100 ký tự.',
    ],

    // Thông báo cho trường 'description'
    'description' => [
        'required' => 'Mô tả sản phẩm không được bỏ trống.',
        'string' => 'Mô tả sản phẩm không hợp lệ. Vui lòng nhập ký tự chữ hoặc số.',
        'regex' => 'Mô tả sản phẩm không hợp lệ. Vui lòng nhập ký tự chữ hoặc số.',
        'min' => 'Mô tả phải có ít nhất 10 ký tự.',
        'max' => 'Mô tả không được vượt quá 500 ký tự.',
    ],

    // Thông báo cho trường 'price'
    'price' => [
        'required' => 'Giá sản phẩm không được bỏ trống.',
        'numeric' => 'Giá sản phẩm không hợp lệ. Vui lòng nhập số dương.',
        'min' => 'Giá sản phẩm phải là số dương.',
    ],

    // Thông báo cho trường 'color_id'
    'color_id' => [
        'required' => 'Màu sắc sản phẩm không hợp lệ. Vui lòng chọn màu sắc.',
        'exists' => 'Không tìm thấy màu sắc, vui lòng thêm màu sắc.',
    ],

    // Thông báo cho trường 'quantity'
    'quantity' => [
        'required' => 'Số lượng sản phẩm không được bỏ trống.',
        'integer' => 'Số lượng sản phẩm không hợp lệ. Vui lòng nhập số dương.',
        'min' => 'Số lượng sản phẩm phải là số dương.',
    ],

    // Thông báo cho trường 'image'
    'image' => [
        'nullable' => 'Trường này có thể bỏ trống.',
        'image' => 'File không hợp lệ. Vui lòng chọn các định dạng file: .jpg, .jpeg, .png.',
        'mimes' => 'File không hợp lệ. Vui lòng chọn các định dạng file: .jpg, .jpeg, .png.',
        'max' => 'Kích thước tệp không được vượt quá 5MB.',
    ],

    // Thông báo chung
    'regex' => [
        'alpha_num_space' => 'Vui lòng chỉ nhập ký tự chữ, số và khoảng trắng.',
    ],
    

    'message' => 'Từ khóa không được vượt quá 255 ký tự.'

];
