<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Hashids\Hashids;

class Color extends Model
{
    use HasFactory;
    protected $primaryKey = 'color_id';
    protected $fillable = ['images', 'name']; // Đảm bảo rằng tên trường là 'images' không phải 'image'



    // Mã hóa ID của bảng màu
    public function getHashedIdAttribute()
    {
        // return (new Hashids)->encode($this->attributes['color_id']);
        $hashids = new Hashids('your-secret-salt');
        $rawId = $this->attributes['color_id'];

        $rawIdWithPrefix = "123456{$rawId}";

        return $hashids->encode($rawIdWithPrefix);
    }

    // Giải mã ID khi nhận vào
    public static function findByHashedId($hashedId)
    {
        $hashids = new Hashids('your-secret-salt');
        // $hashedId = substr($hashedId, 1, -1);
        $decoded = $hashids->decode($hashedId);

        if (empty($decoded)) {
            return null;
        }

        // Loại bỏ chuỗi cố định `[123456]` để lấy ID gốc
        $rawIdWithPrefix = $decoded[0];
        $rawId = str_replace('123456', '', $rawIdWithPrefix);

        return self::find($rawId);
    }

  // Lấy danh sách bảng màu với phân trang
  public static function getPaginatedColors($perPage)
  {
      return self::paginate($perPage);
  }


 // Quy tắc xác thực dữ liệu
 public static function getValidationRules()
 {
     return [
         'name' => [
             'required',
             'string',
             'min:3',
             'max:30',
             'regex:/^[\p{L}0-9]+(?:\s[\p{L}0-9]+)*$/u',
         ],
         'images' => [
             'nullable',
             'image',
             'mimes:jpg,jpeg,png,gif',
             'max:5120',
         ],
        
     ];
 }

   // Thêm bảng màu mới
   public static function createNewColor($validatedData, $imageFile)
   {
       $color = new self();
       $color->name = $validatedData['name'];

       // Xử lý ảnh (nếu có)
       if ($imageFile) {
           try {
               // Gọi phương thức upload ảnh
               $imageName = self::uploadImage($imageFile);
               $color->images = $imageName; // Lưu tên ảnh vào cơ sở dữ liệu
           } catch (\Exception $e) {
               // Nếu có lỗi xảy ra trong việc tải ảnh lên
               throw new \Exception($e->getMessage());
           }
       }

       // Lưu đối tượng màu vào cơ sở dữ liệu
       $color->save();

       return $color;
   }


 // Xóa bảng màu
 public static function deleteColor($id)
 {
     $color = self::find($id);
     if (!$color) {
         return false;
     }

     if ($color->images && file_exists(public_path('images/colors/' . $color->images))) {
         unlink(public_path('images/colors/' . $color->images));
     }

     return $color->delete();
 }



    /**
     * Tìm kiếm bảng màu dựa trên từ khóa.
     */
    public static function searchColors($keyword, $perPage)
    {
        return self::whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$keyword])
            ->orWhere('name', $keyword)
            ->paginate($perPage);
    }


 // Xóa nhiều bảng màu
 public static function deleteSelectedColors(array $ids)
 {
     $messages = [];
     foreach ($ids as $id) {
         $color = self::find($id);
         if (!$color) {
             $messages[] = "Màu với ID $id không tồn tại!";
             continue;
         }

         if ($color->images && file_exists(public_path('images/colors/' . $color->images))) {
             unlink(public_path('images/colors/' . $color->images));
         }
         $color->delete();
         $messages[] = "Màu với ID $id đã được xóa thành công!";
     }

     return $messages;
 }

 // Sắp xếp bảng màu
 public static function sortColorsByName($direction, $perPage)
 {
     return self::orderBy('name', $direction)->paginate($perPage);
 }


   // Upload ảnh
   private static function uploadImage($imageFile)
   {
       // Kiểm tra kích thước ảnh (tối đa 5MB)
       if ($imageFile->getSize() > 5 * 1024 * 1024) {
           throw new \Exception('Kích thước ảnh không được vượt quá 5MB.');
       }

       // Kiểm tra loại tệp (chỉ cho phép các định dạng ảnh hợp lệ)
       $validExtensions = ['jpg', 'jpeg', 'png', 'gif'];
       $extension = $imageFile->getClientOriginalExtension();
       if (!in_array(strtolower($extension), $validExtensions)) {
           throw new \Exception('Tệp tải lên phải là hình ảnh hợp lệ (jpg, jpeg, png, gif).');
       }

       // Tạo tên mới cho ảnh (dựa vào thời gian)
       $imageName = time() . '.' . $extension;

       // Di chuyển ảnh đến thư mục 'images/colors'
       $imageFile->move(public_path('images/colors'), $imageName);

       return $imageName;
   }

   public function updateColor(array $validatedData, $imageFile = null)
   {
       $this->name = $validatedData['name'];
   
       // Xử lý ảnh mới (nếu có)
       if ($imageFile) {
           // Xóa ảnh cũ nếu tồn tại
           if ($this->images && file_exists(public_path('images/colors/' . $this->images))) {
               unlink(public_path('images/colors/' . $this->images));
           }
   
           // Tải ảnh mới lên
           try {
               $imageName = self::uploadImage($imageFile);
               $this->images = $imageName;
           } catch (\Exception $e) {
               throw new \Exception($e->getMessage());
           }
       }
   
       // Lưu thay đổi vào cơ sở dữ liệu
       $this->save();
   }

}
