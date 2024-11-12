@extends('admin.nav')

@section('text')

<head>
    <!-- CSS colors
		============================================ -->
    <link rel="stylesheet" href="{{ asset('css/color/form-list.css') }}">



</head>
<div class="form-add">
    <div class="color-panner">Tạo Màu Mới</div>
    <div class="form-body">
        <form action="{{ route('admin_colors.store') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf

            <!-- Tên Màu -->


            <label for="name" class="text-name">Tên Màu:</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                placeholder="Nhập tên" required><br>

            @if ($errors->has('name'))
                <div class="text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif

            <!-- Ảnh Màu -->
            <label for="images" class="text-name">Ảnh Màu:</label>
            <input type="file" name="images" id="images" class="form-control"><br>

            @if ($errors->has('images'))
                <div class="text-danger">
                    {{ $errors->first('images') }}
                </div>
            @endif

            <br>
            <button type="submit" class="btn btn-success">Thêm Màu</button>
        </form>
    </div>
</div>
<!-- js admin color -->
<script src="{{ asset('js/color/colors-index.js') }}"></script>
@endsection