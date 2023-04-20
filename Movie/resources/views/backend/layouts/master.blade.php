<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Anime Template">
    <meta name="keywords" content="Anime, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{asset('images/icon.png')}}" rel="icon">
    <title>A Movies</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mulish:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{asset('backend/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/font-awesome.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/plyr.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{asset('backend/css/style.css')}}" type="text/css">
</head>
<style>
    .mobile-menu li:hover {
        background-color: red;
    }
</style>

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2">
                    <div class="header__logo">
                        <a href="{{route('index')}}">
                            <img src="{{asset('images/logo.png')}}" alt="">
                        </a>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="header__nav">
                        <nav class="header__menu mobile-menu">
                            <ul>
                                <li class="active url_active" data-url="{{url()->current()}}"><a href="{{route('index')}}">Trang chủ</a></li>
                                <li class="genre" data-url="http://localhost/source/Movie/public/genre/"><a href="#">Thể loại <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        @foreach($genres as $g)
                                        <li><a href="{{route('genre',['id'=>$g->id])}}" class="genre">{{$g->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="category" data-url="http://localhost/source/Movie/public/category/"><a href="#">Loại phim <span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        @foreach($categories as $c)
                                        <li class="category" data-url="{{route('category',['id'=>$c->id])}}"><a href="{{route('category',['id'=>$c->id])}}">{{$c->name}}</a></li>
                                        @endforeach
                                        <li><a href="{{route('paid_movies')}}">Phim trả phí</a></li>
                                    </ul>
                                </li>
                                <li class="country" data-url="http://localhost/source/Movie/public/country/"><a href="#">Quốc gia<span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        @foreach($countries as $c)
                                        <li class="genre" data-url="{{route('country',['id'=>$c->id])}}"><a href="{{route('country',['id'=>$c->id])}}">{{$c->name}}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                                @if(Auth::check() && Auth::user()->decentralization_id==2)
                                <li><a href="#" class="mr-5">Tài khoản<span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="{{route('follow')}}">Phim yêu thích</a></li>
                                        <li><a href="{{route('movies_user')}}">Phim đã mua</a></li>
                                        <li><a href="{{route('wallet')}}">Tài khoản</a></li>
                                        <li><a href="{{route('profile')}}">Quản lý</a></li>
                                        <li><a href="{{route('logout')}}">Đăng xuất</a></li>
                                    </ul>
                                </li>
                                @elseif(Auth::check() && Auth::user()->decentralization_id==1)
                                <li><a href="#" class="mr-5">Tài khoản<span class="arrow_carrot-down"></span></a>
                                    <ul class="dropdown">
                                        <li><a href="{{route('follow')}}">Phim yêu thích</a></li>
                                        <li><a href="{{route('profile')}}">Quản lý</a></li>
                                        <li><a href="{{route('dashboard')}}">Quản trị</a></li>
                                        <li><a href="{{route('logout')}}">Đăng xuất</a></li>
                                    </ul>
                                </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-2 get_search" data-url="{{route('search')}}">
                    <div class="header__right">
                        <a href="#" style="margin-left:-3px;" class=" btn-search"><span class="icon_search"></span></a>
                        <a href="#" class=" btn-close"><span class="fa fa-close"></span></a>
                        @if(Auth::check())
                        <a href="#"><span class="">{{Auth::user()->name}}</span></a>
                        @else
                        <a href="{{route('login')}}"><span class="icon_profile"></span></a>
                        @endif
                    </div>
                    <form action="{{route('search')}}" id="show_search">
                        <div class="input-group rounded">
                            <input type="search" name="key" class="form-control rounded input-search" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button style="background-color:#070720;" class="border-0 ml-3" type="submit"><span class="icon_search text-white"></span></button>
                        </div>
                    </form>
                </div>
            </div>
            <div id="mobile-menu-wrap"></div>
        </div>
    </header>
    <!-- Header End -->
    <!-- Product Section Begin -->
    @yield('content')
    <!-- Product Section End -->
    <!-- Footer Section Begin -->
    <footer class="footer">
        <div class="page-up">
            <a href="#" id="scrollToTopButton"><span class="arrow_carrot-up"></span></a>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="footer__logo">
                        <a href="./index.html"><img src="img/logo.png" alt=""></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="footer__nav">
                        <ul>
                            <li class="active"><a href="#">Homepage</a></li>
                            <li><a href="#">Categories</a></li>
                            <li><a href="#">Our Blog</a></li>
                            <li><a href="#" class="click">Contacts</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer Section End -->

    <!-- Search model Begin -->
    <div class="search-model">
        <div class="h-100 d-flex align-items-center justify-content-center">
            <div class="search-close-switch"><i class="icon_close"></i></div>
            <form class="search-model-form">
                <input type="text" id="search-input" placeholder="Search here.....">
            </form>
        </div>
    </div>
    <!-- Search model end -->

    <!-- modal -->
    <div class="modal" id="modal_search" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">kết quả tìm kiếm: <span class="text_search font-weight-bold"></span></h5>
                    <button type="button" class="close_search border-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color:white">
                    <table>
                        <thead>
                            <tr>
                                <th scope="col"></th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody id="myTable_search">
                            @foreach($movies_search as $m)
                            <tr>
                                <td><img class="rounded mx-auto d-block" style="width:70px; height:75px;" src="{{asset('images/'.$m->image)}}" alt=""></td>
                                <td>
                                    <a href="{{route('details',['id'=>$m->id])}}" class="text-dark pl-3">{{$m->name}}</a><br>
                                    <a href="{{route('details',['id'=>$m->id])}}" class="font-weight-bold text-secondary pl-3">{{$m->categories->name}}</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->

    <!-- Js Plugins -->
    <script src="{{asset('backend/js/jquery-3.3.1.min.js')}}"></script>
    <script src="{{asset('backend/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('backend/js/player.js')}}"></script>
    <script src="{{asset('backend/js/jquery.nice-select.min.js')}}"></script>
    <script src="{{asset('backend/js/mixitup.min.js')}}"></script>
    <script src="{{asset('backend/js/jquery.slicknav.js')}}"></script>
    <script src="{{asset('backend/js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('backend/js/main.js')}}"></script>
    <script>
        $(document).ready(function() {
            $('#show_search').hide();
            $('.btn-close').hide();
            $('.btn-search').click(function(e) {
                e.preventDefault();
                $(this).hide();
                $('.btn-close').show();
                $('#show_search').show();
            });
            $('.btn-close').click(function(e) {
                e.preventDefault();
                $(this).hide();
                $('.btn-search').show();
                $('#show_search').hide();
            });

            var url = $('.url_active').data('url').slice(0, -1);
            if (url == $('.genre').data('url')) {
                $('.url_active').removeClass('active');
                $('.category').removeClass('active');
                $('.country').removeClass('active');
                $('.genre').addClass('active');
            }

            if (url == $('.category').data('url') || url == 'http://localhost/source/Movie/public/paid_movie') {
                $('.url_active').removeClass('active');
                $('.genre').removeClass('active');
                $('.country').removeClass('active');
                $('.category').addClass('active');
            }

            if (url == $('.country').data('url')) {
                $('.url_active').removeClass('active');
                $('.genre').removeClass('active');
                $('.category').removeClass('active');
                $('.country').addClass('active');
            }

            $('.input-search').keyup(function(e) {
                e.preventDefault();
                var value = $(this).val().toLowerCase();
                if (value == "") {
                    $('#modal_search').hide();
                } else {
                    $('#modal_search').show();
                    $('.text_search').text(value);
                    $('#myTable').hide();
                    $('#myTable_search tr').filter(function() {
                        $('#myTable').toggle();
                        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
                    });
                }
            });

            $('.close_search').click(function(e) {
                e.preventDefault();
                $('#modal_search').hide();
            });
        });
    </script>
</body>

</html>