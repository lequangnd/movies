@extends('backend.layouts.master')
@section('content')
<section class="normal-breadcrumb set-bg" data-setbg="{{asset('backend/img/normal-breadcrumb.jpg')}}">
  <div class="container">
    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="normal__breadcrumb__text">
          <h2>Tài khoản</h2>
        </div>
      </div>
    </div>
  </div>
</section>
<section class="" style="background-color: #eee;">
  <div class="container py-5 h-0">
    <div class="row d-flex justify-content-center align-items-center h-0">
      <div class="col col-md-9 col-lg-7 col-xl-5">
        <div class="card" style="border-radius: 15px;">
          @if(session()->get('pay_error'))
          <div class="alert alert-danger" role="alert">
            {{session()->get('pay_error')}}
          </div>
          @endif
          @if(session()->get('pay_success'))
          <div class="alert alert-success" role="alert">
            {{session()->get('pay_success')}}
          </div>
          @endif
          <div class="card-body p-4">
            <div class="d-flex text-black">
              <div class="flex-shrink-0">
                <img src="{{asset('images/'.Auth::user()->image)}}" alt="Generic placeholder image" class="img-fluid" style="width: 180px; border-radius: 10px; margin-right:20px;">
              </div>
              <div class="flex-grow-1 ms-3">
                <h5 class="mb-1 font-weight-bold">{{Auth::user()->name}}</h5>
                <?php
                $user=$wallet->users;
                ?>
                <p class="mb-2 pb-1" style="color: #2b2a2a;">cấp bậc: <span class="text-info">{{$user->level->name}}</span></p>
                <div class="d-flex justify-content-start rounded-3 p-2 mb-2" style="background-color: #efefef;">
                  <div>
                    @if(isset($wallet->total_money))
                    <p class="small text-muted mb-1">Số dư : <span class="font-weight-bold text-warning">{{$wallet->total_money}} đ</span></p>
                    @else
                    <p class="small text-muted mb-1">Số dư : <span class="font-weight-bold text-warning">0 đ</span></p>
                    @endif
                  </div>
                </div>
                <div class="d-flex pt-1">
                  <a href="{{route('history_transaction')}}"><button type="button" class="btn btn-outline-primary me-1 flex-grow-1 mr-2">Lịch sử</button></a>
                  <a href="#"><button type="button" class="btn btn-outline-primary me-1 flex-grow-1 mr-2 active btn-modal">Nạp tiền</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<div class="modal" id="modal_wellet" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title font-weight-bold">Nạp tiền</h5>
        <button type="button" class="close_wellet border-0" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('vnpay')}}" method="post">
        @csrf
        <div class="modal-body">
          <input type="text" name="money" placeholder="Nhập số tiền nạp..." class="border-0 w-100">
        </div>
        <div class="modal-footer">
          <button type="submit" name="redirect" class="btn btn-info">Thanh toán</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
  $(document).ready(function() {
    $('#modal_wellet').hide();
    $('.btn-modal').click(function(e) {
      e.preventDefault();
      $('#modal_wellet').show();
    });

    $('.close_wellet').click(function(e) {
      e.preventDefault();
      $('#modal_wellet').hide();
    })
  });
</script>