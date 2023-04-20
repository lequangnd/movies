@extends('backend.layouts.master')
@section('content')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('backend/img/normal-breadcrumb.jpg')}}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="normal__breadcrumb__text">
                    <h2>Lịch sử nạp tiền</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="vh-75" style="background-color: #eee;">
    <div class="card">
        <div class="card-body">
            <div class="container mb-5 mt-3">
                <div class="row d-flex align-items-baseline">
                    <hr>
                </div>

                <div class="container">
                    <div class="row my-2 mx-1 justify-content-center">
                        <table class="table table-striped table-borderless">
                            <thead style="background-color:#84B0CA ;" class="text-white">
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ngày nạp tiền</th>
                                    <th scope="col">Số tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($history_transaction as $h)
                                <tr>
                                    <th scope="row">{{$loop->index+1}}</th>
                                    <td>{{$h->date}}</td>
                                    <td>{{$h->money}} đ</td>
                                </tr>
                                @endforeach
                            </tbody>

                        </table>
                    </div>
                    <div class="row">
                        <div class="col-xl-8">
                        </div>
                        <div class="col-xl-3">
                            <p class="text-black float-start"><span class="text-black me-3"> Tổng số tiền đã nạp: </span><span style="font-size: 20px; color:#5d9fc5" class="font-weight-bold">
                                    <?php
                                    $total = 0;
                                    foreach ($history_transaction as $h) {
                                        $total += $h->money;
                                    }
                                    echo $total;
                                    ?>
                                    đ</span></p>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection