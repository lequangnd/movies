@extends('backend.layouts.master')
@section('content')
<div class="breadcrumb-option">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="breadcrumb__links">
                    <a href="{{route('index')}}"><i class="fa fa-home"></i> Trang chủ</a>
                    <span>{{$link->movie->name}}</span>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="anime-details spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="anime__video__player espisode_color" data-espisode="{{$link->espisode}}">
                    <iframe id="iframe" class="cust-embed" width="100%" height="480" src="{{$link->link1}}" frameborder="0" allowfullscreen=""></iframe>
                    <!-- link -->
                    <div class="mt-2">
                        <i class="fa fa-server text-white"></i>
                        <a class="text-white font-weight-bold ml-2">Server: </a>
                        @if($link->link1 && $link->link2)
                        <a href="#" class="btn btn-warning ml-2 font-weight-bold link1" data-link="{{$link->link1}}">Link 1</a>
                        <a href="#" class="btn btn-secondary ml-2 font-weight-bold link2" data-link="{{$link->link2}}">Link 2</a>
                        @elseif($link->link1)
                        <a href="#" class="btn btn-warning ml-2 font-weight-bold">Link 1</a>
                        @else
                        <a href="#" class="btn btn-warning ml-2 font-weight-bold">Link 2</a>
                        @endif
                    </div>
                </div>

                <div class="anime__details__episodes">
                    <div class="section-title">
                        <h5 class="list">Tập phim</h5>
                    </div>
                    @foreach($espisode as $e)
                    <a href="{{route('watching-espisode',['id'=>$e->id,'movie_id'=>$e->movie_id])}}" class="ep" data-ep="{{$e->espisode}}">Tập {{$e->espisode}}</a>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <div class="anime__details__review">
                    <div class="section-title">
                        <h5>Đánh giá</h5>
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
                            <h6>{{$c->users->name}} - <span>{{$c->date}}</span></h6>
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
                                <button type="submit" class="btn btn-danger ml-2 btn-reply-submit" data-id="{{$c->id}}" data-url="{{route('reply')}}"><i class="fa fa-location-arrow"></i> Trả lời</button>
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
                                <h6>{{$r->users->name}} - <span>{{$r->date}}</span></h6>
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
                                    <button type="submit" class="btn btn-danger ml-2 btn-reply-submit" data-id="{{$c->id}}" data-reply_child_id="{{$r->id}}" data-url="{{route('reply' )}}"><i class="fa fa-location-arrow"></i> Trả lời</button>
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
                    <form id="submit_comment" data-url="{{route('comment',['id'=>$link->movie_id])}}">
                        @csrf
                        <textarea placeholder="Viết bình luận tại đây" id="comment" name="comment"></textarea>
                        <button type="submit"><i class="fa fa-location-arrow"></i> Đăng bài</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
<script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var espisode = $('.espisode_color').data('espisode');
        $('.ep').each(function() {
            if (espisode == $(this).data('ep')) {
                $(this).css('background-color', 'red');
            }
        });

        $('.link2').click(function(e){
            e.preventDefault();
            var link=$(this).data('link');
            $('#iframe').attr('src',link);
            $('.link1').removeClass('btn-warning');
            $('.link1').addClass('btn-secondary');
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-warning');
        });

        $('.link1').click(function(e){
            e.preventDefault();
            var link=$(this).data('link');
            $('#iframe').attr('src',link);
            $('.link2').removeClass('btn-warning');
            $('.link2').addClass('btn-secondary');
            $(this).removeClass('btn-secondary');
            $(this).addClass('btn-warning');
        });

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
                        swal("", "Đã đánh giá", "success");
                    },
                    error: function() {
                        alert('lỗi');
                    }
                })
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
        $('.see-more').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#reply-more-' + id).show();
            $(this).hide();
            $('#icon-see-more-' + id).hide();
            $('#icon-hide-more-' + id).show();
            $('#hide-more-' + id).show();
        });
        $('.hide-more').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            $('#reply-more-' + id).hide();
            $(this).hide();
            $('#icon-hide-more-' + id).hide();
            $('#icon-see-more-' + id).show();
            $('#see-more-' + id).show();
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
    });
</script>