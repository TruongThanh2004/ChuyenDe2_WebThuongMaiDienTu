<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý bảng màu</title>
    
</head>
<body>

    <h1>Danh sách bảng màu</h1>
    <button class="toggle-button" type="submit"  >Thêm Bảng màu</button> 
    
  
    <table>
        <thead>
            <tr>
                <th>Tên Bảng Mùa</th>
                <th>ảnh bảng màu</th>
                <th>Thao Tác </th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colorsdm as $color)
                <tr>
                    <td>{{ $color->name }}</td>
                    <td>{{ $color->images }}</td>
                    
                   
                    <td>
                        <form action="{{ route('color.destroy', $color->color_id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa bảng màu này?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Xóa</button>
                        </form>
                        <a href="{{ route('color.update', $color->color_id) }}">Cập nhật</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    
</body>
</html>
