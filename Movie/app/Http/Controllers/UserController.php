<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Reply;
use App\Models\Star;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class UserController extends Controller
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

    public function login()
    {
        return view('backend.users.login');
    }

    public function addLogin(Request $request)
    {
        $remember=($request->has('remember'))?true:false;
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 1],$remember)) {
            return redirect()->route('index');
        } else  if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'active' => 0])) {
            Auth::logout();
            session()->forget('email_active_account');
            session()->put('email_active_account', $request->email);
            return redirect()->route('login')->with('active_check', 'Tài khoản chưa được kích hoạt. Vui lòng');
        } else {
            return redirect()->route('login')->with('error', 'Tài khoản hoặc mật khẩu không chính xác.');
        }
    }

    public function register()
    {
        return view('backend.users.register');
    }

    public function addRegister(Request $request)
    {
        $users = User::where('email', $request->email)->first();
        if ($users) {
            return redirect()->route('register')->with('check_email', 'Email này đã tồn tại. Vui lòng chọn email khác');
        } else {
            $user = new User();
            $user->name = $request->username;
            $user->email = $request->email;
            if($request->password!=$request->password_2)
            {
                return redirect()->route('register')->with('error_password','Mật khẩu không trùng khớp');
            }
            $user->password = bcrypt($request->password);
            $user->text_password = $request->password;
            $user->image = 'user.png';
            $user->active = 0;
            $user->social = 1;
            $user->decentralization_id = 2;
            $user->level_id = 1;
            $user->save();
            //create wallet
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->total_money = 0;
            $wallet->save();
            return redirect()->route('login')->with('register', 'Đăng ký thành công. Vui lòng đăng nhập');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('index');
    }

    public function comment(Request $request, $id)
    {
        if (Auth::check()) {
            $comment = new Comment();
            $comment->user_id = Auth::user()->id;
            $comment->Content = $request->comment;
            $comment->movie_id = $id;
            $comment->date = Carbon::now('Asia/Ho_Chi_Minh');
            $comment->save();
        } else {
            return response()->json(['message' => 'ok']);
        }
    }

    public function like(Request $request)
    {
        if ($request->reply_id == null) {
            if (Auth::check()) {
                $like = new Like();
                $like->comment_id = $request->id;
                $like->user_id = Auth::user()->id;
                $like->save();
            } else {
                return response()->json(['message' => 'ok']);
            }
        } elseif ($request->reply_id != null) {
            if (Auth::check()) {
                $like = new Like();
                $like->reply_id = $request->id;
                $like->user_id = Auth::user()->id;
                $like->save();
            } else {
                return response()->json(['message' => 'ok']);
            }
        }
    }

    public function unlike(Request $request)
    {
        if ($request->like_id) {
            $like = Like::find($request->like_id);
            $like->delete();
        } else {
            if ($request->reply_id == null) {
                $like = Like::where('comment_id', $request->id)->where('user_id', Auth::user()->id)->first();
                $like->delete();
            } else {
                $like = Like::where('reply_id', $request->id)->where('user_id', Auth::user()->id)->first();
                $like->delete();
            }
        }
    }

    public function reply(Request $request)
    {
        if (Auth::check()) {
            $reply = new Reply();
            if (Reply::count() == 0) {
                $reply->id = 100;
            }
            $reply->user_id = Auth::user()->id;
            $reply->comment_id = $request->id;
            $reply->content = $request->content;
            $reply->date = Carbon::now('Asia/Ho_Chi_Minh');
            $reply->comment_user_id=$request->user_id;
            $reply->save();
        } else {
            return response()->json(['message' => 'ok']);
        }
    }

    public function follow()
    {
        if (Auth::check()) {
            $follows = Follow::where('user_id', Auth::user()->id)->get();
            $categories = Category::all();
            $genres = Genre::all();
            $countries = Country::all();
            return view('backend.users.follow', ['follows' => $follows, 'categories' => $categories, 'genres' => $genres, 'countries' => $countries]);
        } else {
            return redirect()->route('login');
        }
    }

    public function addFollow(Request $request)
    {
        if (Auth::check()) {
            $check = Follow::where('user_id', Auth::user()->id)->get();
            foreach ($check as $c) {
                if ($c->movie_id == $request->movie_id) {
                    return response()->json(['message' => 'ok']);
                }
            }
            $follow = new Follow();
            $follow->movie_id = $request->movie_id;
            $follow->user_id = Auth::user()->id;
            $follow->save();
        } else {
            return response()->json(['login' => 'ok']);
        }
    }

    public function unfollow(Request $request)
    {
        foreach ($request->list as $list) {
            $unfollow = Follow::find($list);
            $unfollow->delete();
        }
    }

    public function star(Request $request)
    {
        if (Auth::check()) {
            $star = new Star();
            $star->user_id = Auth::user()->id;
            $star->movie_id = $request->movie_id;
            $star->star = $request->id;
            $star->save();
        } else {
            return response()->json(['message' => 'ok']);
        }
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('backend.users.profile');
    }

    public function update_profile()
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        return view('backend.users.update_profile');
    }

    public function updateProfile(Request $request)
    {
        $users=User::where('email',$request->email)->first();
        $user = User::find(Auth::user()->id);
        if ($request->email != $user->email) {
            if($users)
            {
                return redirect()->route('update_profile')->with('message_error_change_email', 'Email này đã tồn tại vui lòng thay đổi email khác.');
            }
            $user->name = $request->name;
            if ($request->image == null) {
                $user->image = $user->image;
            } else {
                $user->image = $request->image;
            }
            if ($request->old_password != null && $request->new_password != null && $request->new_password_2 != null && $request->old_password == $user->text_password && $request->new_password == $request->new_password_2) {
                $user->password = bcrypt($request->new_password);
                $user->text_password = $request->new_password;
            } else if ($request->old_password != null && $request->new_password == null) {
                return redirect()->route('update_profile')->with('error_update_profile_1', 'Mật khẩu mới không được để trống');
            } else if ($request->old_password != null && $request->new_password != null && $request->new_password_2 == null) {
                return redirect()->route('update_profile')->with('error_update_profile_2', 'Vui lòng xác nhận mật khẩu mới');
            } else if ($request->old_password != null && $request->new_password != null && $request->new_password_2 != null && $request->old_password != $user->text_password) {
                return redirect()->route('update_profile')->with('error_update_profile_3', 'Mật khẩu cũ không đúng');
            } else if ($request->old_password != null && $request->new_password != null && $request->new_password_2 != null && $request->new_password != $request->new_password_2) {
                return redirect()->route('update_profile')->with('error_update_profile_4', 'Mật khẩu mới không trùng khớp');
            }
            $user->save();
            session()->forget('change_eamil');
            session()->put('change_email',$request->email);
            $token = rand(10000, 100000);
            $user = User::where('email', $user->email)->first();
            $user->token = $token;
            $user->save();
            Mail::send('backend.users.change_email', ['user' => $user, 'email' => $request->email], function ($email) use ($user) {
                $email->subject('Anime - Thay đổi email');
                $email->to($user->email, $user->name);
            });
            return redirect()->route('profile')->with('message_change_email_gmail', 'Vui lòng kiểm tra email để thay đổi email');
        } else {
            $user->name = $request->name;
            if ($request->image == null) {
                $user->image = $user->image;
            } else {
                $user->image = $request->image;
            }
            if ($request->old_password != null && $request->new_password != null && $request->new_password_2 != null && $request->old_password == $user->text_password && $request->new_password == $request->new_password_2) {
                $user->password = bcrypt($request->new_password);
                $user->text_password = $request->new_password;
            } else if ($request->old_password != null && $request->new_password == null) {
                return redirect()->route('update_profile')->with('error_update_profile_1', 'Mật khẩu mới không được để trống');
            } else if ($request->old_password != null && $request->new_password != null && $request->new_password_2 == null) {
                return redirect()->route('update_profile')->with('error_update_profile_2', 'Vui lòng xác nhận mật khẩu mới');
            } else if ($request->old_password != null && $request->new_password != null && $request->new_password_2 != null && $request->old_password != $user->text_password) {
                return redirect()->route('update_profile')->with('error_update_profile_3', 'Mật khẩu cũ không đúng');
            } else if ($request->old_password != null && $request->new_password != null && $request->new_password_2 != null && $request->new_password != $request->new_password_2) {
                return redirect()->route('update_profile')->with('error_update_profile_4', 'Mật khẩu mới không trùng khớp');
            }
            $user->save();
        }
        return redirect()->route('profile')->with('update_profile_success', 'Cập nhật thành công');
    }

    public function change_email($id,$token)
    {
        $user=User::where('id',$id)->where('token',$token)->first();
        $user->email=session()->get('change_email');
        $user->save();
        session()->forget('change_eamil');
        return redirect()->route('profile')->with('success_change_email', 'Thay đổi email thành công');
    }

    public function forget_password()
    {
        return view('backend.users.forget_password');
    }

    public function forgetPassword(Request $request)
    {
        $users = User::where('email', $request->email)->first();
        if ($users == null) {
            return redirect()->route('forget_password')->with('check_forget', 'Email này chưa đăng được đăng ký');
        }
        $token = rand(10000, 100000);
        $user = User::where('email', $request->email)->first();
        $user->token = $token;
        $user->save();
        Mail::send('backend.users.check_email_forget', ['user' => $user], function ($email) use ($user) {
            $email->subject('Anime - Lấy lại mật khẩu');
            $email->to($user->email, $user->name);
        });
        return redirect()->route('login')->with('yes', 'Vui lòng check email để lấy lại mật khẩu');
    }
    public function active($id, $token)
    {
        return view('backend.users.active', ['id' => $id, 'token' => $token]);
    }

    public function post_active(Request $request, $id, $token)
    {
        if ($request->new_password != $request->new_password_2) {
            return redirect()->route('active', [$id, $token])->with('active_error', 'Mật khẩu không trùng khớp');
        }
        $user = User::where('id', $id)->where('token', $token)->first();
        $user->password = bcrypt($request->new_password);
        $user->text_password = $request->new_password;
        $user->save();
        return redirect()->route('login')->with('ok', 'Lấy mật khẩu thành công. Vui lòng đăng nhập');
    }

    public function active_account_login()
    {
        $user = User::where('email', session()->get('email_active_account'))->first();
        $token = rand(10000, 100000);
        $user->token = $token;
        $user->save();
        Mail::send('backend.users.email_active_login', ['user' => $user], function ($email) use ($user) {
            $email->subject('Anime - Kích hoạt tài khoản');
            $email->to($user->email, $user->name);
        });
        session()->forget('email_active_account');
        return redirect()->route('login')->with('message_active_account', 'Vui lòng check email để kích hoạt tài khoản');
    }

    public function actived_login($id, $token)
    {
        $user = User::where('id', $id)->where('token', $token)->first();
        $user->active = 1;
        $user->save();
        return redirect()->route('login')->with('actived_login', 'Kích hoạt tài khoản thành công. Vui lòng đăng nhập');
    }
}
