@extends('backend.layouts.master')
@section('content')
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{route('index')}}"><i class="fa fa-home"></i> Trang chủ</a>
                    <a href="#">Loại phim</a>
                    <span>Phim trả phí</span>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="trending__product">
                    <div class="row">
                        <div class="col-lg-8 col-md-8 col-sm-8">
                            <div class="section-title">
                                @if($id==1)
                                <h4>Phim bộ trả phí</h4>
                                @elseif($id==2)
                                <h4>Phim lẻ trả phí</h4>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($paid_movies as $m)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$m->image)}}">
                                    @if($m->category_id==1 && $m->espisode->count()!=0)
                                    <div class="ep">{{$m->now_espisode}}/{{$m->total_espisode}} tập</div>
                                    @elseif($m->category_id==1 && $m->espisode->count()==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @elseif($m->category_id==2)
                                    <div class="ep">Full</div>
                                    @endif
                                    @if($m->paid_movie==1)
                                    <div class="float-right bg-warning rounded p-1 font-weight-bold">Trả phí</div>
                                    @endif
                                    <div class="comment"><i class="fa fa-comments"></i> {{$m->comment->count()}}</div>
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
        </div>
    </div>
</section>
@endsection