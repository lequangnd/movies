@extends('backend.layouts.master')
@section('content')
<section class="hero">
    <div class="container">
        <div class="hero__slider owl-carousel">
            <div class="hero__items set-bg" data-setbg="{{asset('backend/img/hero/hero-1.jpg')}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text">
                            <div class="label">Adventure</div>
                            <h2>Fate / Stay Night: Unlimited Blade Works</h2>
                            <p>After 30 days of travel across the world...</p>
                            <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="{{asset('backend/img/hero/hero-1.jpg')}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text">
                            <div class="label">Adventure</div>
                            <h2>Fate / Stay Night: Unlimited Blade Works</h2>
                            <p>After 30 days of travel across the world...</p>
                            <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero__items set-bg" data-setbg="{{asset('backend/img/hero/hero-1.jpg')}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text">
                            <div class="label">Adventure</div>
                            <h2>Fate / Stay Night: Unlimited Blade Works</h2>
                            <p>After 30 days of travel across the world...</p>
                            <a href="#"><span>Watch Now</span> <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-12">
                            <div class="section-title deleteMovieUser" data-url="{{route('delete_movies_user')}}">
                                <h4>Phim đã mua</h4>
                                <a href="#" class="float-right text-white btn-deleteMovieUser">Xóa phim</a>
                                <a href="#" class="float-right text-white mr-5 btn-history" data-bs-toggle="offcanvas" data-bs-target="#demo">Lịch sử phim đã mua</a>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        @foreach($movie_user as $m)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$m->movies->image)}}">
                                    <div class="ep">{{$m->movies->now_espisode}}/{{$m->movies->total_espisode}} tập</div>
                                    <div class="float-right mt-2 mr-2"><input class="deleteMovieUser_checkbox" type="checkbox" name="deleteMovieUser_checkbox" value="{{$m->id}}"></div>
                                    <div class="comment"><i class="fa fa-comments"> {{$m->comment->count()}}</i></div>
                                    <div class="view"><i class="fa fa-eye"></i> {{$m->movies->view}}</div>
                                </div>
                                <div class="product__item__text">
                                    <ul>
                                        @foreach($categories as $c)
                                        @if($c->id==$m->movies->category_id)
                                        <li>{{$c->name}}</li>
                                        @endif
                                        @endforeach
                                        @foreach($m->details_genre->take(1) as $g)
                                        <li>{{$g->genres->name}}</li>
                                        @endforeach
                                        @foreach($countries as $c)
                                        @if($c->id==$m->movies->country_id)
                                        <li>{{$c->name}}</li>
                                        @endif
                                        @endforeach
                                    </ul>
                                    <h5><a href="{{route('details',['id'=>$m->movies->id])}}">{{$m->movies->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="offcanvas offcanvas-end" id="demo">
    <div class="offcanvas-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th scope="col">Phim</th>
                    <th scope="col">Ngày mua</th>
                    <th scope="col">Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($history_movies as $m)
                <tr>
                    <td><img class="rounded mx-auto d-block" src="{{asset('images/'.$m->movies->image)}}" alt=""></td>
                    <td>{{$m->movies->name}}</td>
                    <td>{{$m->date}}</td>
                    <td>
                        <?php
                        if(strlen($m->money)==4)
                        {
                            echo substr($m->money,'0','1').".000 đ";
                        }elseif(strlen($m->money)==5)
                        {
                            echo substr($m->money,'0','2').".000 đ";
                        }elseif(strlen($m->money)==6)
                        {
                            echo substr($m->money,'0','3').".000 đ";
                        }
                        ?>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function(e) {
        $('.btn-deleteMovieUser').click(function(e) {
            e.preventDefault();
            var list = [];
            var url = $('.deleteMovieUser').data('url');
            $('.deleteMovieUser_checkbox:checked').each(function() {
                var id = $(this).val();
                list.push(id);
            });
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    list: list
                },
                success: function(data) {
                    swal("", "Xóa thành công", "success").then(function() {
                        window.location = "";
                    })
                },
                error: function() {}
            });
        });
    });
</script>