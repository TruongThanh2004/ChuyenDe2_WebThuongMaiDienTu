@extends('admin.nav')
@section('text')

<div class="card" style="margin:20px;">
  <div class="card-header">Sửa Bảng Màu</div>
  <div class="card-body">

  <form action="{{ route('admin_colors.update', $color->color_id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Tên Màu:</label>
    <input type="text" name="name" id="name" class="form-control" value="{{ $color->name }}" required><br>

    <label for="images">Ảnh Màu:</label>
    <input type="file" name="images" id="images" class="form-control" value="{{ $color->images }}"><br>

    <button type="submit" class="btn btn-success">Cập Nhật</button>
</form>

  </div>
</div>
@endsection


