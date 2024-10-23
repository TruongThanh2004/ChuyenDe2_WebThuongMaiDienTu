@extends('admin.nav')

@section('text')
    <h1>Kết quả Tìm Kiếm</h1>

    @if ($colors->isEmpty())
        <div class="alert alert-danger">Không tìm thấy bảng màu phù hợp!</div>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Màu</th>
                    <th>Ảnh</th>
                </tr>
            </thead>
            <tbody>
                @foreach($colors as $color)
                    <tr>
                        <td>{{ $color->id }}</td>
                        <td>{{ $color->name }}</td>
                        <td>
                            @if($color->images)
                                <img src="{{ asset('images/colors/' . $color->images) }}" 
                                     alt="{{ $color->name }}" 
                                     style="max-width: 100px; height: 50px;">
                            @else
                                Không có ảnh
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân trang -->
        <div class="d-flex justify-content-center">
            {{ $colors->appends(['keyword' => request('keyword')])->links() }}
        </div>
    @endif
@endsection
