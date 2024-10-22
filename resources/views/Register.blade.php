<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>register</title>
</head>

<body>
    <video autoplay muted loop id="backgroundVideo">
        <source src="images/clip_may_tinh.mp4" type="video/mp4">
    </video>
    @if (session('success'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{session('success')}}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="container">
        <div class="bubbles"></div>
        <form action="{{route('saveUser')}}" method="POST">
         @csrf
            <div class="form">
                <h2>đăng ký</h2>
                <div class="inputBox">
                    <input type="text" id="username" name="username" required>
                    <span>tên đăng nhập</span>
                    <i></i>
                </div>
                <div class="inputBox">
                    <input type="email" id="email" name="email" required>
                    <span>email</span>
                    <i></i>
                </div>
                <div class="inputBox">
                    <input type="password" id="password" name="password1" required>
                    <span>mật khẩu</span>
                    <i></i>
                </div>
                <div class="inputBox">
                    <input type="password" id="password" name="password2" required>
                    <span> nhập lại mật khẩu</span>
                    <i></i>
                </div>
                <input type="submit" value="đăng ký">
                <div class="links">
                    <a href="#">quên mật khẩu</a>
                    <a href="login">Đăng nhập</a>
                </div>
            </div>
            <div class="meteor"></div>
    </div>
    </form>
</body>

</html>