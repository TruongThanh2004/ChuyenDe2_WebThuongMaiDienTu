<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Tên bảng trong database (nếu không dùng tên chuẩn của Laravel)
    protected $table = 'order_items';

    // Khóa chính của bảng
    protected $primaryKey = 'order_items_id';

    // Các cột có thể được thêm/sửa bởi người dùng
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Quan hệ với bảng Orders (Nhiều OrderItem thuộc về 1 Order)
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'order_id');
    }

    // Quan hệ với bảng Products (Mỗi OrderItem thuộc về 1 Product)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
