@extends('admin.layouts.master')
@section('content')
<style>
    @import url(https://fonts.googleapis.com/css?family=Open+Sans);

    #members-tickets * {
        font-family: open sans;
    }

    #donut-title {
        width: 100%;
        text-align: center;
        font-size: 18px;
        font-family: Open Sans;
    }
</style>
<div class="container-fluid day" id="container-wrapper" data-url="{{route('day')}}">
    <div class="d-sm-flex align-items-center justify-content-between mb-4 month" data-url="{{route('month')}}">
        <h1 class="h3 mb-0 text-gray-800">Thống kê</h1>
    </div>
    <input type="date" id="date" class="border-0 mb-3">
    <select id="select_date" class="ml-3">
        <option value="0">--- Tìm kiếm theo ---</option>
        <option value="1">Ngày</option>
        <option value="2">Tháng</option>
        <option value="3">Năm</option>
    </select>
    <div class="row mb-3">
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4 year" data-url="{{route('year')}}">
            <div class="card h-100 all" data-url="{{route('all')}}">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số phim</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 total_movie">{{$movies->count()}}</div>

                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- New User Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số người dùng</div>
                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800 total_user">{{$users->count()}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số tiền người dùng đã nạp</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 money">
                                <?php 
                                $money=$history_transaction->sum('money');
                                $strlen=strlen($history_transaction->sum('money'));
                                if($strlen==6)
                                {
                                    echo substr($money,'0','3').".000 đ";
                                }elseif($strlen==7)
                                {
                                    echo substr($money,'0','1').".".substr($money,'1','3').".000 đ";
                                }elseif($strlen==8)
                                {
                                    echo substr($money,'0','2').".".substr($money,'2','3').".000 đ";
                                }
                                elseif($strlen==9)
                                {
                                    echo substr($money,'0','3').".".substr($money,'3','3').".000 đ";
                                }
                                ?>
                            </div>

                        </div>
                        <div class="col-auto">
                            <i class="fas fa-coins fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Tổng số phim người dùng đã mua</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800 paid_movie">{{$movie_user->count()}}</div>

                        </div>
                        <div class="col-auto">
                            <i class="fa fa-film fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div id="myfirstchart" style="height: 250px;"></div>
                <p class="text-center mt-3 font-weight-bold">Top 5 bộ phim có nhiều lượt xem nhất</p>
            </div>
        </div>
        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card mb-4">
                <div id="members-tickets" style="height: 250px;"></div>
                <p class="text-center mt-3 font-weight-bold">Top 5 bộ phim được đánh giá cao nhất</p>
            </div>
        </div>
    </div>
</div>
<?php
$chart = "";
$chart_star = "";
foreach ($movie as $m) {
    $chart .= "{ year:'" . $m->name . "', value:'" . $m->view . "'},";
}
foreach ($star as $s) {
    $chart_star .= "{ label:'" . $s->movies->name . "', value:'" . $s->star . "'},";
}
?>
@endsection
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
<script>
    $(document).ready(function() {

        new Morris.Bar({
            // ID of the element in which to draw the chart.
            element: 'myfirstchart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: [<?php echo $chart ?>],
            // The name of the data record attribute that contains x-values.
            xkey: 'year',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Lượt xem']
        });

        new Morris.Donut({

            element: 'members-tickets',

            data: [<?php echo $chart_star ?>]

        });

        $('#select_date').change(function(e) {
            e.preventDefault();
            if($('#date').val()=="")
            {
                alert('Vui lòng chọn thời gian thống kê');
                return false;
            }
            var day = $('#date').val();
            var date = new Date($('#date').val());
            if ($(this).val() == 1) {
                var url = $('.day').data('url');
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        date: day
                    },
                    success: function(data) {
                        $('.total_movie').text(data['movie']);
                        $('.paid_movie').text(data['movie_user']);
                        $('.total_user').text(data['user']);
                        var money=data['history_transaction'];
                        if(money.length==6)
                        {
                            $('.money').text(money.slice(0,3)+".000 đ");
                        }else if(money.length==7)
                        {
                            $('.money').text(money.slice(0,1)+"."+money.slice(1,4)+".000 đ");
                        }else if(money.length==8)
                        {
                            $('.money').text(money.slice(0,2)+"."+money.slice(2,5)+".000 đ");
                        }else if(money.length==9)
                        {
                            $('.money').text(money.slice(0,3)+"."+money.slice(3,6)+".000 đ");
                        }else if(money.length=1)
                        {
                            $('.money').text("0 đ");
                        }
                        
                    }
                });
            }
            if ($(this).val() == 2) {
                var m = date.getMonth() + 1;
                var y = date.getFullYear();
                var url = $('.month').data('url');
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        y: y,
                        m: m
                    },
                    success: function(data) {
                        $('.total_movie').text(data['movie']);
                        $('.paid_movie').text(data['movie_user']);
                        $('.total_user').text(data['user']);
                        var money=data['history_transaction'];
                        if(money.length==6)
                        {
                            $('.money').text(money.slice(0,3)+".000 đ");
                        }else if(money.length==7)
                        {
                            $('.money').text(money.slice(0,1)+"."+money.slice(1,4)+".000 đ");
                        }else if(money.length==8)
                        {
                            $('.money').text(money.slice(0,2)+"."+money.slice(2,5)+".000 đ");
                        }else if(money.length==9)
                        {
                            $('.money').text(money.slice(0,3)+"."+money.slice(3,6)+".000 đ");
                        }else if(money.length=1)
                        {
                            $('.money').text("0 đ");
                        }
                    }
                });
            }
            if ($(this).val() == 3) {
                var y = date.getFullYear();
                var url = $('.year').data('url');
                $.ajax({
                    type: 'get',
                    url: url,
                    data: {
                        y: y,
                    },
                    success: function(data) {
                        $('.total_movie').text(data['movie']);
                        $('.paid_movie').text(data['movie_user']);
                        $('.total_user').text(data['user']);
                        var money=data['history_transaction'];
                        if(money.length==6)
                        {
                            $('.money').text(money.slice(0,3)+".000 đ");
                        }else if(money.length==7)
                        {
                            $('.money').text(money.slice(0,1)+"."+money.slice(1,4)+".000 đ");
                        }else if(money.length==8)
                        {
                            $('.money').text(money.slice(0,2)+"."+money.slice(2,5)+".000 đ");
                        }else if(money.length==9)
                        {
                            $('.money').text(money.slice(0,3)+"."+money.slice(3,6)+".000 đ");
                        }else if(money.length=1)
                        {
                            $('.money').text("0 đ");
                        }
                    }
                });
            }
            if ($(this).val() == 0) {
                var url = $('.all').data('url');
                $.ajax({
                    type: 'get',
                    url: url,
                    success: function(data) {
                        $('.total_movie').text(data['movies']);
                        $('.paid_movie').text(data['movie_user']);
                        $('.total_user').text(data['users']);
                        var money=data['history_transaction'];
                        if(money.length==6)
                        {
                            $('.money').text(money.slice(0,3)+".000 đ");
                        }else if(money.length==7)
                        {
                            $('.money').text(money.slice(0,1)+"."+money.slice(1,4)+".000 đ");
                        }else if(money.length==8)
                        {
                            $('.money').text(money.slice(0,2)+"."+money.slice(2,5)+".000 đ");
                        }else if(money.length==9)
                        {
                            $('.money').text(money.slice(0,3)+"."+money.slice(3,6)+".000 đ");
                        }
                    }
                });
            }
        });
    });
</script>