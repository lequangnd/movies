@extends('admin.layouts.master')
@section('content')
<div class="container-fluid deleteMovie" id="container-wrapper" data-url="{{route('deleteMovie')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Phim</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('add-movie')}}">Thêm phim</a></li>
        </ol>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách phim</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="myTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Phim</th>
                                <th>Image</th>
                                <th>Loại</th>
                                <th>Thể loại</th>
                                <th>Quốc gia</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($movies as $m)
                            <tr>
                                <td>{{$m->name}}</td>
                                <td><img style="width:100px; height:120px;" src="{{asset('images/'.$m->image)}}" alt=""></td>
                                <td>{{$m->categories->name}}</td>
                                <td>
                                    @foreach($genres as $g)
                                    @foreach($m->details_genres as $d)
                                    @if($g->id==$d->genre_id)
                                    <span class="text-info">{{$g->name}}</span><br>
                                    @endif
                                    @endforeach
                                    @endforeach
                                </td>
                                <td>{{$m->countries->name}}</td>
                                <td>
                                    <a href="{{route('espisode',['id'=>$m->id])}}" class="btn btn-sm btn-primary">Tập phim</a>
                                    <a href="{{route('update-movie',['id'=>$m->id])}}" class="btn btn-sm btn-warning">Sửa</a>
                                    <a href="#" class="btn btn-sm btn-danger btn-delete" data-id="{{$m->id}}">Xóa</a>
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
@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.deleteMovie').data('url');
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
                                swal('', 'Xóa phim thành công', 'success').then(function() {
                                    window.location = "";
                                })
                            },
                            error: function() {
                                alert('lỗi');
                            }
                        });
                    }
                });
        })
    })
</script>