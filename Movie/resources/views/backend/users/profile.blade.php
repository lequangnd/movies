@extends('backend.layouts.master')
@section('content')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('backend/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Quản lý tài khoản</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Normal Breadcrumb End -->
<!-- Blog Section Begin -->
<section style="background-color: #eee;">
    <div class="container py-5">
        @if(session('success_change_email'))
        <div class="alert alert-success" role="alert">
            {{session('success_change_email')}}
        </div>
        @endif
        @if(session('message_change_email_gmail'))
        <div class="alert alert-primary" role="alert">
            {{session('message_change_email_gmail')}}
        </div>
        @endif
        @if(session('success_change_email_gmail'))
        <div class="alert alert-success" role="alert">
            {{session('success_change_email_gmail')}}
        </div>
        @endif
        <div class="row">
            <div class="col-lg-4">
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <img src="{{asset('images/'.Auth::user()->image)}}" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">
                        <h5 class="my-3">{{Auth::user()->name}}</h5>
                        <div class="d-flex justify-content-center mb-2">
                            <a href="{{route('update_profile')}}"><button type="button" class="btn btn-primary btn-image">Chỉnh sửa</button></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Tên tài khoản</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">{{Auth::user()->name}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Email</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">{{Auth::user()->email}}</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-sm-3">
                                <p class="mb-0">Mật khẩu</p>
                            </div>
                            <div class="col-sm-8">
                                <p class="text-muted mb-0">********</p>
                            </div>
                        </div>
                        <hr>
                        <div>
                            @if(session('update_profile_success'))
                            <div class="alert alert-success" role="alert">
                                {{session('update_profile_success')}}
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection