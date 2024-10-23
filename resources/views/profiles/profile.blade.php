<!--Website: wwww.codingdung.com-->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodingDung | Profile Template</title>
    <link rel="stylesheet" href="{{asset('css/profile/styleProfile.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container light-style flex-grow-1 container-p-y">
        
       <div class="header-container">
        <a href="{{Auth::user()->role == 2 ?route('dashboard'):route('home')}}"><i class="fas fa-arrow-alt-circle-left"></i></a>
       <h4 class="font-weight-bold py-3 mb-4">
            Account settings
        </h4>
       </div>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action active" data-toggle="list"
                            href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action " data-toggle="list"
                            href="#account-change-password">Change password</a>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade active show" id="account-general">
                            <div class="card-body media align-items-center">
                                <img id="user-image" src="{{ asset('images/user/' . Auth::user()->image) }}"
                                    alt="User Image" class="d-block ui-w-80">
                                <form action="#">
                                    <div class="media-body ml-4">
                                        <label class="btn btn-outline-primary">
                                            Upload new photo
                                            <input type="file" class="account-settings-fileinput" accept="image/*"
                                                style="display: none;">
                                        </label> &nbsp;
                                        <button type="button" id="reset-button"
                                            class="btn btn-default md-btn-flat">Reset</button>
                                    </div>
                            </div>

                            <hr class="border-light m-0">
                            <div class="card-body">
                                <div class="form-group">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control mb-1" value="{{Auth::user()->username}}"
                                        name="username">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{Auth::user()->fullname == '' ? 'Hãy cập nhật đẩy đủ tên!!' : '' }}"
                                        value="{{Auth::user()->fullname == '' ? '' : Auth::user()->fullname }}"
                                        name="fullname">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">E-mail</label>
                                    <input type="text" class="form-control mb-1" value="{{Auth::user()->email}}">
                                    <!-- <div class="alert alert-warning mt-3">
                                        Your email is not confirmed. Please check your inbox.<br>
                                        <a href="javascript:void(0)">Resend confirmation</a>
                                    </div> -->
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Address</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{Auth::user()->address == '' ? 'Hãy cập nhật địa chỉ!!' : '' }}"
                                        value="{{Auth::user()->address == '' ? '' : Auth::user()->address }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control"
                                        placeholder="{{Auth::user()->phone == '' ? 'Hãy cập nhật số điện thoại!!' : ''}}"
                                        value="{{Auth::user()->phone == '' ? '' : Auth::user()->phone }}" required  maxlength="10">

                                </div>
                            </div>
                            <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary">Save</button>&nbsp;
                                    <button type="button" class="btn btn-default">Cancel</button>
                                </div>
                        </div>

                        




                        <div class="tab-pane fade" id="account-change-password">
                        <div class="card-body pb-2">
                            <form action="" method="POST"> 
                                @csrf
                                <div class="form-group">
                                    <label class="form-label">Current password</label>
                                    <input type="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">New password</label>
                                    <input type="password" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">Repeat new password</label>
                                    <input type="password" class="form-control" required>
                                </div>

                                <div class="text-right mt-3">
                                    <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>&nbsp;
                                    <button type="button" class="btn btn-default">Hủy</button>
                                </div>
                            </form>
                        </div>
                    </div>



                    </div>



                    














                    <script data-cfasync="false"
                        src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
                    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
                    <script type="text/javascript">
                    </script>
                    <script src="{{asset('js/profileUpload.js')}}"></script>
</body>

</html>