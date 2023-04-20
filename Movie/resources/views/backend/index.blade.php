@extends('backend.layouts.master')
@section('content')
<section class="hero">
    <div class="container">
        <div class="hero__slider owl-carousel">
            @foreach($banner as $b)
            @if($b->status==1)
            <div class="hero__items set-bg" data-setbg="{{asset('images/banner/'.$b->image)}}">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="hero__text">
                            <div class="label">Phim hot</div>
                            <h2>{{$b->content}}</h2>
                            <a href="{{route('details',['id'=>$b->movie_id])}}"><span>Xem ngay</span> <i class="fa fa-angle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            @endforeach
        </div>
    </div>
</section>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-8">
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>Phim trả phí</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                                <a href="{{route('paid_movies')}}" class="primary-btn">Xem thêm <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($movie_paid->sortByDesc('created_at') as $m)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$m->image)}}">
                                    @if($m->category_id==1 && $m->espisode->count()!=0)
                                    <div class="ep">{{$m->now_espisode}}/{{$m->total_espisode}} tập</div>
                                    @elseif($m->category_id==1 && $m->espisode->count()==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @endif
                                    @if($m->category_id==2 && $m->espisode->count()!=0)
                                    <div class="ep">Full</div>
                                    @elseif($m->category_id==2 && $m->espisode->count()==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @endif
                                    @if($m->paid_movie==1)
                                    <div class="float-right bg-warning rounded p-1 font-weight-bold">Trả phí</div>
                                    @endif
                                    <div class="comment"><i class="fa fa-comments"> {{$m->comment->count()}}</i></div>
                                    <div class="view"><i class="fa fa-eye"></i> {{$m->view}}</div>
                                </div>
                                <div class="product__item__text">
                                    <ul>
                                        @foreach($genres as $g)
                                        @foreach($m->details_genres as $d)
                                        @if($g->id==$d->genre_id)
                                        <li>{{$g->name}}</li>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </ul>
                                    <h5><a href="{{route('details',['id'=>$m->id])}}">{{$m->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>Phim Bộ</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                                <a href="{{route('category',['id'=>1])}}" class="primary-btn">Xem thêm <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($movies->sortByDesc('created_at') as $m)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$m->image)}}">
                                    @if($m->category_id==1 && $m->espisode->count()!=0)
                                    <div class="ep">{{$m->now_espisode}}/{{$m->total_espisode}} tập</div>
                                    @elseif($m->category_id==1 && $m->espisode->count()==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @endif
                                    @if($m->paid_movie==1)
                                    <div class="float-right bg-warning rounded p-1 font-weight-bold">Trả phí</div>
                                    @endif
                                    <div class="comment"><i class="fa fa-comments"> {{$m->comment->count()}}</i></div>
                                    <div class="view"><i class="fa fa-eye"></i> {{$m->view}}</div>
                                </div>
                                <div class="product__item__text">
                                    <ul>
                                        @foreach($genres as $g)
                                        @foreach($m->details_genres as $d)
                                        @if($g->id==$d->genre_id)
                                        <li>{{$g->name}}</li>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </ul>
                                    <h5><a href="{{route('details',['id'=>$m->id])}}">{{$m->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                <h4>Phim Lẻ</h4>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                                <a href="{{route('category',['id'=>2])}}" class="primary-btn">Xem thêm <span class="arrow_right"></span></a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($movies_odd as $m)
                        <div class="col-lg-4 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$m->image)}}">
                                    @if($m->category_id==2 && $m->espisode->count()!=0)
                                    <div class="ep">Full</div>
                                    @elseif($m->category_id==2 && $m->espisode->count()==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @endif
                                    <div class="comment"><i class="fa fa-comments"> {{$m->comment->count()}}</i></div>
                                    <div class="view"><i class="fa fa-eye"></i> {{$m->view}}</div>
                                </div>
                                <div class="product__item__text">
                                    <ul>
                                        @foreach($genres as $g)
                                        @foreach($m->details_genres as $d)
                                        @if($g->id==$d->genre_id)
                                        <li>{{$g->name}}</li>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </ul>
                                    <h5><a href="{{route('details',['id'=>$m->id])}}">{{$m->name}}</a></h5>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-8">
                <div class="product__sidebar">
                    <div class="product__sidebar__view">
                        <div class="section-title">
                            <h5>Top lượt xem</h5>
                        </div>
                        <ul class="filter__controls">
                            <li class="active" data-filter="*">Day</li>
                            <li data-filter=".week">Week</li>
                            <li data-filter=".month">Month</li>
                            <li data-filter=".years">Years</li>
                        </ul>
                        <div class="filter__gallery">
                            @foreach($view as $v)
                            <div class="product__sidebar__view__item set-bg mix day years" data-setbg="{{asset('images/'.$v->image)}}">
                                @if($v->category_id==1 && $v->espisode->count()!=0)
                                <div class="ep">{{$v->now_espisode}}/{{$v->total_espisode}}</div>
                                @elseif($v->espisode->count()==0)
                                <div class="ep">Sắp chiếu</div>
                                @else
                                <div class="ep">Full</div>
                                @endif
                                <div class="view"><i class="fa fa-eye"></i> {{$v->view}}</div>
                                <h5><a href="{{route('details',['id'=>$v->id])}}">{{$v->name}}</a></h5>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="product__sidebar__comment">
                        <div class="section-title">
                            <h5>Top đánh giá</h5>
                        </div>
                        @foreach($top_star as $t)
                        <div class="product__sidebar__comment__item">
                            <div class="product__sidebar__comment__item__pic">
                                <img src="{{asset('images/'.$t->movies->image)}}" alt="">
                            </div>
                            <div class="product__sidebar__comment__item__text">
                                <ul>
                                    @foreach($categories as $c)
                                    @if($c->id==$t->movies->category_id)
                                    <li>{{$c->name}}</li>
                                    @endif
                                    @endforeach
                                    <?php
                                    $movies=$t->movies;
                                    ?>
                                    @foreach($genres as $g)
                                    @foreach($movies->details_genres as $d)
                                    @if($g->id==$d->genre_id)
                                    <li>{{$g->name}}</li>
                                    @endif
                                    @endforeach
                                    @endforeach
                                    
                                </ul>
                                <h5><a href="{{route('details',['id'=>$t->movies->id])}}">{{$t->movies->name}}</a></h5>
                                <span><i class="fa fa-star"></i> {{$t->star}} sao</span>
                                <span><i class="fa fa-eye"></i> {{$t->movies->view}} lượt xem</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal -->
@if(Auth::check())
<div class="modal" id="modal_social" tabindex="-1" role="dialog" @if(Auth::check()) data-social="{{Auth::user()->social}}" @endif>
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xác thực tài khoản</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email</label>
                        <input type="email" value="{{Auth::user()->email}}" readonly="true" class="form-control" id="email" aria-describedby="emailHelp">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" placeholder="Mật khẩu">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" data-url="{{route('active_social')}}" class="btn btn-primary btn-submit">Xác thực</button>
            </div>
        </div>
    </div>
</div>
@endif
@endsection

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var social = $('#modal_social').data('social');
        if (social == 0) {
            $('#modal_social').show();
        } else {
            $('#modal_social').hide();
        }

        $('.close').click(function(e) {
            e.preventDefault();
            $('#modal_social').hide();
        });

        $('.btn-submit').click(function(e)
        {
            e.preventDefault();
            var email=$('#email').val();
            var password=$('#password').val();
            var url=$(this).data('url');
            $.ajax({
                type:'get',
                url:url,
                data:{email:email, password:password},
                success:function(data)
                {
                    swal('','Xác thực tài khoản thành công','success');
                    $('#modal_social').hide();
                },
                error:function()
                {
                    alert('lỗi');
                }
            })
        })
    });
</script>