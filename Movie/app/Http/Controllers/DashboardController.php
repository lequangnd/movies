<?php

namespace App\Http\Controllers;

use App\Models\History_transaction;
use App\Models\Movie;
use App\Models\Movies_user;
use App\Models\Star;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $movie = Movie::selectRaw('name, view')->orderBy('view', 'DESC')->take(5)->get();
        $star = Star::groupBy('movie_id')->selectRaw('movie_id, ROUND(AVG(star),1) as star')->orderby('star', 'DESC')->take(5)->get();
        $movies = Movie::all();
        $history_transaction = History_transaction::all();
        $users = User::all();
        $movie_user = Movies_user::all();
        return view('admin.dashboard.index', ['movie' => $movie, 'star' => $star, 'movies' => $movies, 'users' => $users, 'movie_user' => $movie_user, 'history_transaction' => $history_transaction]);
    }

    public function day(Request $request)
    {
        $movie = Movie::whereDate('created_at', $request->date)->count();
        $user = User::whereDate('created_at', $request->date)->count();
        $movie_user=Movies_user::whereDate('created_at',$request->date)->count();
        $history_transaction = History_transaction::whereDate('created_at', $request->date)->sum('money');
        return response()->json(['movie' => $movie, 'user' => $user, 'history_transaction' => $history_transaction, 'movie_user'=>$movie_user]);
    }

    public function month(Request $request)
    {
        $movie = Movie::whereMonth('created_at', $request->m)->whereYear('created_at', $request->y)->count();
        $user = User::whereMonth('created_at', $request->m)->whereYear('created_at', $request->y)->count();
        $movie_user=Movies_user::whereMonth('created_at',$request->m)->whereYear('created_at',$request->y)->count();
        $history_transaction = History_transaction::whereMonth('created_at', $request->m)->whereYear('created_at',$request->y)->sum('money');
        return response()->json(['movie' => $movie, 'user' => $user, 'history_transaction' => $history_transaction,'movie_user'=>$movie_user]);
    }
    public function year(Request $request)
    {
        $movie = Movie::whereYear('created_at', $request->y)->count();
        $user = User::whereYear('created_at', $request->y)->count();
        $movie_user=Movies_user::whereYear('created_at',$request->y)->count();
        $history_transaction = History_transaction::whereYear('created_at', $request->y)->sum('money');
        return response()->json(['movie' => $movie, 'user' => $user, 'history_transaction' => $history_transaction, 'movie_user'=>$movie_user]);
    }
    public function all()
    {
        $movies = Movie::all()->count();
        $users = User::all()->count();
        $movie_user = Movies_user::count();
        $history_transaction = History_transaction::sum('money');
        return response()->json(['movies' => $movies, 'history_transaction' => $history_transaction, 'users' => $users, 'movie_user'=>$movie_user]);
    }
}
