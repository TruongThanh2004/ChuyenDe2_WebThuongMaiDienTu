@extends('nav_bar')
@section('content')
	<!-- partial:index.partial.html -->
	<video autoplay muted loop id="backgroundVideo">
		<source src="images/clip_may_tinh.mp4" type="video/mp4">
	</video>
	<script>
		@if (Session::has('error'))
		swal("", "{{Session::get('error')}}", "error");
		@endif

		
        @if (Session::has('success'))
		swal("", "{{Session::get('success')}}", "success");
		@endif
    </script>
		
	</script>
	<div class="container">
		<div class="screen">
			<div class="screen__content">
				<form class="login" action="{{route('doLogin')}}" method="POST">
					@csrf
					<div class="login__field">
						<i class="login__icon fas fa-user"></i>
						<input type="text" class="login__input" placeholder="User name" name="username">

					</div>
					<div class="login__field">
						<i class="login__icon fas fa-lock"></i>
						<input type="password" class="login__input" placeholder="Password" name="password">
					</div>
					<button class="button login__submit">
						<span class="button__text">Log In Now</span>
						<i class="button__icon fas fa-chevron-right"></i>
					</button>
				</form>
				<div class="social-login">
					<div class="social-icons">
					<a class="register" href="{{route('register')}}">Register</a>
					<a class="register" href="{{route('forgot_password')}}">Forgot Password</a>
						<!-- <a href="#" class="social-login__icon fab fa-instagram"></a>
					<a href="#" class="social-login__icon fab fa-facebook"></a>
					<a href="#" class="social-login__icon fab fa-twitter"></a> -->
					</div>
				</div>
			</div>
			<div class="screen__background">
				<span class="screen__background__shape screen__background__shape4"></span>
				<span class="screen__background__shape screen__background__shape3"></span>
				<span class="screen__background__shape screen__background__shape2"></span>
				<span class="screen__background__shape screen__background__shape1"></span>
			</div>
		</div>
	</div>
	<!-- partial -->

	@endsection

