<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\History_movie;
use App\Models\History_transaction;
use App\Models\Level;
use App\Models\Movie;
use App\Models\Movies_user;
use App\Models\Social;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class WalletController extends Controller
{

    public function __construct()
    {
        $genres = Genre::all();
        $categories = Category::all();
        $countries = Country::all();
        $movies_search=Movie::all();
        View::share('genres', $genres,);
        View::share('categories', $categories);
        View::share('countries', $countries);
        View::share('movies_search',$movies_search);
    }

    public function wallet()
    {
        session()->forget('pay_success');
        session()->forget('pay_error');
        if (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] == 00) {
            $history_transaction = new History_transaction();

            $history_transaction->user_id = Auth::user()->id;
            $history_transaction->money = $_GET['vnp_Amount'] / 100;
            $history_transaction->date = Carbon::now('Asia/Ho_Chi_Minh');
            $history_transaction->save();
            $wallet = Wallet::where('user_id', Auth::user()->id)->first();
            $wallet->total_money = $wallet->total_money + $_GET['vnp_Amount'] / 100;
            $wallet->save();
            //update level
            $total_money = 0;
            $history = History_transaction::where('user_id', Auth::user()->id)->get();
            foreach ($history as $h) {
                $total_money += $h->money;
            }
            $user = User::where('id', Auth::user()->id)->first();
            $level = Level::orderBy('quantity', 'ASC')->get();
            foreach ($level as $l) {
                if ($total_money >= $l->quantity) {
                    $user->level_id = $l->id;
                    $user->save();
                }
            }
            session()->put('pay_success', 'Nạp tiền thành công');
        } elseif (isset($_GET['vnp_ResponseCode']) && $_GET['vnp_ResponseCode'] != 00) {
            session()->put('pay_error', 'Nạp tiền thất bại');
        }
        $wallet = Wallet::where('user_id', Auth::user()->id)->first();
        return view('backend.wallet.wallet', ['wallet' => $wallet]);
    }

    public function movies_user()
    {
        $movie_user = Movies_user::where('user_id', Auth::user()->id)->get();
        $history_movies=History_movie::where('user_id',Auth::user()->id)->get();
        return view('backend.wallet.movies_user', ['movie_user' => $movie_user, 'history_movies'=>$history_movies]);
    }

    public function delete_movies_user(Request $request)
    {
        foreach ($request->list as $l) {
            $movie_user = Movies_user::find($l);
            $movie_user->delete();
        }
    }

    public function history_transaction()
    {
        $history_transaction = History_transaction::where('user_id', Auth::user()->id)->get();
        return view('backend.wallet.history_transaction', ['history_transaction' => $history_transaction]);
    }

    public function vnpay(Request $request)
    {
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost/source/Movie/public/wallet";
        $vnp_TmnCode = "5H6YM8L4"; //Mã website tại VNPAY 
        $vnp_HashSecret = "TMMVDFVDRWIZATVKKKRZYNPANCZFXDZH"; //Chuỗi bí mật

        $vnp_TxnRef = rand(); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Nạp tiền';
        $vnp_OrderType = 'vnp';
        $vnp_Amount = $request->money * 100;
        $vnp_Locale = 'vn';
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );

        if (isset($_POST['redirect'])) {
            header('Location: ' . $vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }
}
