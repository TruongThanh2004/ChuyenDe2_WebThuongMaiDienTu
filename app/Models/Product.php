<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'description',
        'price',
        'quantity',
        'category_id',
        'color_id',
        'image1',
        'image2',
        'image3',
        'rating'
    ];
}

