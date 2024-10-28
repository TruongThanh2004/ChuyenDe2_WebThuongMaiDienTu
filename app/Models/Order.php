<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'order_id'; // Khóa chính là 'order_id'
    protected $fillable = ['user_id', 'status', 'total_amount'];

    // Quan hệ 1-n với OrderItem
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'order_id');
    }

    // Quan hệ n-1 với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }
}
