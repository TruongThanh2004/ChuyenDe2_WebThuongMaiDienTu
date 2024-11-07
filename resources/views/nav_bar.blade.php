<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-commerce website</title>
    <!-- font-awesome cdn link -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="style.css">   
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    <!--Login-->
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/all.css'>
	<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.2.0/css/fontawesome.css'>
	<link rel="stylesheet" href="../DoAnTT/public/css/login.css">
	<link rel="stylesheet" href="css/login.css">
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
</head>

<body>
    @if (Session::has('success'))
        <script>
            swal("{{Session::get('success')}}", "Shopping thôii", "success");
        </script>
    @endif
    <section id="header">
        <a href="#"><img src="images/logo.png" class="logo" alt=""></a>
        <div>
            <ul id="navbar">
                <li><a  href="/">Home</a></li>
                <li><a href="{{ route('shop') }}">Shop</a></li>
                <li><a href="blog">Blog</a></li>
                <li><a href="about">About</a></li>
                <li><a href="contact">Contact</a></li>
                <li id="lg-bag"><a href="cart"><i class="far fa-shopping-bag"></i></a></li>
                <a href="#" id="close"><i class="far fa-times"></i></a>

                <li class="nav-item">
                    @if (Auth::check())
                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false"
                            class="nav-link dropdown-toggle">
                            <i class="far fa-user"></i>
                            <span class="admin-name">{{ Auth::user()->username }}</span>
                           
                        </a>
                        <ul role="menu" class="dropdown-header-top author-log dropdown-menu animated zoomIn">
                            
                            <li><a href="{{ route('profile') }}"> My Profile</a></li>
                                    <hr>
                            <li><a href="{{ route('logout') }}"> Log Out</a></li>
                        </ul>
                    @else
                        <a href="{{ route('login') }}" class="nav-link" >Đăng Nhập</a>
                    @endif
                </li>


                @if (Auth::check())
                    @if (Auth::user()->role == 2)
                        <li><a href="{{route('dashboard')}}">Dashboard</a></li>
                    @endif
                @endif
            </ul>
        </div>
        <div id="mobile">
            <a href="cart.html"><i class="far fa-shopping-bag"></i></a>
            <i id="bar" class="fas fa-outdent"></i>
        </div>
    </section>

    @yield('content')
    <!-- javascript script file link -->
    <script src="script.js"></script>
</body>

</html>