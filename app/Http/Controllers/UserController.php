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
   
    public $users ;


    public function __construct(){
        $this->users = new User();
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $user = $this->users->showList($request->keyword,5);

        if ($user->isEmpty()) {
            return redirect()->route('user-list')->with([
                'user' => $user, 
                'error' => 'Không tìm thấy user bạn cần tìm'
            ]);
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
        $data = $request->all();
        $this->users::addUser($data);   
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
        $user = $this->users->findOrFail($id);
        return view('admin.user.edit_user')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = ValidationHelper::userUpdateValidation($request,$request);

        if ($validator->fails()) {
            return redirect()->route('user-list.edit',$id)
                ->withErrors($validator)
                ->withInput();
        }     
        $data = $request->all();
        $this->users::updateUser($data,$id);
        return redirect()->route('user-list')->with('successUser','Update user thành công');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
      
        $deleteUser = $this->users->findOrFail($id);
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
