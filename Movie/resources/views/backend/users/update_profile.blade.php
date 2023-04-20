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
        <div class="row">
            <div class="col-4">
                <div class="card-body text-center">
                    <img src="{{asset('images/'.Auth::user()->image)}}" alt="avatar" class="rounded-circle img-fluid image" style="width: 150px;">
                    <h5 class="my-3">{{Auth::user()->name}}</h5>
                </div>
            </div>
            <div class="col-8">
                @if(session('message_error_change_email'))
                <div class="alert alert-danger" role="alert">
                    {{session('message_error_change_email')}}
                </div>
                @endif
                @if(session('error_update_profile_1'))
                <div class="alert alert-danger" role="alert">
                    {{session('error_update_profile_1')}}
                </div>
                @endif
                @if(session('error_update_profile_2'))
                <div class="alert alert-danger" role="alert">
                    {{session('error_update_profile_2')}}
                </div>
                @endif
                @if(session('error_update_profile_3'))
                <div class="alert alert-danger" role="alert">
                    {{session('error_update_profile_3')}}
                </div>
                @endif
                @if(session('error_update_profile_4'))
                <div class="alert alert-danger" role="alert">
                    {{session('error_update_profile_4')}}
                </div>
                @endif
                <form action="{{route('updateProfile')}}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Ảnh đại diện</label><br>
                        <input type="file" name="image" class="" id="exampleFormControlInput1" onchange="return chooseFile(this)" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Tên tài khoản</label>
                        <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Mật khẩu</label>
                        <input type="password" name="old_password" class="form-control" id="old_password" placeholder="Mật khẩu cũ" readonly="true">
                        <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Mật khẩu mới" readonly="true">
                        <input type="password" name="new_password_2" class="form-control" id="new_password_2" placeholder="Xác nhận mật khẩu" readonly="true">
                    </div>
                    <button class="btn btn-primary" type="submit">Save</button>
                </form>
            </div>
        </div>
</section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    function chooseFile(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('.image').attr('src', e.target.result);
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
    }
    $(document).ready(function() {
        $('#old_password').click(function(e) {
            e.preventDefault();
            $(this).prop('readonly', false);
            var old_password = $('#old_password').val();
            if (old_password.length > 1) {
                $('#new_password').prop('readonly', false);
            }
        });

        $('#old_password').change(function(e) {
            e.preventDefault();
            var old_password = $('#old_password').val();
            if (old_password.length > 1) {
                $('#new_password').prop('readonly', false);
            }
        });

        $('#new_password').change(function(e) {
            e.preventDefault();
            var new_password = $('#new_password').val();
            if (new_password.length > 1) {
                $('#new_password_2').prop('readonly', false);
            }
        });

    })
</script>