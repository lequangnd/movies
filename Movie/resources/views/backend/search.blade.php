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
                            <div class="section-title">
                                <h4>Tìm kiếm</h4>
                                <div class="breadcrumb__links">
                                </div>
                            </div>
                            <span class="text-white">Kết quả tìm kiếm cho: {{$key}}</span>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-4">
                            <div class="btn__all">
                            </div>
                        </div>

                    </div>
                    <div class="row">
                        @foreach($movies as $m)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="product__item">
                                <div class="product__item__pic set-bg" data-setbg="{{asset('images/'.$m->image)}}">
                                    <div class="ep">{{$m->now_espisode}}/{{$m->total_espisode}} tập</div>
                                    <div class="comment"><i class="fa fa-comments"> {{$m->comment->count()}}</i></div>
                                    <div class="view"><i class="fa fa-eye"></i> {{$m->view}}</div>
                                </div>
                                <div class="product__item__text">
                                    <ul>
                                        @foreach($categories as $c)
                                        @if($c->id==$m->category_id)
                                        <li>{{$c->name}}</li>
                                        @endif
                                        @endforeach
                                        @foreach($genres as $c)
                                        @if($c->id==$m->genre_id)
                                        <li>{{$c->name}}</li>
                                        @endif
                                        @endforeach
                                        @foreach($countries as $c)
                                        @if($c->id==$m->country_id)
                                        <li>{{$c->name}}</li>
                                        @endif
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
</script>