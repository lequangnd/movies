<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Social;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Laravel\Socialite\Facades\Socialite;

class SocialAuthController extends Controller
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

    private function createOrUpdateUserFacebook($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->image = 'user.png';
            $user->active = 1;
            $user->social = 0;
            $user->decentralization_id = 2;
            $user->level_id = 1;
            $user->password = bcrypt(123);
            $user->text_password = 123;
            $user->save();
            //create wallet
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->total_money = 0;
            $wallet->save();
            Auth::login($user);
            return redirect()->route('index');
        } else {
            Auth::login($user);
            return redirect()->route('index');
        }
    }

    private function createOrUpdateUserGoogle($data)
    {
        $user = User::where('email', $data->email)->first();
        if (!$user) {
            $user = new User();
            $user->name = $data->name;
            $user->email = $data->email;
            $user->image = 'user.png';
            $user->active = 1;
            $user->social = 0;
            $user->level_id = 1;
            $user->decentralization_id = 2;
            $user->password = bcrypt(123);
            $user->text_password = 123;
            $user->save();
            //create wallet
            $wallet = new Wallet();
            $wallet->user_id = $user->id;
            $wallet->total_money = 0;
            $wallet->save();
            Auth::login($user);
            return redirect()->route('index');
        } else {
            Auth::login($user);
            return redirect()->route('index');
        }
    }

    public function facebookRedirect()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function facebookCallback()
    {
        $user = Socialite::driver('facebook')->user();
        $this->createOrUpdateUserFacebook($user);
        return redirect()->route('index');
    }

    public function googleRedirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function googleCallback()
    {
        $user = Socialite::driver('google')->user();
        $this->createOrUpdateUserGoogle($user);
        return redirect()->route('index');
    }


    //facebook
    public function active_social(Request $request)
    {
        if (Auth::check()) {
            $user = User::where('email', $request->email)->first();
            $user->social = 1;
            $user->password = bcrypt($request->password);
            $user->text_password = $request->password;
            $user->save();
        }
    }
}
