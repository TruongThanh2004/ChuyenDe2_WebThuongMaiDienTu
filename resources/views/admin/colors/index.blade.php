@extends('admin_colors.nav')

@section('text')
<div class="container">
    <div class="row" style="margin:20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a href="{{ route('admin_colors.create') }}" class="btn btn-success btn-sm"
                        title="Add danh muc">Add Danh Mục sản phẩm</a>
                    <br /><br />
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>id</th>
                                    <th>name</th>
                                    <th>Images</th>
                                    <th>Thao Tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($colordm as $colors)
                                    <tr>
                                        <td>{{ $colors->id }}</td>
                                        <td>{{ $colors->name }}</td>

                                        <td>
                                            <a href="{{ route('admin_danhmucSP.edit', $colors->id) }}"
                                                class="btn btn-primary btn-sm">Edit</a>
                                            <form method="POST" action="{{ route('admin_danhmucSP.destroy', $colors->id) }}"
                                                accept-charset="UTF-8" style="display:inline">
                                                @method('DELETE')
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm" title="Delete Category"
                                                    onclick="return confirm('Bạn có chắc chắn muốn xóa danh mục màu này?')">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <!-- !! ($categories->links()) !! -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
