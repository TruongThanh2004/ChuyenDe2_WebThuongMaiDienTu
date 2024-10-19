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
                                    <h2>Add New User</h2>
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
                                        aria-hidden="true"></i> Product Edit</a></li>

                        </ul>
                        <form action="{{route('user-list.store')}}" method="POST" enctype="multipart/form-data">
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
                                                        placeholder="Nhập User Name" id="username">
                                                 
                                                 <small class="error-message"></small>
                                             
                                                </div>
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="icon nalika-user"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" name="fullname"
                                                        placeholder=" Nhập Full Name" id="fullname">
                                                        <small class="error-message" ></small>
                                                </div>
                                                
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon">
                                                        <i class="fa fa-key" aria-hidden="true"></i>
                                                    </span>
                                                    <input type="password" class="form-control" id="password"
                                                        name="password" placeholder="Nhập Password">
                                                    <span class="input-group-addon" onclick="togglePassword()">
                                                        <i class="fa fa-eye" id="toggleEye" aria-hidden="true"></i>
                                                    </span>
                                                    <small class="error-message"></small>
                                                </div>
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-envelope-o"
                                                            aria-hidden="true"></i></span>
                                                    <input type="email" class="form-control" name="email"
                                                        placeholder="Nhập Email" id="email">
                                                    <small class="error-message"></small>
                                                </div>
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-location-arrow"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" name="address"
                                                        placeholder="Nhập Address" id="address">
                                                    <small class="error-message"></small>
                                                </div>
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-phone"
                                                            aria-hidden="true"></i></span>
                                                    <input type="tel" class="form-control" name="phone"
                                                        placeholder="Nhập Phone" id="phone">
                                                    <small class="error-message"></small>
                                                </div>
                                                <div class="input-group mg-b-pro-edt">
                                                    <span class="input-group-addon"><i class="fa fa-user"
                                                            aria-hidden="true"></i></span>
                                                    <input type="text" class="form-control" name="role"
                                                        placeholder="Nhập role" id="role">
                                                    <small class="error-message"></small>
                                                </div>



                                                <input type="file" name="fileUpload" id="fileUpload">

                                            </div>
                                        </div>



                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-center custom-pro-edt-ds">
                                                    <button type="submit"
                                                        class="btn btn-ctl-bt waves-effect waves-light m-r-10"
                                                        id="submit_user">Add User
                                                    </button>


                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                       

                        @endsection