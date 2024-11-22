@extends('home.index')
@section('content')
<style>
     /* Tối ưu giao diện tiêu đề blog */
     h1 {
        margin-top: -20px !important;
    }

    .blog-img {
        margin-top: 30px;
    }

    .blog-details h4 a {
        font-size: 50px !important;
    }

    .custom-pagination {
        margin: 20px auto;
        text-align: center;
        width: 100%;
    }

    .custom-pagination ul {
        justify-content: center;
    }

    .blog-box {
    border: 2px solid #ddd;  
    border-radius: 8px;      
    padding: 15px;           
    margin-bottom: 100px;     
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); 
    }

    .blog-box:hover {
        border-color: #007bff;  
        box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3); 
    }
</style>

<section id="page-header" class="blog-header">
    <h2>Bài viết yêu thích</h2>
 
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
                        <p>{{ Str::limit($blog->content, 50) }}</p>
                       
                    </div>
                    <h1>{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</h1>
                </div>
            @endforeach
        @endif
    </div>

</section>
@endsection
