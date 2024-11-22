<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'name', 'comment'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
    /**
     * Thêm bình luận mới.
     *
     * @param array $data
     * @return static
     */
    public static function addComment(array $data)
    {
        return self::create($data);
    }

    /**
     * Cập nhật bình luận.
     *
     * @param string $newComment
     * @return bool
     */
    public function updateComment(string $newComment)
    {
        $this->comment = $newComment;
        return $this->save();
    }

    /**
     * Kiểm tra quyền người dùng đối với bình luận.
     *
     * @param string $username
     * @return bool
     */
    public function isOwnedByUser(string $username)
    {
        return $this->name === $username;
    }
}
