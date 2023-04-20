<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Details_genre;
use App\Models\Espisode;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\Movies_user;
use App\Models\Paid_movie;
use App\Models\Star;
use App\Models\Trailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\ErrorHandler\Debug;

class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::all();
        $categories = Category::all();
        $genres = Genre::all();
        return view('admin.movies.index', ['movies' => $movies, 'categories' => $categories, 'genres' => $genres]);
    }

    public function add()
    {
        $categories = Category::all();
        $genres = Genre::all();
        $countries = Country::all();
        return view('admin.movies.add', ['categories' => $categories, 'genres' => $genres, 'countries' => $countries]);
    }

    public function addMovie(Request $request)
    {
        $movie = new Movie();
        $movie->name = $request->name;
        $movie->category_id = $request->category;
        $movie->country_id = $request->country;
        $movie->image = $request->image;
        $movie->actor = $request->actor;
        $movie->duration = $request->duration;
        $movie->date = $request->date;
        $movie->total_espisode = $request->total_espisode;
        $movie->paid_movie = $request->paid_movie;
        $movie->description = $request->description;
        $movie->save();
        if ($request->genre != null) {
            foreach ($request->genre as $g) {
                $details_genre = new Details_genre();
                $details_genre->genre_id = $g;
                $details_genre->movie_id = $movie->id;
                $details_genre->save();
            }
        }
        if ($request->paid_movie == 1) {
            $paid_movie = new Paid_movie();
            $paid_movie->movie_id = $movie->id;
            $paid_movie->money = $request->price_movie;
            $paid_movie->save();
        }

        return redirect()->route('movie');
    }

    public function update($id)
    {
        $categories = Category::all();
        $genres = Genre::all();
        $countries = Country::all();
        $movie = Movie::find($id);
        $details_genres = Details_genre::where('movie_id', $id)->get();
        if ($movie->paid_movies->count() != 0) {
            $paid_movie = Paid_movie::where('movie_id', $id)->first();
        } else {
            $paid_movie = null;
        }
        return view('admin.movies.update', ['categories' => $categories, 'genres' => $genres, 'countries' => $countries, 'movie' => $movie, 'details_genres' => $details_genres, 'paid_movie' => $paid_movie]);
    }

    public function updateMovie(Request $request, $id)
    {
        $movie = Movie::find($id);
        $movie->name = $request->name;
        $movie->category_id = $request->category;
        $movie->country_id = $request->country;
        if ($request->image == null) {
            $movie->image = $movie->image;
        } else {
            $movie->image = $request->image;
        }
        $movie->actor = $request->actor;
        $movie->duration = $request->duration;
        $movie->date = $request->date;
        $movie->total_espisode = $request->total_espisode;
        $movie->paid_movie = $request->paid_movie;
        $movie->description = $request->description;
        $movie->save();
        if ($movie->paid_movies->count() == 0) {
            if ($request->paid_movie == 1) {
                $paid_movie = new Paid_movie();
                $paid_movie->movie_id = $id;
                $paid_movie->money = $request->price_movie;
                $paid_movie->save();
            }
        } else {
            if ($request->paid_movie == 0) {
                Paid_movie::where('movie_id', $id)->delete();
            }
        }

        foreach ($request->genre as $g) {
            $details_genre = Details_genre::where('movie_id', $id)->where('genre_id', $g)->first();
            if (!$details_genre) {
                $details_genre = new Details_genre();
                $details_genre->genre_id = $g;
                $details_genre->movie_id = $id;
                $details_genre->save();
            }
        }
        $details_genre = Details_genre::where('movie_id', $id)->get();
        if ($details_genre->count() > count($request->genre)) {
            Details_genre::where('movie_id', $id)->delete();
            foreach ($request->genre as $g) {
                $details_genre = new Details_genre();
                $details_genre->genre_id = $g;
                $details_genre->movie_id = $id;
                $details_genre->save();
            }
        }

        return redirect()->route('movie');
    }

    public function deleteMovie(Request $request)
    {
        $movie = Movie::find($request->id);
        Espisode::where('movie_id', $request->id)->delete();
        Details_genre::where('movie_id', $request->id)->delete();
        Follow::where('movie_id', $request->id)->delete();
        Comment::where('movie_id', $request->id)->delete();
        Star::where('movie_id', $request->id)->delete();
        Movies_user::where('movie_id', $request->id)->delete();
        Paid_movie::where('movie_id', $request->id)->delete();
        $movie->delete();
    }

    public function espisode($id)
    {
        $movie = Movie::find($id);
        $espisode = Espisode::where('movie_id', $id)->get();
        $trailer = Trailer::where('movie_id', $id)->get();
        return view('admin.movies.espisode', ['espisode' => $espisode, 'movie' => $movie, 'trailer' => $trailer]);
    }

    public function addEspisode(Request $request)
    {
        $espisode_check = Espisode::where('movie_id', $request->id)->get();
        foreach ($espisode_check as $e) {
            if ($request->espisode == $e->espisode) {
                return response()->json(['message' => 'ok']);
            }
        }
        $espisode = new Espisode();
        $espisode->movie_id = $request->id;
        $espisode->espisode = $request->espisode;
        $espisode->link1 = $request->link1;
        $espisode->link2 = $request->link2;
        $espisode->save();
        $now_espisode = Espisode::where('movie_id', $request->id)->count();
        $movie = Movie::find($request->id);
        $movie->now_espisode = $now_espisode;
        $movie->save();
    }

    public function deleteEspisode(Request $request)
    {
        Espisode::where('id', $request->id)->delete();
    }

    public function updateEspisode(Request $request)
    {
        $espisode = Espisode::find($request->id);
        $espisode_check = Espisode::where('movie_id', $request->movie_id)->get();
        foreach ($espisode_check as $e) {
            if ($request->espisode != $espisode->espisode && $request->espisode == $e->espisode) {
                return response()->json(['message' => 'ok']);
            }
        }
        $espisode->espisode = $request->espisode;
        $espisode->link1 = $request->link1;
        $espisode->link2 = $request->link2;
        $espisode->save();
        $now_espisode = Espisode::where('movie_id', $request->movie_id)->count();
        $movie = Movie::find($request->movie_id);
        $movie->now_espisode = $now_espisode;
        $movie->save();
    }

    public function addTrailer(Request $request)
    {
        $trailer = Trailer::where('movie_id', $request->id)->count();
        if ($trailer > 0) {
            return response()->json(['message' => 'ok']);
        }
        $trailer = new Trailer();
        $trailer->movie_id = $request->id;
        $trailer->link = $request->link_trailer;
        $trailer->save();
    }

    public function updateTrailer(Request $request)
    {
        $trailer = Trailer::find($request->id);
        $trailer->link = $request->link_trailer;
        $trailer->save();
    }

    public function deleteTrailer(Request $request)
    {
        $trailer = Trailer::find($request->id);
        $trailer->delete();
    }

    public function loginAdmin()
    {
        return view('admin.user.loginadmin');
    }

    public function postLoginAdmin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'decentralization_id' => 1])) {
            session()->forget('name_gmail');
            session()->put('name_gmail', Auth::user()->name);
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('loginAdmin')->with('errorLoginAdmin', 'Mật khẩu hoặc tài khoản không chính xác');
        }
    }

    public function logoutAdmin()
    {
        Auth::logout();
        session()->forget('name_facebook');
        session()->forget('name_gmail');
        session()->forget('id_facebook');
        return redirect()->route('loginAdmin');
    }
}
