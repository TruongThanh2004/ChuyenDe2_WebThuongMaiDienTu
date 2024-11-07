<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>register</title>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <style>
        .error_mess{
            color: red;
            font-size: 15px;
        }
    </style>
</head>

<body>

    <video autoplay muted loop id="backgroundVideo">
        <source src="images/clip_may_tinh.mp4" type="video/mp4">
    </video>
    <script>
        @if (Session::has('error'))
		swal("", "{{Session::get('error')}}", "error");
		@endif
    </script>
  
    <div class="container">
        <div class="bubbles"></div>
        <form action="{{route('saveUser')}}" method="POST">
         @csrf
            <div class="form">
                <h2>đăng ký</h2>
                <div class="inputBox">
                    <input type="text" id="username" name="username" required value="{{old('username')}}">
                    <span>User Name</span>
                    <i></i>
                </div>

                <div class="error_mess">
                        @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
                        @endif
                    </div>

                <div class="inputBox">
                    <input type="email" id="email" name="email" required value="{{old('email')}}">
                    <span>email</span>
                    <i></i>
                </div>


                <div class="error_mess">
                        @if ($errors->has('email'))
                            <span class="text-danger">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                <div class="inputBox">
                    <input type="password" id="password" name="password1" required  value="{{old('password1')}}">
                    <span>mật khẩu</span>
                    <i></i>
                </div>

                <div class="error_mess">
                        @if ($errors->has('password1'))
                            <span class="text-danger">{{ $errors->first('password1') }}</span>
                        @endif
                    </div>

                <div class="inputBox">
                    <input type="password" id="password" name="password2" required>
                    <span> nhập lại mật khẩu</span>
                    <i></i>
                </div>

                <div class="error_mess">
                        @if ($errors->has('password2'))
                            <span class="text-danger">{{ $errors->first('password2') }}</span>
                        @endif
                    </div>

                <input type="submit" value="đăng ký">
                <div class="links">
                    <a href="login">Đăng nhập</a>
                </div>
            </div>
            <div class="meteor"></div>
    </div>
    </form>
</body>

</html>