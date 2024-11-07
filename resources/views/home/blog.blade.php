@extends('home.index') <!-- Hoặc layout mà bạn đang sử dụng cho trang home -->
@section('content')
<style>
    h1{
        margin-top: -20px !important;
        
    }
    .blog-img{
        margin-top: 30px;
    }
    .blog-details h4 a{
        font-size: 50px !important; /* Thay đổi kích thước chữ tại đây */
        
    }
</style>

<section id="page-header" class="blog-header">
    <h2>#readmore</h2>
    <p>Read all case studies about our products!</p>
</section>


<section id="blog">
    <div class="container">
        @if($blogs->isEmpty())
            <div class="alert alert-warning" role="alert">
                Không có Blog nào để hiển thị.
            </div>
        @else
            @foreach($blogs as $blog)
                <div class="blog-box">
                    <div class="blog-img">
                    <img src="{{ asset('images/blog/' . $blog->image) }}" alt="Hình ảnh blog">
                    </div>
                    <div class="blog-details">
                        <h4><a href="{{ route('home.showbl', $blog->post_id) }}">{{ $blog->title }}</a></h4>
                        <p>{{ Str::limit($blog->content, 100) }}</p>
                    </div>
                    <h1>{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</h1>
                </div>
            @endforeach
        @endif
    </div>
</section>

<section id="pagination" class="section-p1">
    {{ $blogs->links('pagination::bootstrap-4') }} <!-- Sử dụng phân trang Bootstrap -->
</section>

@endsection
