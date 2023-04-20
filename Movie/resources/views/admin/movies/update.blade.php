@extends('admin.layouts.master')
@section('content')
<div class="container-fluid" id="container-wrapper">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Sửa phim</h1>
        <ol class="breadcrumb">

        </ol>
    </div>

    <form method="post" action="{{route('updateMovie',['id'=>$movie->id])}}" name="updateMovie" onsubmit="return validate()">
        @csrf
        <div class="row">
            <div class="col-lg-6">
                <!-- Form Basic -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên phim</label>
                            <input type="text" name="name" value="{{$movie->name}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1" class="category" data-category="{{$movie->category_id}}">Loại phim</label>
                            <select class="form-control" name="category" id="category">
                                @foreach($categories as $c)
                                <option value="{{$c->id}}" @if($c->id==$movie->category_id) selected @endif>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Thể loại</label><br>
                            @foreach($genres as $g)
                            <input type="checkbox" id="genre" name="genre[]" value="{{$g->id}}"  @foreach($details_genres as $d) @if($g->id==$d->genre_id) checked @endif @endforeach>
                            <label for="vehicle1"> {{$g->name}}</label>
                            @endforeach
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Quốc gia</label>
                            <select class="form-control" name="country" id="exampleFormControlSelect1">
                                @foreach($countries as $c)
                                <option value="{{$c->id}}" @if($c->id==$movie->country_id) selected @endif>{{$c->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Phim trả phí</label>
                            <select class="form-control" name="paid_movie" id="paid_movie">
                                <option value="0" @if($movie->paid_movie==0) selected @endif>Không</option>
                                <option value="1" @if($movie->paid_movie==1) selected @endif>Có</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1" class="price_movie">Giá bộ phim</label>
                            <input type="text" name="price_movie" @if($paid_movie) value="{{$paid_movie->money}}" @endif class="form-control" id="price_movie" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Diễn viên</label>
                            <input type="text" name="actor" value="{{$movie->actor}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Thời lượng</label>
                            <input type="text" name="duration" value="{{$movie->duration}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Năm sản xuất</label>
                            <input type="date" name="date" class="form-control" value="{{$movie->date}}" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1" class="label_total_espisode">Tổng số tập phim</label>
                            <input type="text" name="total_espisode" data-total_espisode="{{$movie->total_espisode}}" value="{{$movie->total_espisode}}" class="form-control" id="total_espisode" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Mô tả</label>
                            <input type="text" name="description" value="{{$movie->description}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                            <div class="custom-file">
                                <input type="file" name="image" accept="image/*" class="custom-file-input" onchange="return chooseFile(this)" id="customFile">
                                <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <img style="width:100px; height:120px;" src="{{asset('images/'.$movie->image)}}" id="image" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
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

    function validate() {
        if (document.updateMovie.name.value == "") {
            alert('Tên phim không được trống');
            return false;
        }

        var form_data=new FormData(document.querySelector('form'));
        if(form_data.getAll('genre[]').length<1)
        {
            alert('Vui lòng chọn thể loại phim');
            return false;
        }

        if (document.updateMovie.actor.value == "") {
            alert("Diễn viên không được để trống");
            return false;
        }
        if (document.updateMovie.duration.value == "") {
            alert("Thời lượng phim không được để trống");
            return false;
        }
        if (document.updateMovie.date.value == "") {
            alert("Năm sản xuất không được để trống");
            return false;
        }
        if (document.updateMovie.total_espisode.value == "" && document.updateMovie.category.value == 1) {
            alert("Tổng số tập phim không được để trống");
            return false;
        }
        if (!/^\d*$/.test(document.updateMovie.total_espisode.value) && document.updateMovie.category.value == 1) {
            alert("Tổng số tập phim là phải số");
            return false;
        }
        if (document.updateMovie.description.value == "") {
            alert("Mô tả không được để trống");
            return false;
        }
    }

    $(document).ready(function() {
        $('#category').change(function(e) {
            e.preventDefault();
            if ($(this).val() == 2) {
                $('#total_espisode').prop('readonly', true);
                $('#total_espisode').val(null);
            } else {
                $('#total_espisode').prop('readonly', false);
                $('#total_espisode').val($('#total_espisode').data('total_espisode'));
            }
        });

        if ($('.category').data('category') == 2) {
            $('#total_espisode').prop('readonly', true);
        }

        $('.price_movie').hide();
        $('#price_movie').hide();
        $('#paid_movie').change(function(e) {
            e.preventDefault();
            if ($(this).val() == 1) {
                $('.price_movie').show();
                $('#price_movie').show();
            } else {
                $('.price_movie').hide();
                $('#price_movie').hide();
            }
        });

        var paid_movie = $('#paid_movie').val();
        if (paid_movie == 1) {
            $('.price_movie').show();
            $('#price_movie').show();
        }
    });
</script>