<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Details_genre;
use App\Models\Espisode;
use App\Models\Genre;
use App\Models\History_movie;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Movies_user;
use App\Models\Paid_movie;
use App\Models\Reply;
use App\Models\Social;
use App\Models\Star;
use App\Models\Trailer;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class BackendController extends Controller
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
    public function index()
    {
        $banner = Banner::all();
        $movies = Movie::where('category_id', 1)->where('paid_movie',0)->take(6)->get();
        $moives_odd = Movie::where('category_id', 2)->where('paid_movie',0)->take(6)->get();
        $movie_paid=Movie::where('paid_movie',1)->take(6)->get();
        $categories = Category::all();
        $genre = Genre::all();
        $view = Movie::orderByDesc('view')->take(3)->get();
        $top_star = Star::groupBy('movie_id')->selectRaw('movie_id, ROUND(AVG(star),1) as star')->orderBy('star','DESC')->take(2)->get();
        return view('backend.index', ['movies' => $movies, 'categories' => $categories, 'view' => $view, 'top_star' => $top_star, 'genres' => $genre, 'movies_odd' => $moives_odd, 'movie_paid'=>$movie_paid, 'banner' => $banner]);
    }

    public function details($id)
    {
        $trailer=Trailer::where('movie_id',$id)->first();
        if(Auth::check())
        {
            $like=Like::where('user_id',Auth::user()->id)->get();
        }else{
            $like=null;
        }
        $espisode = Espisode::where('movie_id', $id)->count();
        $star = Star::where('movie_id', $id)->get();
        $comments = Comment::where('movie_id', $id)->get();
        $movie = Movie::find($id);
        $category = Category::find($movie->category_id);
        $category_movie = Movie::where('category_id', $category->id)->where('id', '<>', $id)->orderByDesc('created_at')->take(6)->get();
        if (Auth::check() && $movie->paid_movie==1) {
            $movie_user = Movies_user::where('movie_id', $id)->where('user_id', Auth::user()->id)->first();
            $paid_movie = Paid_movie::where('movie_id', $id)->first();
            $user=User::where('id',Auth::user()->id)->first();
            $money=$paid_movie->money * ((100 - $user->level->discount)/100);
        }else{
            $movie_user=null;
            $money=null;
        }
        return view('backend.details', ['movie' => $movie, 'comments' => $comments, 'category_movie' => $category_movie, 'star' => $star, 'espisode' => $espisode, 'movie_user' => $movie_user, 'money' => $money, 'like'=>$like, 'trailer'=>$trailer]);
    }

    public function buy_movie(Request $request)
    {
        if(Auth::check())
        { 
            $wallet=Wallet::where('user_id',Auth::user()->id)->first();
            if($wallet->total_money >= $request->money)
            {
            $movie_user=new Movies_user();
            $movie_user->movie_id=$request->movie_id;
            $movie_user->user_id=Auth::user()->id;
            $movie_user->save();
            $wallet->total_money=$wallet->total_money - $request->money;
            $wallet->save();
            $history_movies=new History_movie();
            $history_movies->movie_id=$request->movie_id;
            $history_movies->user_id=Auth::user()->id;
            $history_movies->date=Carbon::now('Asia/Ho_Chi_Minh');
            $history_movies->money=$request->money;
            $history_movies->save();
            }else{
                return response()->json(['money'=>'ok']);
            }
        }else{
            return response()->json(['message'=>'ok']);
        }
    }

    public function category($id)
    {
        $view = Movie::orderByDesc('view')->take(3)->get();
        $top_comment = Comment::selectRaw('movie_id, count(Content) as total_comment')->groupBy('movie_id')->orderByDesc('total_comment')->take(2)->get();
        $category = Category::find($id);
        return view('backend.category', ['category' => $category, 'view' => $view, 'top_comment' => $top_comment]);
    }

    public function paid_movies()
    {
        $movies = Movie::where('paid_movie', 1)->where('category_id',1)->get();
        $movie_odd=Movie::where('paid_movie',1)->where('category_id',2)->get();
        return view('backend.paid_movie', ['movies' => $movies,'movie_odd'=>$movie_odd]);
    }

    public function paid_movies_category($id)
    {
        $categories = Category::all();
        $genre = Genre::all();
        if($id==1)
        {
            $paid_movies=Movie::where('category_id',1)->where('paid_movie',1)->get();
        }elseif($id==2){
            $paid_movies=Movie::where('category_id',2)->where('paid_movie',1)->get();
        }
        return view('backend.paid_movie_category',['paid_movies'=>$paid_movies,'id'=>$id, 'categories'=>$categories, 'genre'=>$genre]);
    }
    public function genre($id)
    {
        $view = Movie::orderByDesc('view')->take(3)->get();
        $top_comment = Comment::selectRaw('movie_id, count(Content) as total_comment')->groupBy('movie_id')->orderByDesc('total_comment')->take(2)->get();
        $genre = Genre::find($id);
        $details_genres = Details_genre::where('genre_id', $genre->id)->get();
        return view('backend.genre', ['details_genres' => $details_genres, 'genre' => $genre, 'view' => $view, 'top_comment' => $top_comment]);
    }
    public function country($id)
    {
        $view = Movie::orderByDesc('view')->take(3)->get();
        $top_comment = Comment::selectRaw('movie_id, count(Content) as total_comment')->groupBy('movie_id')->orderByDesc('total_comment')->take(2)->get();
        $country = Country::find($id);
        return view('backend.country', ['country' => $country, 'view' => $view, 'top_comment' => $top_comment]);
    }

    public function watching($id)
    {
        if(Auth::check())
        {
            $like=Like::where('user_id',Auth::user()->id)->get();
        }else{
            $like=null;
        }
        $comments = Comment::where('movie_id', $id)->get();
        $espisode = Espisode::where('movie_id', $id)->get();
        $link = Espisode::where('movie_id', $id)->first();
        $movie = Movie::find($id);
        $movie->view += 1;
        $movie->save();
        return view('backend.watching', ['espisode' => $espisode, 'link' => $link, 'comments' => $comments, 'movie' => $movie, 'like'=>$like]);
    }

    public function watching_espisode($id, $movie_id)
    {
        if(Auth::check())
        {
            $like=Like::where('user_id',Auth::user()->id)->get();
        }else{
            $like=null;
        }
        $comments = Comment::where('movie_id', $movie_id)->get();
        $espisode = Espisode::where('movie_id', $movie_id)->get();
        $link = Espisode::where('id', $id)->first();
        $movie = Movie::find($movie_id);
        $movie->view += 1;
        $movie->save();
        return view('backend.watching', ['espisode' => $espisode, 'link' => $link, 'comments' => $comments, 'movie' => $movie, 'like'=>$like]);
    }

    public function search(Request $request)
    {
        $movies = Movie::where('name', 'like', '%' . $request->key . '%')->get();
        $categories = Category::all();
        $genres = Genre::all();
        return view('backend.search', ['movies' => $movies, 'categories' => $categories, 'genres' => $genres, 'key' => $request->key]);
    }
}
