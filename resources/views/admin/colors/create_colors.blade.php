@extends('admin.nav')

@section('text')
<div class="form add-color" >
    <div class="color-panner">Tạo Màu Mới</div>
    <div class="form-body">
        <form action="{{ route('admin_colors.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label for="name" class="text-name">Tên Màu:</label>
            <input type="text" name="name" id="name" class="form-control"  placeholder="Nhập tên" required><br>

            <label for="images" class="text-name">Ảnh Màu:</label>
            <input type="file" name="images" id="images" class="form-control"><br>

            <button type="submit" class="btn btn-success">Thêm Màu</button>
        </form>
      
    </div>
</div>
@endsection
<style>
    .add-color {
      
        padding: 20px;
      margin-top:100px;
      margin-left: 20%;
      
   
    }
    .form-control{
      max-width: 500px;
      
    }
   .form-body{
    margin-top: 50px;
  color: white;
   }
    .color-panner {
        font-weight: bold;
        font-size: 1.5rem; 
        color: white;
        text-align: 20%;
    }
    .text-name{
      margin-top: 20px;
    }
    .text-center {
        text-align: center; /* Căn giữa nội dung */
    }
    input:required {
        outline: none; /* Loại bỏ viền mặc định của trình duyệt */
    }

    /* Nếu cần thêm một màu nền khác cho trường yêu cầu */
    input:required:invalid {
        border-color: whitesmoke; 
    }
</style>