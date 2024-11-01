<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use PHPUnit\Framework\Constraint\IsEmpty;
use Validator;
use App\Helpers\ValidationHelper;
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

        $validator = ValidationHelper::userValidation($request);

        if ($validator->fails()) {
            return redirect()->route('user-list.create')
                ->withErrors($validator)
                ->withInput();
        }
        if($request->has('fileUpload')){
            $file = $request->fileUpload;
           
            $file_name =$file->getClientoriginalName();
            
            $file->move(public_path('images/user/'),$file_name);
        }
  
        $password = Hash::make($request->password);
        $request->merge(['image'=>$file_name,'password'=>$password]);
        $user = User::create($request->all());
        
        return redirect()->route('user-list')->with('successUser','Thêm user thành côngg');
        
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
        $validator = ValidationHelper::userUpdateValidation($request);

        if ($validator->fails()) {
            return redirect()->route('user-list.edit',$id)
                ->withErrors($validator)
                ->withInput();
        }

        $updateUser = User::findOrFail($id);
        $olaImage = $updateUser->image;
        if($request->has('fileUpload')){
            $file = $request->fileUpload;
            $file_name = $file->getClientoriginalName();
            $file->move(public_path('images/user/'),$file_name);
        }else{
            $file_name = $olaImage;
        }
        $password = Hash::make($request->password);
        $request->merge(['image'=>$file_name,'password'=>$password]);
        $updateUser->update($request->all());
        return redirect()->route('user-list')->with('successUser','Update user thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
        $deleteUser = User::findOrFail($id);
       $deleteUser->delete();
       return redirect()->route('user-list')->with('successUser','Xóa user thành công');
    }
    public function updateEmail(Request $request)
    {
        // Lấy người dùng hiện tại
        $user = Auth::user();
    
        // Xác thực dữ liệu
        $request->validate([
            'current_email' => 'required|email',
            'new_email' => 'required|email|confirmed|unique:users,email,' . $user->id, // Kiểm tra email mới không trùng lặp, ngoại trừ chính nó
        ]);
    
        // Kiểm tra email hiện tại
        if ($request->current_email !== $user->email) {
            return redirect()->back()->with('error', 'Current email does not match our records.');
        }
    
        // Cập nhật email
        $user->email = $request->new_email;
        $user->save();
    
        return redirect()->back()->with('success', 'Email updated successfully.');
    }
    
}
