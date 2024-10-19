@extends('admin_colors.nav')
@section('text')


<div class="card" style="margin:20px;">
  <div class="card-header">Tạo danh mục mới</div>
  <div class="card-body">

      <form action="{{ route('admin_colors.AddNewcolors') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>Tên bảng màu</label><br>
        <input type="text" name="name" id="name" class="form-control" required><br>

        <label>colors_Image</label><br>
        <input type="file" name="color_image" id="color_image" class="form-control" required><br>



        <input type="submit" value="Thêm màu" class="btn btn-success"><br>
    </form>

  </div>
</div>
@endsection



