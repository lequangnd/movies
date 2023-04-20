@extends('backend.layouts.master')
@section('content')
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{route('index')}}"><i class="fa fa-home"></i> Trang chủ</a>
                    <a href="#">Thể loại</a>
                    <span>{{$genre->name}}</span>
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
                                <h4>{{$genre->name}}</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        @foreach($details_genres as $d)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$d->movies->image)}}">
                                    <?php
                                    $movies = $d->movies;
                                    $espisode = $movies->espisode->count();
                                    ?>
                                    @if($d->movies->category_id==1 && $espisode!=0)
                                    <div class="ep">{{$d->movies->now_espisode}}/{{$d->movies->total_espisode}} tập</div>
                                    @elseif($d->movies->category_id==1 && $espisode==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @endif
                                    <?php 
                                    $movie=$d->movies;
                                    ?>
                                    @if($d->movies->category_id==2 && $movie->espisode->count()!=0)
                                    <div class="ep">Full</div>
                                    @elseif($d->movies->category_id==2 && $movie->espisode->count()==0)
                                    <div class="ep">Sắp chiếu</div>
                                    @endif
                                    @if($d->movies->paid_movie==1)
                                    <div class="float-right bg-warning rounded p-1 font-weight-bold">Trả phí</div>
                                    @endif
                                    <div class="comment"><i class="fa fa-comments"></i> {{$d->movies->comment->count()}}</div>
                                    <div class="view"><i class="fa fa-eye"></i> {{$d->movies->view}}</div>
                                </div>
                                <div class="product__item__text">
                                    <ul>
                                        <li>{{$d->genres->name}}</li>
                                    </ul>
                                    <h5><a href="{{route('details',['id'=>$d->movies->id])}}">{{$d->movies->name}}</a></h5>
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