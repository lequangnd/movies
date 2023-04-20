@extends('admin.layouts.master')
@section('content')
<div class="container-fluid deleteLevel" id="container-wrapper" data-url="{{route('deleteLevel')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Cấp bậc người dùng</h1>
    </div>

    <div class="row addLevel" data-url="{{route('addLevel')}}">
        <div class="col-lg-6 mb-4 updateLevel" data-url="{{route('updateLevel')}}">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm cấp bậc</h6>
                </div>
                <div class="card-body">
                    <form id="submit_level" name="level">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên cấp bậc</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giảm giá (%)</label>
                            <input type="text" name="discount" class="form-control" id="discount" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tổng tiền nạp được tăng cấp</label>
                            <input type="text" name="quantity" class="form-control" id="quantity" aria-describedby="emailHelp">
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
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách loại phim</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tên cấp bậc</th>
                                    <th>Giảm giá (%)</th>
                                    <th>Tổng tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($level as $l)
                                <tr>
                                    <td class="name">{{$l->name}}</td>
                                    <td class="discount">{{$l->discount}}</td>
                                    <td class="quantity">{{$l->quantity}}</td>
                                    <td><button class="btn btn-sm btn-warning btn-update" data-id="{{$l->id}}" disabled>Sửa</button>
                                        @if($l->id!=1)
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{$l->id}}" disabled>Xóa</button>
                                        @endif
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
        $('#submit_level').submit(function(e) {
            e.preventDefault();
            var name = $('#name').val();
            var discount = $('#discount').val();
            var quantity = $('#quantity').val();
            if (name == "") {
                alert('Cấp bậc không được để trống');
                return false;
            }
            if (discount == "") {
                alert('Giảm giá không được để trống');
                return false;
            }
            if (quantity == "") {
                alert('Số lần nạp không được để trống');
                return false;
            }
            var url = $('.addLevel').data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    name: name,
                    discount: discount,
                    quantity: quantity
                },
                success: function(data) {
                    swal("", "Thêm cấp bậc thành công", "success").then(function() {
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
            var discount = $(this).parents('tr').find('.discount').text();
            var quantity = $(this).parents('tr').find('.quantity').text();
            $('#name').val(name);
            $('#discount').val(discount);
            $('#quantity').val(quantity);
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
            var discount = $('#discount').val();
            var quantity = $('#quantity').val();
            var url = $('.updateLevel').data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    name: name,
                    discount: discount,
                    quantity: quantity
                },
                success: function(data) {
                    swal("", "Sửa thành công", "success").then(function() {
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
            var url = $('.deleteLevel').data('url');
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
                                if(data['message'])
                                {
                                    swal('', 'Không thể xóa vì có người dùng đang ở cấp bậc này', 'info')
                                }else{
                                    swal('', 'Xóa bình luận thành công', 'success').then(function() {
                                    window.location = "";
                                })
                                }
                                
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