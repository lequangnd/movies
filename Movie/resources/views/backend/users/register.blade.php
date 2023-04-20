@extends('backend.layouts.master')
@section('content')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('backend/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Đăng ký tài khoản</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="signup spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="login__form">
                    <h3>Đăng ký tài khoản</h3>
                    @if(session('check_email'))
                    <p class="text-danger">{{session('check_email')}}</p>
                    @endif
                    @if(session('error_password'))
                    <p class="text-danger">{{session('error_password')}}</p>
                    @endif
                    <form action="{{route('addRegister')}}" method="post" name="register" onsubmit="return validate()">
                        @csrf
                        <div class="input__item">
                            <input type="text" name="email" placeholder="Email">
                            <span class="icon_mail"></span>
                        </div>
                        <div class="input__item">
                            <input type="text" name="username" placeholder="Tên người dùng">
                            <span class="icon_profile"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="password" placeholder="Mật khẩu">
                            <span class="icon_lock"></span>
                        </div>
                        <div class="input__item">
                            <input type="password" name="password_2" placeholder="Xác nhận mật khẩu">
                            <span class="icon_lock"></span>
                        </div>
                        <button type="submit" class="site-btn">Đăng ký</button>
                    </form>
                    <h5>Bạn đã có tài khoản? <a href="{{route('login')}}">Đăng nhập!</a></h5>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="login__social__links">
                    <h3>Login With:</h3>
                    <ul>
                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i> Sign in With Facebook</a>
                        </li>
                        <li><a href="#" class="google"><i class="fa fa-google"></i> Sign in With Google</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script>
    function validate()
    {
        if(document.register.email.value=="")
        {
            alert('Email không được để trống');
            return false;
        }
        if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(document.register.email.value))
        {
            alert('email không đúng định dạng');
            return false;
        }
        if(document.register.username.value=="")
        {
            alert('Tên tài khoản không được để trống');
            return false;
        }
        if(document.register.password.value=="")
        {
            alert('Mật khẩu không được để trống');
            return false;
        }
    }
</script>