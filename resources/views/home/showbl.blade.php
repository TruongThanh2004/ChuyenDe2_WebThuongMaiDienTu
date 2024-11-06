@extends('home.index')

@section('content')
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
