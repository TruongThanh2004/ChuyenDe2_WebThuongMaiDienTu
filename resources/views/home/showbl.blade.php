@extends('home.index')

@section('content')
<style>
    .blog-detail {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    font-family: Arial, sans-serif;
    word-wrap: break-word;
}

.blog-detail h1 {
    font-size: 32px;
    margin-bottom: 20px;
}

.blog-detail p {
    font-size: 16px;
    line-height: 1.6;
    margin-bottom: 20px;
    white-space: normal;
}

.blog-image {
    max-width: 100%;
    height: auto;
    display: block;
    margin-bottom: 20px; /* Tạo khoảng cách dưới ảnh */
}

.blog-detail h3 {
    font-size: 18px;
    font-weight: bold;
    color: #555;
}

</style>
<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('style.css') }}">
<link rel="stylesheet" href="{{ asset('css/blog.css') }}">
<script src="{{ asset('js/vendor/modernizr-2.8.3.min.js') }}"></script>
<script src="{{ asset('script.js') }}"></script>
<div class="blog-detail">
    <h1>{{ $blog->title }}</h1>
    <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh blog" class="blog-image"> 
    <p>{{ $blog->content }}</p>
    <h3>Ngày đăng: {{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</h3>
</div>
@endsection
