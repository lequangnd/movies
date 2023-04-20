@extends('admin.layouts.master')
@section('content')
<div class="container-fluid espisode_max" id="container-wrapper" data-espisode="{{$espisode->max('espisode')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tập phim</h1>
    </div>

    <!-- trailer -->
    <div class="row addTrailer" data-url="{{route('addTrailer')}}" data-id="{{$movie->id}}">
        <div class="col-lg-5 mb-4 updateTrailer" data-url="{{route('updateTrailer')}}">
            <div class="card mb-4 deleteTrailer" data-url="{{route('deleteTrailer')}}">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm trailer</h6>
                </div>
                <div class="card-body">
                    <form id="submit_trailer">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Link trailer</label>
                            <input type="text" name="trailer" class="form-control" id="link_trailer" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit-trailer">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-7 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Trailer</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th>Link trailer</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trailer as $t)
                            <tr>
                                <td class="link_trailer">{{$t->link}}</td>
                                <td><button class="btn btn-sm btn-warning btn-update-trailer" data-id="{{$t->id}}" disabled>Sửa</button>
                                    <button class="btn btn-sm btn-danger btn-delete-trailer" data-id="{{$t->id}}" disabled>Xóa</button>
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
    <!-- end trailer -->

    <div class="row addEspisode" data-url="{{route('addEspisode')}}" data-id="{{$movie->id}}">
        <div class="col-lg-12 mb-4 updateEspisode" data-url="{{route('updateEspisode')}}">
            <div class="card mb-4 deleteEspisode" data-url="{{route('deleteEspisode')}}">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm tập</h6>
                </div>
                <div class="card-body">
                    <form id="submit_espisode">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Link phim 1</label>
                            <input type="text" name="name" class="form-control" id="link1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Link phim 2</label>
                            <input type="text" name="name" class="form-control" id="link2" aria-describedby="emailHelp">
                        </div>
                        @if($movie->category_id==1)
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Tập phim</label>
                            <select class="form-control" name="category" id="espisode">
                                <?php
                                $total = $movie->total_espisode;
                                ?>
                                @for($i=1;$i<=$total;$i++) <option value="{{$i}}">{{$i}}</option>
                                    @endfor
                            </select>
                        </div>
                        @endif
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách tập phim</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th>Link phim</th>
                                    <th>Tập</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($espisode as $e)
                                <tr>
                                    <td class="link" data-link1="{{$e->link1}}" data-link2="{{$e->link2}}"> 
                                        link 1 : {{$e->link1}}<br>
                                        link 2 : {{$e->link2}}
                                    </td>
                                    <td class="espisode">{{$e->espisode}}</td>
                                    <td><button class="btn btn-sm btn-warning btn-update" data-id="{{$e->id}}" disabled>Sửa</button>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{$e->id}}" disabled>Xóa</button>
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
        var espisode_max = $('.espisode_max').data('espisode');
        $('#espisode').val(espisode_max + 1);

        $('#submit_espisode').submit(function(e) {
            e.preventDefault();
            var link1 = $('#link1').val();
            var link2 = $('#link2').val();
            if (link1 == "" && link2=="") {
                alert('link phim không được để trống');
                return false;
            }
            var espisode = $('#espisode').val();
            var url = $('.addEspisode').data('url');
            var id = $('.addEspisode').data('id');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    link1: link1,
                    link2: link2,
                    espisode: espisode
                },
                success: function(data) {
                    if (data['message']) {
                        swal("", "Tập phim này đã tồn tại", "info");
                    } else {
                        swal("", "Thêm tập phim thành công", "success").then(function() {
                            window.location = "";
                        })
                    }
                },
                error: function() {
                    alert('Lỗi');
                }
            });
        });

        $('.link').click(function(e) {
            e.preventDefault();
            var link1 = $(this).data('link1');
            var link2 = $(this).data('link2');
            var espisode = $(this).parents('tr').find('.espisode').text();
            $('#link1').val(link1);
            $('#link2').val(link2);
            $('#espisode').val(espisode);
            $('.btn-submit').prop('disabled',true);
            $('.btn-update').prop('disabled', true);
            $('.btn-delete').prop('disabled', true);
            $(this).parents('tr').find('.btn-update').prop('disabled', false);
            $(this).parents('tr').find('.btn-delete').prop('disabled', false);
        })

        $('.btn-update').click(function(e) {
            e.preventDefault();
            var movie_id = $('.addEspisode').data('id');
            var id = $(this).data('id');
            var url = $('.updateEspisode').data('url');
            var link1 = $('#link1').val();
            var link2 = $('#link2').val();
            var espisode = $('#espisode').val();
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    link1: link1,
                    link2: link2,
                    espisode: espisode,
                    movie_id: movie_id
                },
                success: function(data) {
                    if (data['message']) {
                        swal("", "Tập phim này đã tồn tại", "info");
                    } else {
                        swal("", "Sửa tập phim thành công", "success").then(function() {
                            window.location = "";
                        })
                    }
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.deleteEspisode').data('url');
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
        });

        $('#submit_trailer').submit(function(e) {
            e.preventDefault();
            var link_trailer = $('#link_trailer').val();
            if (link_trailer == "") {
                alert('link trailer không được để trống');
                return false;
            }
            var url = $('.addTrailer').data('url');
            var id = $('.addTrailer').data('id');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    link_trailer: link_trailer,
                },
                success: function(data) {
                    if (data['message']) {
                        swal("", "Phim này đã có trailer", "info");
                    } else {
                        swal("", "Thêm trailer thành công", "success").then(function() {
                            window.location = "";
                        })
                    }
                },
                error: function() {
                    alert('Lỗi');
                }
            });
        });

        $('.link_trailer').click(function(e) {
            e.preventDefault();
            $('#link_trailer').val($(this).text());
            $('.btn-submit-trailer').prop('disabled',true);
            $(this).parents('tr').find('.btn-update-trailer').prop('disabled', false);
            $(this).parents('tr').find('.btn-delete-trailer').prop('disabled', false);
        });

        $('.btn-update-trailer').click(function(e) {
            e.preventDefault();
            var link_trailer = $('#link_trailer').val();
            if (link_trailer == "") {
                alert('link trailer không được để trống');
                return false;
            }
            var id = $(this).data('id');
            var url = $('.updateTrailer').data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    link_trailer: link_trailer,
                    id: id
                },
                success: function(data) {
                    swal("", "Sửa trailer thành công", "success").then(function() {
                        window.location = "";
                    });
                },
                error:function()
                {
                    alert('lỗi');
                }

            })
        });

        $('.btn-delete-trailer').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.deleteTrailer').data('url');
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
        });
    });
</script>