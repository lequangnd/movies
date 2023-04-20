@extends('admin.layouts.master')
@section('content')
<div class="container-fluid updateDecentralization" id="container-wrapper" data-url="{{route('updateDecentralization')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Người dùng</h1>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách người dùng</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Cấp bậc</th>
                                <th>Phân quyền</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $u)
                            @if($u->active==1)
                            <tr>
                                <td>
                                    <img style="width:50px" class="rounded" src="{{asset('images/'.$u->image)}}" alt="">
                                    {{$u->name}}
                                </td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->level->name}}</td>
                                <td class="select"><select name="" id="decentralization" data-user_id="{{$u->id}}">
                                        @foreach($decentralization as $d)
                                        <option value="{{$d->id}}" @if($u->decentralization_id==$d->id) selected @endif>{{$d->name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td><a href="{{route('admin-user-delete',['id'=>$u->id])}}" class="btn btn-danger">Xóa</a></td>

                            </tr>
                            @endif
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
@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select').each(function() {
            $(this).find('#decentralization').change(function(e) {
                var id = $(this).val();
                var user_id = $(this).data('user_id');
                var url = $('.updateDecentralization').data('url');
                swal({
                        title: "Bạn chắc chắn muốn thay đổi?",
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
                                    id: id,
                                    user_id: user_id
                                },
                                success: function(data) {
                                    swal('','Thay đổi thành công','success');
                                },
                                error: function() {
                                    alert('lỗi');
                                }
                            })
                        }
                    });
            });
        });
    });
</script>