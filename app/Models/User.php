<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Request;
use Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'image',
        'username',
        'fullname',
        'password',
        'email',
        'address',
        'phone',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        
        $this->attributes['role'] = '1';
        $this->attributes['image'] = 'user.jpg';
        $this->attributes['fullname'] = '';
        $this->attributes['phone'] = '';
        $this->attributes['address'] = '';
    }


    public static function showList($keyword,$perpage){
        $user = User::paginate($perpage);   

        if(isset($keyword) && $keyword != ''){
            $user = User::where('username','like','%' .$keyword.'%')
                        ->orWhere('fullname','like','%' .$keyword.'%')
                        ->orWhere('id','like','%' .$keyword.'%')
                        ->orWhere('email','like','%' .$keyword.'%')
                        ->orWhere('address','like','%' .$keyword.'%')
            ->paginate($perpage);
        }      
        return $user; 
    }

    public static function addUser($data){
        
    if($data['fileUpload']!=null){
            $file = $data['fileUpload'];
            $file_name =$file->getClientoriginalName();
            $file->move(public_path('images/user/'),$file_name);
        }
        $data['image'] = $file_name;
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        
    }

    public static function updateUser($data,$id){
        
        $updateUser = User::findOrFail($id);
        $olaImage = $updateUser->image;
        if (isset($data['fileUpload']) && $data['fileUpload'] !== null) {
            $file = $data['fileUpload'];
            $file_name = $file->getClientOriginalName();
            $file->move(public_path('images/user/'), $file_name);
        } else {
            $file_name = $olaImage;
        }
        $data['password'] = Hash::make($data['password']);
        $data['image'] = $file_name;
        $updateUser->update($data);
    }


   
}
