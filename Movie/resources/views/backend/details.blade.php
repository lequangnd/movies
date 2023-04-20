@extends('backend.layouts.master')
@section('content')
<?php
use Illuminate\Support\Carbon;
$date=Carbon::now('Asia/Ho_Chi_Minh');
?>
<section class="anime-details spad">
    <div class="container buy_movie" data-url="{{route('buy_movie')}}" data-movie_id="{{$movie->id}}" @if($movie->paid_movie==1) data-money="{{$money}}" @endif>
        <div class="anime__details__content">
            <div class="row">
                <div class="col-lg-3">
                    <div class="anime__details__pic set-bg" data-setbg="{{asset('images/'.$movie->image)}}">
                        @if($movie->paid_movie==1)
                        <p class="bg-warning float-right rounded font-weight-bold p-1 money">
                            @foreach($movie->paid_movies as $m)
                            <?php 
                            $strlen=strlen($m->money);
                            $money=$m->money;
                            if($strlen==5)
                            {
                                echo substr($money,'0','2').".000 đ";
                            }elseif($strlen==4)
                            {
                                echo substr($money,'0','1').".000 đ";
                            }elseif($strlen==6)
                            {
                                echo substr($money,'0','3').".000 đ";
                            }
                            ?>
                            @endforeach
                        </p>
                        @endif
                        <div class="comment"><i class="fa fa-comments"></i> {{$movie->comment->count()}}</div>
                        <div class="view"><i class="fa fa-eye"></i> {{$movie->view}}</div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <div class="anime__details__text">
                        <div class="anime__details__title">
                            <h3>{{$movie->name}}</h3>
                            <span>{{$movie->actor}}</span>
                        </div>
                        <div class="anime__details__rating">
                            @if($star->count()!=0)
                            <?php
                            $total = 0;
                            foreach ($star as $s) {
                                $total += $s->star;
                            }
                            $avg = $total / $star->count();
                            ?>
                            <div class="rating">
                                @for($i=1;$i<=5;$i++) <a href="#"><i class="fa fa-star view_star  v_star-{{$i}}" data-id="{{$i}}" data-avg="{{$avg}}"></i></a>
                                    @endfor

                            </div>
                            @endif
                            <span>{{$star->count()}} lượt đánh giá</span>
                        </div>
                        <p>{{$movie->description}}</p>
                        <div class="anime__details__widget">
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <ul>
                                        <li><span>Diễn viên:</span> {{$movie->actor}}</li>
                                        <li><span>Thể loại:</span>
                                            @foreach($genres as $g)
                                            @foreach($movie->details_genres as $d)
                                            @if($d->genre_id==$g->id)
                                            {{$g->name}}
                                            @endif
                                            @endforeach
                                            @endforeach
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <ul>
                                        <li><span>Năm sản xuất:</span> {{$movie->date}}</li>
                                        <li><span>Thời lượng:</span>{{$movie->duration}}</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="anime__details__btn">
                            @if($movie->trailer->count()>0)
                            <a href="" class="btn btn-warning mr-2 font-weight-bold btn-trailer pt-2 pb-2" data-link_trailer="{{$trailer->link}}">Trailer</a>
                            @endif
                            <a href="#" class="follow-btn btn-follow" data-movie_id="{{$movie->id}}" data-url="{{route('addFollow')}}"><i class="fa fa-heart-o"></i> Yêu thích</a>
                            @if($espisode==0)
                            <a href="#" class="watch-btn"><span>Phim sắp chiếu</span><i class="fa fa-angle-right"></i></a>
                            @elseif($espisode!=0 && $movie->paid_movie==1)
                            @if(Auth::check() && isset($movie_user))
                            <a href="{{route('watching',['id'=>$movie->id])}}" class="watch-btn"><span>Xem phim</span> <i class="fa fa-angle-right"></i></a>
                            @else
                            <a href="#" class="watch-btn btn-paid"><span>Mua phim</span> <i class="fa fa-angle-right"></i></a>
                            @endif
                            @elseif($espisode!=0 && $movie->paid_movie==0)
                            <a href="{{route('watching',['id'=>$movie->id])}}" class="watch-btn"><span>Xem phim</span> <i class="fa fa-angle-right"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-md-8">
                <div class="anime__details__review">
                    <div class="section-title">
                        <h5 class="click">Đánh giá</h5>
                    </div>
                    <div class="anime__details__rating addStar" data-url="{{route('star')}}" data-movie_id="{{$movie->id}}">
                        <div class="rating">
                            @for($i=1;$i<=5;$i++) <a href="#"><i class="fa fa-star vote star-{{$i}}" data-id="{{$i}}"></i></a>
                                @endfor
                        </div>
                    </div>
                    <div class="anime__review__item">
                        @foreach($comments->sortByDesc('date') as $c)
                        <div class="anime__review__item__pic">
                            <img src="{{asset('images/'.$c->users->image)}}" alt="">
                        </div>
                        <div class="anime__review__item__text">
                            <h6>{{$c->users->name}} - <span>
                                        @if(Carbon::create($date)->diffInMinutes($c->date)<=59)
                                        {{Carbon::create($date)->diffInMinutes($c->date)}} phút trước
                                        @elseif(Carbon::create($date)->diffInDays($c->date)==0)
                                        {{Carbon::create($date)->diffInHours($c->date)}} giờ trước
                                        @elseif(Carbon::create($date)->diffInMonths($c->date)==0)
                                        {{Carbon::create($date)->diffInDays($c->date)}} ngày trước
                                        @elseif(Carbon::create($date)->diffInYears($c->date)==0)
                                        {{Carbon::create($date)->diffInMonths($c->date)}} tháng trước
                                        @elseif(Carbon::create($date)->diffInYears($c->date)>0)
                                        {{Carbon::create($date)->diffInYears($c->date)}} năm trước
                                        @endif
                            </span></h6>
                            <p>{{$c->Content}}</p>
                        </div>
                        <div class="mb-2">
                            @if(Auth::check())
                            @if($like->count()!=0)
                            @foreach($like as $l)
                            @if($l->comment_id==$c->id)
                            <i class="fa fa-thumbs-up text-white icon-btn-unlike" id="icon-btn-unlike-{{$c->id}}" style="margin-left:90px;"></i>
                            <a style="margin-left:90px;" href="#" class="text-white ml-1 btn-unlike" id="btn-unlike-{{$c->id}}" data-id="{{$c->id}}" data-url="{{route('unlike')}}" data-like_id="{{$l->id}}">Bỏ thích</a>
                            @endif
                            @endforeach
                            @endif
                            <i class="fa fa-thumbs-up text-white icon-unlike" id="icon-unlike-{{$c->id}}" style="margin-left:90px;"></i>
                            <a style="margin-left:90px;" href="#" class="text-white ml-1 unlike" id="unlike-{{$c->id}}" data-id="{{$c->id}}" data-url="{{route('unlike')}}">Bỏ thích</a>
                            <i class="fa fa-thumbs-o-up text-white icon-btn-like" id="icon-btn-like-{{$c->id}}" style="margin-left:90px;"></i>
                            <a style="margin-left:90px;" href="#" class="text-white ml-1 btn-like" id="btn-like-{{$c->id}}" data-id="{{$c->id}}" data-url="{{route('like')}}" @if(Auth::check()) data-user_id="{{Auth::user()->id}}" @endif>Thích</a>
                            @else
                            <i class="fa fa-thumbs-o-up text-white" style="margin-left:90px;"></i>
                            <a style="margin-left:90px;" href="#" class="text-white ml-1 btn-like" @if(Auth::check()) data-user_id="{{Auth::user()->id}}" @endif>Thích</a>
                            @endif
                            <a class="text-white ml-2 total_like-{{$c->id}}" style="margin-left:90px;">{{$c->likes->count()}}</a>
                            <i class="fa fa-reply text-white" style="margin-left:100px;"></i>
                            <a style="margin-left:100px;" href="#" class="text-white ml-1 btn-reply" data-id="{{$c->id}}" data-name="{{$c->users->name}}">Trả lời</a>
                            <i class='fas fa-caret-up text-white icon-hide-more' id="icon-hide-more-{{$c->id}}" style="margin-left:150px;"></i>
                            <a href="#" class="text-white ml-1 hide-more" id="hide-more-{{$c->id}}" data-id="{{$c->id}}">Ẩn bớt</a>
                            @if($c->reply->count()!=0)
                            <i class='fas fa-caret-down text-white icon-see-more' id="icon-see-more-{{$c->id}}" style="margin-left:150px;"></i>
                            <a href="#" class="text-white ml-1 see-more" id="see-more-{{$c->id}}" data-id="{{$c->id}}">Phản hồi</a>
                            @endif
                        </div>
                        <div style="margin-left:90px;" class="mt-2 mb-2 reply-hide reply-{{$c->id}}">
                            <form action="">
                                <input type="text" id="name_reply-{{$c->id}}" class="w-75 rounded" style="height:39px;">
                                <button type="submit" class="btn btn-danger ml-2 btn-reply-submit" data-id="{{$c->id}}" data-url="{{route('reply')}}" data-user_id="{{$c->user_id}}"><i class="fa fa-location-arrow"></i> Trả lời</button>
                            </form>
                        </div>

                        <!-- reply -->
                        <div class="anime__review__item ml-5 reply-more" id="reply-more-{{$c->id}}">
                            @foreach($c->reply->sortByDesc('date') as $r)
                            @if($r->comment_id==$c->id)
                            <div class="anime__review__item__pic">
                                <img src="{{asset('images/'.$r->users->image)}}" alt="">
                            </div>
                            <div class="anime__review__item__text">
                                <h6>{{$r->users->name}} - <span>
                                        @if(Carbon::create($date)->diffInMinutes($r->date)<=59)
                                        {{Carbon::create($date)->diffInMinutes($r->date)}} phút trước
                                        @elseif(Carbon::create($date)->diffInDays($r->date)==0)
                                        {{Carbon::create($date)->diffInHours($r->date)}} giờ trước
                                        @elseif(Carbon::create($date)->diffInMonths($r->date)==0)
                                        {{Carbon::create($date)->diffInDays($r->date)}} ngày trước
                                        @elseif(Carbon::create($date)->diffInYears($r->date)==0)
                                        {{Carbon::create($date)->diffInMonths($r->date)}} tháng trước
                                        @elseif(Carbon::create($date)->diffInYears($r->date)>0)
                                        {{Carbon::create($date)->diffInYears($r->date)}} năm trước
                                        @endif
                                    </span></h6>
                                <p>{{$r->content}}</p>
                            </div>
                            <div class="mb-2">
                                @if(Auth::check())
                                @if($like->count()!=0)
                                @foreach($like as $l)
                                @if($l->reply_id==$r->id)
                                <i class="fa fa-thumbs-up text-white icon-btn-unlike" id="icon-btn-unlike-{{$r->id}}" style="margin-left:90px;"></i>
                                <a style="margin-left:90px;" href="#" class="text-white ml-1 btn-unlike" id="btn-unlike-{{$r->id}}" data-id="{{$r->id}}" data-url="{{route('unlike')}}" data-like_id="{{$l->id}}">Bỏ thích</a>
                                @endif
                                @endforeach
                                @endif
                                <i class="fa fa-thumbs-up text-white icon-unlike" id="icon-unlike-{{$r->id}}" style="margin-left:90px;"></i>
                                <a style="margin-left:90px;" href="#" class="text-white ml-1 unlike" id="unlike-{{$r->id}}" data-id="{{$r->id}}" data-reply_id="{{$r->id}}" data-url="{{route('unlike')}}">Bỏ thích</a>
                                <i class="fa fa-thumbs-o-up text-white icon-btn-like" id="icon-btn-like-{{$r->id}}" style="margin-left:90px;"></i>
                                <a style="margin-left:90px;" href="#" class="text-white ml-1 btn-like" id="btn-like-{{$r->id}}" data-id="{{$r->id}}" data-reply_id="{{$r->id}}" data-url="{{route('like')}}" @if(Auth::check()) data-user_id="{{Auth::user()->id}}" @endif>Thích</a>
                                @else
                                <i class="fa fa-thumbs-o-up text-white" style="margin-left:90px;"></i>
                                <a style="margin-left:90px;" href="#" class="text-white ml-1 btn-like" @if(Auth::check()) data-user_id="{{Auth::user()->id}}" @endif>Thích</a>
                                @endif
                                <a class="text-white ml-2 total_like-{{$r->id}}" style="margin-left:90px;">{{$r->likes->count()}}</a>
                                <i class="fa fa-reply text-white" style="margin-left:100px;"></i>
                                <a style="margin-left:100px;" href="#" class="text-white ml-1 btn-reply" data-id="{{$r->id}}" data-name="{{$c->users->name}}">Trả lời</a>
                            </div>
                            <div style="margin-left:90px;" class="mt-2 mb-2 reply-hide reply-{{$r->id}}">
                                <form action="">
                                    <input type="text" id="name_reply-{{$r->id}}" class="w-75 rounded" style="height:39px;">
                                    <button type="submit" class="btn btn-danger ml-2 btn-reply-submit" data-id="{{$c->id}}" data-reply_child_id="{{$r->id}}" data-url="{{route('reply' )}}" data-user_id="{{$r->user_id}}"><i class="fa fa-location-arrow"></i> Trả lời</button>
                                </form>
                            </div>
                            @endif
                            @endforeach
                        </div>
                        @endforeach
                        <!-- end reply -->
                    </div>
                </div>
                <div class="anime__details__form">
                    <div class="section-title">
                        <h5>Viết bình luận của bạn</h5>
                    </div>
                    <form id="submit_comment" data-url="{{route('comment',['id'=>$movie->id])}}">
                        @csrf
                        <textarea placeholder="Viết bình luận" id="comment" name="comment"></textarea>
                        <button type="submit"><i class="fa fa-location-arrow"></i> Đăng bài</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-4 col-md-4">
                <div class="anime__details__sidebar">
                    <div class="section-title">
                        <h5>Bạn có thể thích</h5>
                    </div>
                    @foreach($category_movie as $c)
                    @if($c->espisode->count()!=0)
                    <div class="product__sidebar__view__item set-bg" data-setbg="{{asset('images/'.$c->image)}}">
                        <div class="ep">{{$c->now_espisode}} / {{$c->total_espisode}}</div>
                        <div class="view"><i class="fa fa-eye"></i> {{$c->comment->count()}}</div>
                        <h5><a href="{{route('details',['id'=>$c->id])}}">{{$c->name}}</a></h5>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<!-- modal -->
<div class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="background-color: #070720;">
            <div class="modal-header">
                <h5 class="modal-title text-white font-weight-bold">Trailer</h5>
                <a type="" class="btn_modal-close text-white" data-dismiss="modal" aria-label="Close">
                    <i class="fa fa-close" style="font-size:24px; cursor:pointer;"></i>
                </a>
            </div>
            <div class="modal-body" style="height:381px;">
                <iframe class="trailer_iframe rptss" style="width:100%; height:100%;" src="" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen=""></iframe>
            </div>
        </div>
    </div>
</div>
@endsection
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        $('#submit_comment').submit(function(e) {
            e.preventDefault();
            var comment = $('#comment').val();
            var url = $(this).data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    comment: comment
                },
                success: function(data) {
                    if (data['message']) {
                        swal("", "Bạn chưa đăng nhập", "info");
                    } else {
                        swal("", "Bạn đã đánh giá", "success").then(function() {
                            window.location = "";
                        });
                    }
                },
                error: function() {
                    swal("", "Bình luận của bạn hiện đang trống", "info");
                }
            });
        });

        $('.btn-follow').click(function(e) {
            e.preventDefault();
            var movie_id = $(this).data('movie_id');
            var url = $(this).data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    movie_id: movie_id
                },
                success: function(data) {
                    if (data['message']) {
                        swal("", "Phim này đã có trong danh mục yêu thích của bạn", "info");
                    } else if (data['login']) {
                        swal("", "Bạn chưa đăng nhập", "info");
                    } else {
                        swal("", "Thêm vào danh phim yêu thích thành công", "success");
                    }
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.vote').each(function() {
            $(this).hover(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                for (var i = id + 1; i <= 6; i++) {
                    $('.star-' + i).css('color', 'white');
                    for (var ii = 1; ii <= id; ii++) {
                        $('.star-' + ii).css('color', '#ffc107');
                    }
                }
            });

            $(this).click(function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                var movie_id = $('.addStar').data('movie_id');
                var url = $('.addStar').data('url');
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        id: id,
                        movie_id: movie_id
                    },
                    success: function(data) {
                        if (data['message']) {
                            swal("", "Bạn chưa đăng nhập", "info");
                        } else {
                            swal("", "Đã đánh giá", "success");
                        }

                    },
                    error: function() {
                        alert('lỗi');
                    }
                })
            });
        });

        $('.view_star').each(function() {
            var avg = $(this).data('avg');
            for (var i = 1; i <= parseInt(avg); i++) {
                $('.v_star-' + i).css('color', '#ffc107');

            }
            if (!(avg % 1 == 0)) {
                $('.v_star-' + parseInt(avg + 1)).addClass('fa fa-star-half-o').css('color', '#ffc107');

                for (var i = parseInt(avg + 2); i <= 6; i++) {
                    $('.v_star-' + i).removeClass('fa fa-star');
                    $('.v_star-' + i).addClass('fa fa-star-o').css('color', '#ffc107');

                }
            } else {
                for (var i = parseInt(avg + 1); i <= 6; i++) {
                    $('.v_star-' + i).removeClass('fa fa-star');
                    $('.v_star-' + i).addClass('fa fa-star-o').css('color', '#ffc107');
                }
            }
        });

        $('.btn-paid').click(function(e) {
            e.preventDefault();
            var url = $('.buy_movie').data('url');
            var movie_id = $('.buy_movie').data('movie_id');
            var money = $('.buy_movie').data('money');
            if(money.toString().length==4)
            {
                var text_money=money.toString().slice(0,1)+".000 đ";
            }else if(money.toString().length==5)
            {
                var text_money=money.toString().slice(0,2)+".000 đ";
            }
            else if(money.toString().length==6)
            {
                var text_money=money.toString().slice(0,3)+".000 đ";
            }
            swal({
                    title: "Mua phim với giá " + text_money,
                    icon: "info",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            type: 'get',
                            url: url,
                            data: {
                                movie_id: movie_id,
                                money: money
                            },
                            success: function(data) {
                                if (data['message']) {
                                    swal('', 'Bạn chưa đăng nhập', 'info');
                                } else if (data['money']) {
                                    swal('', 'Số dư của bạn không đủ', 'info');
                                } else {
                                    swal('', 'Mua phim thành công', 'success').then(function() {
                                        window.location = "";
                                    });
                                }
                            },
                            error: function() {
                                alert('lỗi');
                            }
                        })
                    } else {

                    }
                });
        });

        $('.reply-hide').hide();
        $('.btn-reply').click(function(e) {
            e.preventDefault();
            $('.reply-hide').hide();
            var id = $(this).data('id');
            $('.reply-' + id).show();
            $('#name_reply-' + id).val("@" + $(this).data('name') + " ");
        });

        $('.btn-reply-submit').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var reply_child_id = $(this).data('reply_child_id');
            var user_id = $(this).data('user_id');
            if (reply_child_id != null) {
                var content = $('#name_reply-' + reply_child_id).val();
            } else {
                var content = $('#name_reply-' + id).val();
            }
            var url = $(this).data('url');
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    content: content,
                    user_id: user_id
                },
                success: function(data) {
                    if (data['message']) {
                        swal('', 'Bạn chưa đăng nhập', 'info');
                    } else {
                        swal('', 'Bạn đã bình luận', 'success').then(function() {
                            window.location = "";
                        })
                    }
                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.icon-hide-more').hide();
        $('.hide-more').hide();
        $('.reply-more').hide();
        $('.see-more').click(function(e)
        {
            e.preventDefault();
            var id=$(this).data('id');
            $('#reply-more-'+id).show();
            $(this).hide();
            $('#icon-see-more-'+id).hide();
            $('#icon-hide-more-'+id).show();
            $('#hide-more-'+id).show();
        });
        $('.hide-more').click(function(e)
        {
            e.preventDefault();
            var id=$(this).data('id');
            $('#reply-more-'+id).hide();
            $(this).hide();
            $('#icon-hide-more-'+id).hide();
            $('#icon-see-more-'+id).show();
            $('#see-more-'+id).show();
        });

        $('.btn-unlike').each(function() {
            var id = $(this).data('id');
            $('#btn-like-' + id).hide();
            $('#icon-btn-like-' + id).hide();
        });
        $('.unlike').hide();
        $('.icon-unlike').hide();

        $('.btn-unlike').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var like_id = $(this).data('like_id');
            var url = $(this).data('url');
            $(this).hide();
            $('#icon-btn-unlike-' + id).hide();
            $('#icon-btn-like-' + id).show()
            $('#btn-like-' + id).show();
            var quantity = parseInt($('.total_like-' + id).text());
            $('.total_like-' + id).text(quantity - 1);
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    like_id: like_id,
                },
                success: function(data) {

                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.unlike').click(function(e) {
            e.preventDefault();
            var reply_id = $(this).data('reply_id');
            var id = $(this).data('id');
            var url = $(this).data('url');
            $(this).hide();
            $('#icon-unlike-' + id).hide();
            $('#icon-btn-like-' + id).show()
            $('#btn-like-' + id).show();
            var quantity = parseInt($('.total_like-' + id).text());
            $('.total_like-' + id).text(quantity - 1);
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    reply_id: reply_id,
                },
                success: function(data) {

                },
                error: function() {
                    alert('lỗi');
                }
            });
        });

        $('.btn-like').click(function(e) {
            e.preventDefault();
            if (!$(this).data('user_id')) {
                swal('', 'Bạn chưa đăng nhập', 'info');
                return;
            }
            var reply_id = $(this).data('reply_id');
            var id = $(this).data('id');
            var url = $(this).data('url');
            $(this).hide();
            $('#icon-btn-like-' + id).hide();
            $('#unlike-' + id).show();
            $('#icon-unlike-' + id).show();
            var quantity = parseInt($('.total_like-' + id).text());
            $('.total_like-' + id).text(quantity + 1);
            $.ajax({
                type: 'get',
                url: url,
                data: {
                    id: id,
                    reply_id: reply_id
                },
                success: function(data) {

                },
                error: function() {
                    alert('lỗi')
                }
            });
        });

        $('.btn-trailer').click(function(e) {
            e.preventDefault();
            $('.modal').show();
            $('.trailer_iframe').attr('src', $(this).data('link_trailer'));
        });

        $('.btn_modal-close').click(function(e) {
            e.preventDefault();
            $('.modal').hide();
            $('.trailer_iframe').attr('src', '');
        });
    });
</script>