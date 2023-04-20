@extends('backend.layouts.master')
@section('content')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('backend/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Đăng nhập</h2>
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
                    <h3>Login</h3>
                    @if(session('message_active_account'))
                    <p class="text-success">{{session('message_active_account')}}</p>
                    @endif
                    @if(session('succcess_gmail'))
                    <p class="text-success">{{session('succcess_gmail')}}</p>
                    @endif
                    @if(session('error'))
                    <p class="text-danger">{{session('error')}}</p>
                    @endif
                    @if(session('yes'))
                    <p class="text-success">{{session('yes')}}</p>
                    @endif
                    @if(session('ok'))
                    <p class="text-success">{{session('ok')}}</p>
                    @endif
                    @if(session('register'))
                    <p class="text-success">{{session('register')}}</p>
                    @endif
                    @if(session('active_check'))
                    <p class="text-danger">{{session('active_check')}} <a href="{{route('active_account_login')}}">click vào đây</a></p>
                    @endif
                    @if(session('actived_login'))
                    <p class="text-success">{{session('actived_login')}}</p>
                    @endif
                    <form action="{{route('addLogin')}}" method="post" name="login" onsubmit="return validate()">
                        @csrf
                        <div class="input__item">
                            <input type="email" name="email" placeholder="Email">
                            <span class="icon_mail"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="password" placeholder="Mật khẩu">
                            <span class="icon_lock"></span>
                        </div>
                        <div>
                            <input type="checkbox" name="remember" value="" id="flexCheckDefault">
                            <label class="form-check-label text-white" for="flexCheckDefault">
                                Ghi nhớ tôi
                            </label>
                        </div>
                        <button type="submit" class="site-btn">Đăng nhập</button>
                    </form>
                    <a href="{{route('forget_password')}}" class="forget_pass">Quên nhập khẩu?</a>
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
                            <li><a href="{{route('facebookRedirect')}}" class="facebook"><i class="fa fa-facebook"></i> Đăng nhập với
                                    Facebook</a></li>
                            <li><a href="{{route('googleRedirect')}}" class="google"><i class="fa fa-google"></i> Đăng nhập với Google</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
    function validate() {
        if (document.login.email.value == "") {
            alert('Email không được để trống');
            return false;
        }
        if (document.login.password.value == "") {
            alert('Mật không được để trống');
            return false;
        }
    }
</script>