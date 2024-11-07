<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\Password_reset_token;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Hash;
use Mail;
use Password;
class AccountController extends Controller
{
    public function login(){
        return view('account.login');
    }
    public function register(){
        return view('account.register');
    }
    public function forgot_password(){
        return view('account.forgot_password');
    }

    public function check_forgot_password(Request $request){
        $request->validate([
            'email' => 'required|exists:users',
        ]);
       
       $user = User::where('email',$request->email)->first();
       
       $token = \Str::random(50);
       $tokenData = [
            'email'=>$request->email,
            'token'=>$token,
       ];   
       if(Password_reset_token::create($tokenData)){
       
        Mail::to($request->email)->send(new ForgotPassword($user,$token));
    
       }
    }

    public function reset_password($token)
    {
        $tokenData = Password_reset_token::where('token',$token)->firstOrFail();
        $user = User::where('email',$tokenData->email)->firstOrFail();
        
     
        return view('account.reset_password');
    }
    public function check_reset_password($token,Request $request){
        request()->validate([
            'password'=>'required|min:4',
            'confirm_password'=>'required|same:password',
        ]);
        $tokenData = Password_reset_token::where('token',$token)->firstOrFail();
        $user = User::where('email',$tokenData->email)->firstOrFail();

        $data = [
            'password'=>Hash::make($request->password),
        ];
        $check = $user->update($data);
        return redirect()->route('login')->with('success','Lấy lại mật khẩu thành công');
    }

    public function save(Request $request)  {
        $user = new User();
        $error = null;
        $user->username = $request->username;
        $user->email = $request->email;
         if($user->where('email',$user->email)->exists()){
            $error = "Email đã được sử dụng !!";
            return redirect()->route('register')->with('error', $error);
        }
        if($user->where('username',$user->username)->exists()){
            $error = "Tài khoản đã tồn tại!!";
            return redirect()->route('register')->with('error', $error);
       
       }
       if($request->password1 === $request->password2){
            $user->password = Hash::make($request->password1);
            $user->save();
            return redirect()->route('login')->with('success', 'Đăng ký thành công!');
       }
       else{
            $error = "Mật khẩu không giống nhau xin nhập lại mật khẩu";
            return redirect()->route('register')->with('error', $error);
       }
    }


    public function doLogin(Request $request){
        $login = [  
            'username' => $request->username,           
            'password' =>$request->password,
        ];
        $error = null;

            
                if(Auth::attempt($login)&&Auth::user()->role===2){                 
                return redirect()->route('dashboard')->with('successLogin','Đăng nhập thành công');
                }else if(Auth::attempt($login)&&Auth::user()->role===1){   
                    
                return redirect()->route('home')->with('success',"Đăng nhập thành công ");
                
                }else{  
                     if(empty($login['username'])||empty($login['password'])){
                        $error = "Không được để trống trường nào cả";
                     }else{
                        $error= "Mật khẩu hoặc username saii!!";
                     }
                  
                  
                       
                    
                    return redirect()->route('login')->with('error',$error);
             }          
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('home');
    }
}
