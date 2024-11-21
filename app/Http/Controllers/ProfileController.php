<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;
use App\Helpers\ValidationHelper;

class ProfileController extends Controller
{


    public $users ;


    public function __construct(){
        $this->users = new User();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('profiles.profile');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = ValidationHelper::updateProfileValidation($request);
        if ($validator->fails()) {
            return redirect()->route('profile')
                ->withErrors($validator)
                ->withInput();
        }
        $mess = null;
        if ($request->password == null) {
            $mess = "Không được để trống trường password!!";
            return redirect()->route('profile')->with('error', $mess);
        }
        $updateUser = User::findOrFail($id);
        if (Hash::check($request->password, $updateUser->password)) {
            $mess = "Update thành công";
            $data = $request->all();
            $this->users->updateUser($data,$id);
            return redirect()->route('profile')->with('success', $mess);
        } else {
            $mess = "Mật khẩu không chính xác";
            return redirect()->route('profile')->with('error', $mess);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }



    public function change_password(Request $request, string $id){
        $user = User::findOrFail($id);
        $mess = '';

      if(Hash::check($request->current_password,$user->password)){
        if($request->new_password == $request->repeat_password){
            $passwordNew  = Hash::make($request->new_password);
            $request->merge(['password'=>$passwordNew]);
            $user->update($request->all());
            $mess = "Đổi mật khẩu thành công";
            return redirect()->route('profile')->with('success',$mess);
        }else{
            $mess = "Mật khẩu không giống nhau";
            return redirect()->route('profile')->with('error',$mess);
        }

      }else{
        $mess = "Mật khẩu không đúng";
        return redirect()->route('profile')->with('error',$mess);
      }
    }




}
