@extends('admin_colors.nav')
@section('text')

<div class="card" style="margin:20px;">
  <div class="card-header">Sửa Bảng Màu</div>
  <div class="card-body">

    <form action="{{ route('admin_colors.update', ['id' =>  $colorsdm->id]) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="ame"> Tên Danh Mục :</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ $colorsdm->name }}" required>

            <label>colors_Image</label><br>
        <input type="file" name="color_image" id="color_image" class="form-control" value="{{$colorsdm->images}}" required><br>
        </div>


        <button type="submit" class="btn btn-success">Sửa Bảng Màu</button>
    </form>

  </div>
</div>
@endsection
