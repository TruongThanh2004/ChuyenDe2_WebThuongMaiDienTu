<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Tên bảng trong database (nếu không dùng tên chuẩn của Laravel)
    protected $table = 'orders';

    // Khóa chính của bảng
    protected $primaryKey = 'order_id';

    // Các cột có thể được thêm/sửa bởi người dùng
    protected $fillable = [
        'user_id',
        'product_id',
        'status',
        'total_amount',
    ];

    // Quan hệ với bảng Users (Mỗi Order thuộc về 1 User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Quan hệ với bảng Products (Mỗi Order thuộc về 1 Product)
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    // Quan hệ với bảng OrderItems (1 Order có nhiều OrderItems)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }
}
