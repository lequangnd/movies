@extends('admin.layouts.master')
@section('content')
<div class="container-fluid deleteCountry" id="container-wrapper" data-url="{{route('deleteCountry')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Quốc gia</h1>
    </div>

    <div class="row addCountry" data-url="{{route('addCountry')}}">
        <div class="col-lg-6 mb-4 updateCountry" data-url="{{route('updateCountry')}}">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm quốc gia</h6>
                </div>
                <div class="card-body">
                    <form id="submit_country">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên quốc gia</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách quốc gia</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Quốc gia</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($countries as $c)
                                <tr>
                                    <td class="name">{{$c->name}}</td>
                                    <td><button class="btn btn-sm btn-warning btn-update" data-id="{{$c->id}}" disabled>Sửa</button>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{$c->id}}" disabled>Xóa</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <!--Row-->

        <!-- Modal Logout -->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to logout?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                        <a href="login.html" class="btn btn-primary">Logout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submit_country').submit(function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var url = $('.addCountry').data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    name: name,
                },
                success: function(data) {
                    swal("", "Thêm quốc gia phim thành công", "success").then(function() {
                        window.location = "";
                    });
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.name').click(function(e) {
            e.preventDefault();
            var name = $(this).text();
            $('#name').val(name);
            $('.btn-submit').prop('disabled',true);
            $('.btn-update').prop('disabled', true);
            $('.btn-delete').prop('disabled', true);
            $(this).parents('tr').find('.btn-update').prop('disabled', false);
            $(this).parents('tr').find('.btn-delete').prop('disabled', false);
        })

        $('.btn-update').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var name = $('#name').val();
            if (name == "") {
                alert('Tên quốc gia không được để trống');
                return false;
            }
            var url = $('.updateCountry').data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    name: name,
                },
                success: function(data) {
                    swal("", "Sửa quốc gia phim thành công", "success").then(function() {
                        window.location = "";
                    });
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.deleteCountry').data('url');
            swal({
                    title: "Bạn chắc chắn muốn xóa?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'get',
                            url: url,
                            data: {
                                id: id
                            },
                            success: function(data) {
                                swal('', 'Xóa quốc gia thành công', 'success').then(function() {
                                    window.location = "";
                                })
                            },
                            error: function() {
                                alert('lỗi');
                            }
                        });
                    }
                });
        });
    });
</script>