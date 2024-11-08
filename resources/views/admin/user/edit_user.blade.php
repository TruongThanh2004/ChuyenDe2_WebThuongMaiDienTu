@extends('admin.nav')
@section('text')
<div class="breadcome-area">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="breadcome-list">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="breadcomb-wp">
                                <div class="breadcomb-icon">
                                    <i class="icon nalika-user"></i>
                                </div>
                                <div class="breadcomb-ctn">
                                    <h2>Update User</h2>
                                    <p>Welcome to Nalika <span class="bread-ntd">Admin Template</span></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <div class="breadcomb-report">
                                <button data-toggle="tooltip" data-placement="left" title="Download Report"
                                    class="btn"><i class="icon nalika-download"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Single pro tab start-->
<div class="single-product-tab-area mg-b-30">
    <!-- Single pro tab review Start-->
    <div class="single-pro-review-area">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="review-tab-pro-inner">
                        <ul id="myTab3" class="tab-review-design">
                            <li class="active"><a href="#description"><i class="icon nalika-edit"
                                        aria-hidden="true"></i> User Update</a></li>

                        </ul>
                        <form action="{{route('user-list.update', $user->id)}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div id="myTabContent" class="tab-content custom-product-edit">
                                <div class="product-tab-list tab-pane fade active in" id="description">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="review-content-section">
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="icon nalika-user"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" name="username"
                                                        value="{{$user->username}}" maxlength="40">
                                                </div>

                                                <div class="error_mess">
                                                    @if ($errors->has('username'))
                                                        <span class="text-danger">{{ $errors->first('username') }}</span>
                                                    @endif
                                                </div>

                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="icon nalika-user"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" name="fullname"
                                                        value="{{$user->fullname}}" maxlength="60">
                                                </div>

                                                <div class="error_mess">
                                                    @if ($errors->has('fullname'))
                                                        <span class="text-danger">{{ $errors->first('fullname') }}</span>
                                                    @endif
                                                </div>

                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-key" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" value="{{$user->password}}" maxlength="40">
                                                    <span class="input-group-addon" onclick="togglePassword()">
                                                        <i class="fa fa-eye" id="toggleEye" aria-hidden="true"></i>
                                                    </span>
                                                </div>
                                                
                                                <div class="error_mess">
                                                @if ($errors->has('password'))
                                                        <span class="text-danger">{{ $errors->first('password') }}</span>
                                                    @endif
                                                </div>

                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-envelope-o"
                                                            aria-hidden="true"></i></span>
                                                    <input type="email" class="form-control" name="email"
                                                        value="{{$user->email}}" maxlength="60">
                                                </div>

                                                <div class="error_mess">
                                                @if ($errors->has('email'))
                                                        <span class="text-danger">{{ $errors->first('email') }}</span>
                                                    @endif
                                                </div>


                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-location-arrow"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" name="address"
                                                        value="{{$user->address}}"  maxlength="100">
                                                </div>

                                                <div class="error_mess">
                                                @if ($errors->has('address'))
                                                        <span class="text-danger">{{ $errors->first('address') }}</span>
                                                    @endif
                                                </div>


                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-phone"
                                                            aria-hidden="true"></i></span>
                                                    <input type="tel" class="form-control" name="phone"
                                                        value="{{$user->phone}}" maxlength="10">
                                                </div>

                                                <div class="error_mess">
                                                @if ($errors->has('phone'))
                                                        <span class="text-danger">{{ $errors->first('phone') }}</span>
                                                    @endif
                                                </div>

                                                <div class="input-group mg-b-pro-edt">
                                                        <span class="input-group-addon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                                        <input type="text" class="form-control" name="role" value="{{$user->role}}" maxlength="1">
                                                </div>
                                                
                                                <div class="error_mess">
                                                @if ($errors->has('role'))
                                                        <span class="text-danger">{{ $errors->first('role') }}</span>
                                                    @endif
                                                </div>


                                                <div class="input-group mg-b-pro-edt">
                                                <img src="{{asset('images/user/' . $user->image)}}" alt="" width="150px" height="150px" >
                                                </div>
                                                
                                                <input type="file" name="fileUpload">


                                                <div class="error_mess">
                                                @if ($errors->has('fileUpload'))
                                                        <span class="text-danger">{{ $errors->first('fileUpload') }}</span>
                                                    @endif
                                                </div> 
                                            </div>
                                        </div>
                                       

                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <button type="submit"
                                                        class="btn btn-ctl-bt waves-effect waves-light m-r-10">Update User
                                                    </button>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @endsection
                      