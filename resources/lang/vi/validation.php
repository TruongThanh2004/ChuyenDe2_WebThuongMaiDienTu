<?php

return [
    // Thông báo cho trường 'name'
    'required' => 'Trường này là bắt buộc.',
    'string' => 'Trường này phải là một chuỗi.',
    'min' => [
        'string' => 'Tên quá ngắn, vui lòng nhập ít nhất :min ký tự.',
    ],
    'max' => [
        'string' => 'Tên quá dài, tối đa :max ký tự.',
    ],
    'regex' => [
        'name' => 'Tên bảng màu không hợp lệ, hãy nhập ký tự chữ hoặc số, không nhập khoảng trắng đầu dòng, không nhập ký tự đặc biệt.',
    ],

    // Thông báo cho trường 'images'
    'nullable' => 'Trường này có thể bỏ trống.',
    'image' => 'Trường này phải là một tệp hình ảnh.',
    'mimes' => 'Chỉ chấp nhận ảnh định dạng: :values.',
    'dimensions' => 'Kích thước ảnh phải ít nhất 100x100 pixel.',
    'max' => [
        'file' => 'Kích thước ảnh không được vượt quá 5MB.',
    ],
    'images.invalid' => 'Tệp hình ảnh không hợp lệ, vui lòng kiểm tra lại.',
    'uploaded' => 'Upload ảnh thất bại, vui lòng thử lại hoặc kiểm tra kích thước tệp.',
    'message' => 'Từ khóa không được vượt quá 255 ký tự.'
];
