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
use App\Helpers\ValidationHelper;
use Illuminate\Support\Facades\Crypt;
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
            'email' => 'required|email',
        ], [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.',
        ]);
        

       $user = User::where('email',$request->email)->first();
        if($user==null){
            return redirect()->route('forgot_password')->with('error','Email chưa đăng ký tài khoản !!!');
        }
        
    
        $random_token =str_pad(mt_rand(0, 9999), 6, '0', STR_PAD_LEFT);
        $token =  Crypt::encrypt($random_token);
       $tokenData = [
            'email'=>$request->email,
            'token'=>$token,          
       ];   

       if(Password_reset_token::create($tokenData)){
       
        $change_token = Crypt::decrypt($token);
        Mail::to($request->email)->send(new ForgotPassword($user,  $change_token));    
       }
       return redirect()->route('reset-password',$token);
    }

    public function reset_password($token)
    {
        $tokenData = Password_reset_token::where('token',$token)->firstOrFail();
        $user = User::where('email',$tokenData->email)->firstOrFail();
        
     
        return view('account.reset_password');
    }
    public function check_reset_password($token,Request $request){
        $change_token = Crypt::decrypt($token);
       
        $validator = ValidationHelper::Change_passowrd($request);

        if ($validator->fails()) {
            return redirect()->route('reset-password-code',$token)
                ->withErrors($validator)
                ->withInput();
        }
        $tokenData = Password_reset_token::where('token',$token)->firstOrFail();
        $user = User::where('email',$tokenData->email)->firstOrFail();

        
      
       
        if($request->code == $change_token){
            $data = [
                'password'=>Hash::make($request->password),
            ];
            $check = $user->update($data);
        }else{
            return redirect()->route('reset-password-code',$token)->with('error','Mã code không đúng');
        }
       
        return redirect()->route('login')->with('success','Lấy lại mật khẩu thành công');
    }

    public function save(Request $request)  {


        $validator = ValidationHelper::register($request);

        if ($validator->fails()) {
            return redirect()->route('register')
                ->withErrors($validator)
                ->withInput();
        }





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

        $validator = ValidationHelper::login($request);

        if ($validator->fails()) {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput();
        }



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
