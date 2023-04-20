@extends('admin.layouts.master')
@section('content')
<div class="container-fluid addBanner" id="container-wrapper" data-url="{{route('addBanner')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 updateStatus" data-url="{{route('statusBanner')}}">
        <h1 class="h3 mb-0 text-gray-800">Banner</h1>
    </div>

    <div class="row updateBanner" data-url="{{route('updateBanner')}}">
        <div class="col-lg-5 mb-4 deleteBanner" data-url="{{route('deleteBanner')}}">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Thêm banner</h6>
                </div>
                <div class="card-body">
                    <form id="submit_banner">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nội dung</label>
                            <input type="text" name="name" class="form-control" id="name" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="image" accept="image/*" class="custom-file-input" onchange="return chooseFile(this)" id="img">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <img style="width:120px; height:100px;" src="" id="image" alt="">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Phim</label>
                            <select class="form-control" name="movie" id="movie">
                                @foreach($movies as $m)
                                <option value="{{$m->id}}">{{$m->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary btn-submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="col-lg-12 mb-4">
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Danh sách banner</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush" id="myTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ảnh</th>
                                    <th>Nội dung</th>
                                    <th>Phim</th>
                                    <th>Thao tác</th>
                                    <th>Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($banner as $b)
                                <tr>
                                    <td class="btn-image" data-movie_id="{{$b->movie_id}}" data-image="{{$b->image}}"><img style="width:120px; height:100px;" src="{{asset('images/banner/'.$b->image)}}" alt=""></td>
                                    <td class="name-banner">{{$b->content}}</td>
                                    <td>{{$b->movies->name}}</td>
                                    <td><button class="btn btn-sm btn-warning btn-update" data-id="{{$b->id}}" disabled>Sửa</button>
                                        <button class="btn btn-sm btn-danger btn-delete" data-id="{{$b->id}}" disabled>Xóa</button>
                                    </td>
                                    <td class="select-status"><select name="" id="status" data-id="{{$b->id}}">
                                            <option value="0" @if($b->status==0) selected @endif>Ẩn</option>
                                            <option value="1" @if($b->status==1) selected @endif>Hiện</option>
                                        </select></td>
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

    <div class="row">
        <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Danh sách phim</h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" id="movieTable">
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
                                <td class="name_movie">{{$m->name}}</td>
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
                                <td><a href="#" class="btn btn-sm btn-primary btn-select" data-movie_id="{{$m->id}}">Chọn</a>
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
</div>
@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    function chooseFile(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#image').attr('src', e.target.result);
            }
            reader.readAsDataURL(fileInput.files[0]);
        }
    }

    $(document).ready(function() {
        $('#movieTable').DataTable();

        $('.btn-select').click(function(e) {
            e.preventDefault();
            var movie_id = $(this).data('movie_id');
            $('#movie').val(movie_id);
            $('#name').val($(this).parents('tr').find('.name_movie').text());
        });

        $('#submit_banner').submit(function(e) {
            e.preventDefault();
            if($('#name').val()=="")
            {
                alert('Nội dung không được để trống');
                return;
            }
            if($('#img').val()=="")
            {
                alert('Ảnh không được để trống');
                return;
            }
            var url = $('.addBanner').data('url');
            var movie_id = $('#movie').val();
            var content = $('#name').val();
            var fileValueAfterChange = $('#img').val();
            fileValueAfterChange = fileValueAfterChange.substring(fileValueAfterChange.lastIndexOf("\\") + 1, fileValueAfterChange.length);

            $.ajax({
                type: 'get',
                url: url,
                data: {
                    movie_id: movie_id,
                    content: content,
                    image: fileValueAfterChange
                },
                success: function(data) {
                    swal('', 'Thêm thành công', 'success').then(function() {
                        window.location = '';
                    })
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.select-status').each(function() {
            $(this).find('#status').change(function(e) {
                e.preventDefault();
                var status = $(this).val();
                var url = $('.updateStatus').data('url');
                var id = $(this).data('id');
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        status: status,
                        id: id
                    },
                    success: function(data) {
                        swal('', 'Cập nhật thành công', 'success');
                    },
                    error: function() {
                        alert('lỗi');
                    }
                })
            });
        });

        $('.btn-image').click(function(e) {
            e.preventDefault();
            $('.btn-update').prop('disabled', true);
            $('.btn-delete').prop('disabled', true);
            $('.btn-submit').prop('disabled',true);
            $(this).parents('tr').find('td .btn-update').prop('disabled', false);
            $(this).parents('tr').find('td .btn-delete').prop('disabled', false);
            $('#name').val($(this).parents('tr').find('.name-banner').text());
            var image = "{!!asset('images/banner/" + $(this).data("image") + "')!!}";
            $('#image').attr('src', image);
            $('#movie').val($(this).data('movie_id'));
        });

        $('.btn-update').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.updateBanner').data('url');
            var movie_id = $('#movie').val();
            var content = $('#name').val();
            var fileValueAfterChange = $('#img').val();
            fileValueAfterChange = fileValueAfterChange.substring(fileValueAfterChange.lastIndexOf("\\") + 1, fileValueAfterChange.length);
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    movie_id: movie_id,
                    content: content,
                    image: fileValueAfterChange
                },
                success: function(data) {
                    swal('', 'Sửa thành công', 'success').then(function() {
                        window.location = '';
                    })
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.btn-delete').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = $('.deleteBanner').data('url');
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
                                id: id,
                            },
                            success: function(data) {
                                swal('', 'Xóa thành công', 'success').then(function() {
                                    window.location = '';
                                })
                            },
                            error: function() {
                                alert('lỗi');
                            }
                        });
                    } else {

                    }
                });
        })
    });
</script>