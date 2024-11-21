<?php

return [
    // Thông báo cho trường 'name'
    'name' => [
        'required' => 'Vui lòng nhập tên, không được bỏ trống <i class="fas fa-spinner fa-spin"></i> <i class="fas fa-smile"></i>',
        'string' => 'Trường này phải là một chuỗi.',
        'min' => 'Tên quá ngắn, vui lòng nhập ít nhất :min ký tự.',
        'max' => 'Tên quá dài, tối đa 30 ký tự.',
        'regex' => 'Tên bảng màu không hợp lệ, hãy nhập ký tự chữ hoặc số, không nhập khoảng trắng đầu dòng, không nhập ký tự đặc biệt.',
    ],
    
    // Thông báo cho trường 'images'
    'images' => [
        'nullable' => 'Trường này có thể bỏ trống.',
        'image' => 'Trường này phải là một tệp hình ảnh.',
        'mimes' => 'Chỉ chấp nhận ảnh định dạng: :values.',
        'dimensions' => 'Kích thước ảnh phải ít nhất 100x100 pixel.',
        'max' => 'Kích thước ảnh không được vượt quá 5MB.',
        'invalid' => 'Tệp hình ảnh không hợp lệ, vui lòng kiểm tra lại.',
        'uploaded' => 'Upload ảnh thất bại, vui lòng thử lại hoặc kiểm tra kích thước tệp.',
    ],
];
