@extends('admin.nav')

@section('text')

<head>
  <!-- CSS colors
		============================================ -->
  <link rel="stylesheet" href="{{ asset('css/color/form-list.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
</head>
<div class="form-update">
<div class="color-panner">Sửa Bảng Màu</div>
  <div class="body-form">
    <form action="{{ route('admin_colors.update', $color->hashed_id) }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf
      @method('PUT')

      <div class="form-group">
        <label for="name">Tên Màu:</label>
        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $color->name) }}" required>
        <br>
        @if ($errors->has('name'))
                <div class="text-danger">
                    {!! $errors->first('name') !!}
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
        <img src="{{ asset('images/colors/' . $color->images) }}" alt="Hình ảnh màu" class="form-img"
        style="max-width: 100px; height: 50px;"> : ảnh hiện tại
      </div>
    @endif
      </div>

      <button type="submit" class="btn btn-success">Cập Nhật</button>
    </form>
  </div>
</div>

<!-- js admin color -->
<script src="{{ asset('js/color/colors-index.js') }}"></script>
@endsection