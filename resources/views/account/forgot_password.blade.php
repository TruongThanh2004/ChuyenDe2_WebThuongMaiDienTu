<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ForgotPassword </title>
   
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center vh-100">
        <div class="card text-center" style="width: 400px;">
            <div class="card-header h5 text-white bg-primary">Password Reset</div>
            <div class="card-body px-5">
                <p class="card-text py-2">
                    Enter your email address and we'll send you an email with instructions to reset your password.
                </p>
                
                  <form action="{{route('check_forgot_password')}}" method="POST">
                  @csrf
                    <div class="form-outline d-flex align-items-center">
                        <label class="form-label mb-0 me-2" for="typeEmail">Email:</label>
                        <input type="email" id="typeEmail" class="form-control my-3" style="flex: 1;" name="email"/>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Reset password</button>
                  </form>
                             
              
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{route('login')}}" style="text-decoration: none;">Login</a>
                    <a href="{{route('register')}}" style="text-decoration: none;">Register</a>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>