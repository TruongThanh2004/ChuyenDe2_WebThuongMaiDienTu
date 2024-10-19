<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::paginate(5);     
        if(isset($request->keyword) && $request->keyword != ''){
            $user = User::where('username','like','%' .$request->keyword.'%')
                        ->orWhere('fullname','like','%' .$request->keyword.'%')
                        ->orWhere('id','like','%' .$request->keyword.'%')
                        ->orWhere('email','like','%' .$request->keyword.'%')
                        ->orWhere('address','like','%' .$request->keyword.'%')
            ->paginate(5);
        }
        return view('admin.users')->with('user',$user);
    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.user.add_user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if($request->has('fileUpload')){
            $file = $request->fileUpload;
           
            $file_name =$file->getClientoriginalName();
            
            $file->move(public_path('images/user/'),$file_name);
        }
        $request->merge(['image'=>$file_name]);
        User::create($request->all());
        return redirect()->route('user-list')->with('success','Thêm user thành côngg');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit_user')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
        $updateUser = User::findOrFail($id);
        $olaImage = $updateUser->image;
        if($request->has('fileUpload')){
            $file = $request->fileUpload;
            $file_name = $file->getClientoriginalName();
            $file->move(public_path('images/user/'),$file_name);
        }else{
            $file_name = $olaImage;
        }
        $request->merge(['image'=>$file_name]);
        $updateUser->update($request->all());
        return redirect()->route('user-list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
        $deleteUser = User::findOrFail($id);
       $deleteUser->delete();
       return redirect()->route('user-list');
    }


    


    public function save(Request $request)  {
        $user = new User();
        $error = null;
        $user->username = $request->username;
        $user->email = $request->email;
       if($request->password1 === $request->password2){
            $user->password = Hash::make($request->password1);
            $user->save();
            return redirect()->route('register')->with('success', 'User registered successfully!');
       }else{
            $error = "Mật khẩu không giống nhau xin nhập lại mật khẩu";
            return redirect()->route('register')->with('success', $error);
       }
    }


    public function doLogin(Request $request){
        $login = [  
            'username' => $request->username,           
            'password' =>$request->password
        ];
        if(Auth::attempt($login)){
         return redirect()->route('dashboard');
        }
    }


    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

  
}
