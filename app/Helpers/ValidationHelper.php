<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Validator;

class ValidationHelper
{
    public static function userValidation($request)
    {
        return Validator::make($request->all(), [
            'username' => 'required|max:255',
            'fullname' => 'required|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|min:6|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|digits:10|numeric',
            'role' => 'required|max:2|numeric',
        ], [
            'username.required' => 'Vui lòng nhập tên của bạn.',
            'username.max' => 'Tên không được vượt quá 255 ký tự.',
            'fullname.required' => 'Vui lòng nhập đầy đủ tên của bạn.',
            'fullname.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email của bạn.',
            'email.unique' => 'Email đã được sử dụng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu không được ít hơn 6 ký tự.',
            'password.max' => 'Email không được vượt quá 255 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Email không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'phone.digits' => 'Số điện thoại phải có chính xác 10 chữ số.',
            'phone.numeric' => 'Số điện thoại chỉ được chứa các ký tự số.',
            'role.required' => 'Vui lòng nhập role',
            'role.max' => 'Không được nhập quá 2 số',
            'role.numeric' => 'Không được nhập chữ',
        ]);
    }



    public static function userUpdateValidation($request)
    {
        return Validator::make($request->all(), [
            'username' => 'required|unique:users,username|max:255',
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:6|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|digits:10|numeric',
            'role' => 'required|max:2|numeric',
        ], [
            'username.required' => 'Vui lòng nhập tên của bạn.',
            'username.unique'=>'Tên đã được sử dụng',
            'username.max' => 'Tên không được vượt quá 255 ký tự.',
            'fullname.required' => 'Vui lòng nhập đầy đủ tên của bạn.',
            'fullname.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email của bạn.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu không được ít hơn 6 ký tự.',
            'password.max' => 'Email không được vượt quá 255 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Email không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'phone.digits' => 'Số điện thoại phải có chính xác 10 chữ số.',
            'phone.numeric' => 'Số điện thoại chỉ được chứa các ký tự số.',
            'role.required' => 'Vui lòng nhập role',
            'role.max' => 'Không được nhập quá 2 số',
            'role.numeric' => 'Không được nhập chữ',
        ]);
    }






    public static function updateProfileValidation($request)
    {
        return Validator::make($request->all(), [
            'username' => 'required|max:255',
            'fullname' => 'required|max:255',
            'email' => 'required|email|max:255',
            'address' => 'required|max:255',
            'phone' => 'required|digits:10|numeric',
            'password' => 'required|min:4|max:255',
          
        ], [
            'username.required' => 'Vui lòng nhập tên của bạn.',
            'username.max' => 'Tên không được vượt quá 255 ký tự.',
            'fullname.required' => 'Vui lòng nhập đầy đủ tên của bạn.',
            'fullname.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Vui lòng nhập email của bạn.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu không được ít hơn 6 ký tự.',
            'password.max' => 'Email không được vượt quá 255 ký tự.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.max' => 'Email không được vượt quá 255 ký tự.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'phone.digits' => 'Số điện thoại phải có chính xác 10 chữ số.',
            'phone.numeric' => 'Số điện thoại chỉ được chứa các ký tự số.',
            
        ]);
    }



    public static function Change_passowrd($request)
    {
        return Validator::make($request->all(), [
            'code'=>'required|digits:6',
            'password' => 'required|min:4|max:255',
            'confirm_password'=>'required|same:password'
        ], [
            'code.required' => 'Vui lòng nhập mã code.',
            'code.digits' => 'Mã code chính xác phải 6 số.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu không được ít hơn 4 ký tự.',
            'password.max' => 'Mật khẩu không được vượt quá 255 ký tự.',
            'confirm_password.required' => 'Vui lòng xác nhận mật khẩu.',
            'confirm_password.same' => 'Mật khẩu xác nhận không khớp với mật khẩu.'
        ]);
    }
}
