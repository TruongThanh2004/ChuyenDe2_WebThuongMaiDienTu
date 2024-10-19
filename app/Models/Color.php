<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    use HasFactory;
    protected $primaryKey = 'color_id';
    protected $fillable = ['images', 'name']; // Đảm bảo rằng tên trường là 'images' không phải 'image'
  
}
