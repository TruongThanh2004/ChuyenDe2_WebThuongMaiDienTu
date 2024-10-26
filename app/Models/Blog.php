<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    // Specify the table associated with the model (optional if following Laravel conventions)
    protected $table = 'blogs';

    // The attributes that are mass assignable
    protected $fillable = ['title', 'content', 'image', 'user_id'];

    // Optionally define the primary key if it's not the default 'id'
    protected $primaryKey = 'post_id';

    // Disable auto-incrementing if the primary key is not an auto-incrementing integer
    public $incrementing = true;

    // The data type of the primary key (if it is not an integer)
    protected $keyType = 'int';

    // Define a relationship with the User model
    // app/Models/Blog.php
    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
