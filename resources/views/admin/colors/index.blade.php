@extends('admin.nav')

@section('text')
<div class="container">
    <div class="row" style="margin:20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <br /><br />
                    <div class="table-responsive">
                        <form action="{{ route('admin_colors.create') }}" method="GET">
                            <button type="submit" class="btn btn-success">Add colors</button>
                        </form>
                    </div>
                    <br>
                    <br>

                    <table class="table">
                        <thead>
                            <h1>Danh sách bảng màu</h1>
                            <tr>
                                <th>ID</th>
                                <th>Tên</th>
                                <th>Ảnh</th>
                                <th>Hành Động</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($colordm as $color)
                                <tr>
                                    <td>{{ $color->color_id }}</td>
                                    <td>{{ $color->name }}</td>
                                    <td>
                                        <img src="{{ asset('images/colors/'.$color->images) }}" width="70" height="100" alt="Color Image">
                                    </td>
                                    <td>
                                    <a href="{{ route('admin_colors.edit', $color->color_id) }}" class="btn btn-primary btn-sm">Sửa</a>

                                        <form action="{{ route('admin_colors.destroy', $color->color_id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $colordm->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection