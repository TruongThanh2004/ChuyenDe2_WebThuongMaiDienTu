@extends('admin.nav')

@section('text')
<div class="form-update">
  <h1 class="title-h1">Sửa Bảng Màu</h1>
  <div class="body-form">


    <form action="{{ route('admin_colors.update', $color->color_id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Tên Màu:</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $color->name) }}" required>
<br>
        @if ($errors->has('name'))
      <div class="text-danger">
        {{ $errors->first('name') }}
      </div>
    @endif
      </div>

      <div class="form-group">
        <label for="images">Ảnh Màu:</label>
        <input type="file" name="images" id="images" class="form-control">
<br>
        @if ($errors->has('images'))
      <div class="text-danger">
        {{ $errors->first('images') }}
      </div>
    @endif

        <!-- Hiển thị ảnh hiện tại nếu có -->
        @if ($color->images)
      <div class="mt-2">
        <img src="{{ asset('images/colors/' . $color->images) }}" alt="Hình ảnh màu"class="form-img"
        style="max-width: 100px; height: 50px;"> : ảnh hiện tại
      </div>
    @endif
      </div>

      <button type="submit" class="btn btn-success">Cập Nhật</button>
    </form>

  </div>
</div>
@endsection

