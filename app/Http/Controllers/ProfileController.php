<?php

namespace App\Http\Controllers;

use Hash;
use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
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
        $mess =null;
        if($request->password==null){
            $mess = "Không được để trống trường password!!";
            return redirect()->route('profile')->with('error',$mess);
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
      
       

        if(Hash::check($request->password,$updateUser->password)){
            $mess = "Update thành công";
            $password = Hash::make($request->password);
            $request->merge(['image'=>$file_name,'password'=>$password]);
            $updateUser->update($request->all());
            return redirect()->route('profile')->with('success',$mess);
        }else{
            $mess = "Mật khẩu không chính xác";
            return redirect()->route('profile')->with('error',$mess);
        } 

       
        
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }




}
