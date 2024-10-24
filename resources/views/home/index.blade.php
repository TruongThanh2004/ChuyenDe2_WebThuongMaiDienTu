<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-commerce website</title>

    <!-- font-awesome cdn link -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
<<<<<<< HEAD

=======
>>>>>>> Crud_color
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- custom css file link -->
    <link rel="stylesheet" href="style.css">

    <script src="js/vendor/modernizr-2.8.3.min.js"></script>




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
                <li><a class="active" href="/">Home</a></li>
                <li><a href="shop">Shop</a></li>
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


    <section id="newsletter" class="section-p1 section-m1">
        <div class="newstext">
            <h4>Sign Up For Newsletter</h4>
            <p>Get E-mail updates about our latest shop and <span>special offers.</span></p>
        </div>
        <div class="form">
            <input type="text" placeholder="Your email address">
            <button class="normal">Sign Up</button>
        </div>
    </section>

    <footer class="section-p1">
        <div class="col">
            <img class="logo" src="images/logo.png" alt="">
            <h4>Contact</h4>
            <p><strong>Address:</strong> Lahore, Pakistan - 54840</p>
            <p><strong>Phone:</strong> +92-321-4655990</p>
            <p><strong>Hours:</strong> 10:00 - 18:00, Mon - Sat</p>
            <div class="follow">
                <h4>Follow us</h4>
                <div class="icon">
                    <i class="fab fa-facebook-f"></i>
                    <i class="fab fa-twitter"></i>
                    <i class="fab fa-instagram"></i>
                    <i class="fab fa-pinterest-p"></i>
                    <i class="fab fa-youtube"></i>
                </div>
            </div>
        </div>
        <div class="col">
            <h4>About</h4>
            <a href="#">About us</a>
            <a href="#">Delivery Information</a>
            <a href="#">Privacy Policy</a>
            <a href="#">Terms & Conditions</a>
            <a href="#">Contact Us</a>
        </div>
        <div class="col">
            <h4>My Account</h4>
            <a href="#">Sign In</a>
            <a href="#">View Cart</a>
            <a href="#">My Wishlist</a>
            <a href="#">Track My Order</a>
            <a href="#">Help</a>
        </div>
        <div class="col install">
            <h4>Install App</h4>
            <p>From App Store or Google Play</p>
            <div class="row">
                <img src="images/pay/app.jpg" alt="">
                <img src="images/pay/play.jpg" alt="">
            </div>
            <p>Secured Payment Gateway</p>
            <img src="images/pay/pay.png" alt="">
        </div>
        <div class="copyright">
            <p>Created By Muhammad Awais | All Rights Reserved | &#169; 2023</p>
        </div>
    </footer>

    <!-- javascript script file link -->
    <script src="script.js"></script>
</body>

</html>