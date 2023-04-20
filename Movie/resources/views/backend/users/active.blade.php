@extends('backend.layouts.master')
@section('content')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('backend/img/normal-breadcrumb.jpg')}}">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <div class="normal__breadcrumb__text">
                        <h2>Xác nhận mật khẩu</h2>
                    </div>
                </div>
            </div>
        </div>
    </section>
<section class="login spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login__form">
                    <h3>Xác nhận mật khẩu</h3>
                    @if(session('active_error'))
                    <p class="text-white">{{session('active_error')}}</p>
                    @endif
                    <form action="{{route('post_active',['id'=>$id,'token'=>$token])}}" method="post">
                        @csrf
                        <div class="input__item">
                            <input type="password" name="new_password" placeholder="Mật khẩu">
                            <span class="icon_lock"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="new_password_2" placeholder="Xác nhận mật khẩu">
                            <span class="icon_lock"></span>
                        </div>
                        <button type="submit" class="site-btn">Lấy mật khẩu</button>
                    </form>
                    <a href="{{route('login')}}" class="forget_pass">Đăng nhập</a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login__register">
                    <h3>Bạn chưa có tài khoản?</h3>
                    <a href="{{route('register')}}" class="primary-btn">Đăng ký</a>
                </div>
            </div>
        </div>
        <div class="login__social">
            <div class="row d-flex justify-content-center">
                <div class="col-lg-6">
                    <div class="login__social__links">
                        <span>or</span>
                        <ul>
                            <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With
                                    Facebook</a></li>
                            <li><a href="#" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection