<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }


        input[type=text],
        input[type=password] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;

            box-sizing: border-box;
        }

        button {
            background-color: #04AA6D;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            margin-bottom: 10px;
        }

        button:hover {
            opacity: 0.8;
        }

        .cancelbtn {
            width: auto;
            padding: 10px 18px;
            background-color: #f44336;
        }

        .imgcontainer {
            text-align: center;
            margin: 24px 0 12px 0;
        }

        img.avatar {
            width: 40%;
            border-radius: 50%;
        }

        .container {
            width: 50%;
            padding: 16px;
            text-align: center;
            border: 2px solid black;
            margin: auto;
            display: flex;
            flex-direction: column;

            align-items: center;
        }

        span.psw {
            float: right;
            padding-top: 16px;
        }
        .error_mess{
            color: red;
        }
    </style>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>
<body>
    <script>
		@if (Session::has('error'))
		swal("", "{{Session::get('error')}}", "error");
		@endif
    </script>
    <form action="" method="POST">
        @csrf
        <div class="container">
            <h2>Reset-Password</h2>
            <input type="text" placeholder="Code" name="code" value="{{old('code')}}">

            <div class="error_mess">
                @if ($errors->has('code'))
                    <span class="text-danger">{{ $errors->first('code') }}</span>
                @endif
            </div>

            <input type="text" placeholder="Your Password" name="password" value="{{old('password')}}">

            <div class="error_mess">
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <input type="password" placeholder="Your confirm password" name="confirm_password" >

            <div class="error_mess">
                @if ($errors->has('confirm_password'))
                    <span class="text-danger">{{ $errors->first('confirm_password') }}</span>
                @endif
            </div>

            <button type="submit">Reset</button>

            <a href="{{route('home')}}" style="text-decoration: none;">Về trang chủ</a>

        </div>

    </form>

</body>

</html>