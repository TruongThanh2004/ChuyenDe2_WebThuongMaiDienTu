<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'full_name',
        'email',
        'address',
        'phone',
        'role',
        'image',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

<<<<<<< HEAD

    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        
        $this->attributes['role'] = '1';
        $this->attributes['image'] = 'user.jpg';
        $this->attributes['fullname'] = '';
        $this->attributes['phone'] = '';
        $this->attributes['address'] = '';
=======
    public function blogs()
    {
        return $this->hasMany(Blog::class, 'user_id', 'user_id'); // Khóa ngoại user_id tham chiếu đến user_id trong bảng users
>>>>>>> CRUD_Blog
    }
}
