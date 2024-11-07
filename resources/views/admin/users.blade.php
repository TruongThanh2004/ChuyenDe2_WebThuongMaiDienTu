@extends('admin.nav')
@section('text')


<!-- Mobile Menu end -->
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
                                    <h2>User List</h2>
                                    <p>Welcome <span class="bread-ntd">Admin Template</span></p>
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


<div class="product-status mg-b-30">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="col-lg-6 col-md-7 col-sm-6 col-xs-12">
                    <div class="header-top-menu tabl-d-n hd-search-rp">
                        <div class="breadcome-heading">
                            <form role="search" class="" action="">
                                <input type="text" placeholder="Search..." class="form-control" id="search"
                                    name="keyword">
                                <button type="sumbit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="product-status-wrap">
                    <h4>User List</h4>
                    <div class="add-product">
                        <a href="{{route('user-list.create')}}">Add New User</a>
                    </div>
                    @if (session('success'))    
                   <span><p> <p style="color:red"> {{session('success')}}</></p></span>   
                                
                    @endif

                  
                    <table>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>User Name</th>
                            <th>Full Name</th>
                            <th>PassWord</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Role</th>
                            <th></th>
                            <th></th>

                        </tr>
                        @foreach ($user as $data_user)                                                  
                            <tr>
                                <td>{{ $data_user->id}}</td>
                                <td><img src="{{asset('images/user/' . $data_user->image)}}" alt=""></td>
                                <td>{{ $data_user->username}}</td>
                                <td>{{ $data_user->fullname}}</td>
                                <td>
                                    {{ $data_user->password}}
                                </td>
                                <td>{{ $data_user->email}}</td>
                                <td>{{ $data_user->address}}</td>
                                <td>{{ $data_user->phone}}</td>
                                <td>{{$data_user->role == 1 ? 'User':'Admin'}}</td>
                                <td>
                                    <form action="{{route('user-list.edit', $data_user->id)}}">

                                        <button data-toggle="tooltip" title="Edit" class="pd-setting-ed"><i
                                                class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    </form>

                                </td>
                                <td>

                                    <form action="{{ route('user-list.destroy', $data_user->id) }}" method="POST"
                                        onsubmit="return confirm('Bạn có muốn xóa loại user này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button data-toggle="tooltip" title="Xóa" class="pd-setting-ed"><i
                                                class="fa fa-trash-o" aria-hidden="true"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <div class="custom-pagination">


                        {{ $user->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
