<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Country;
use App\Models\Decentralization;
use App\Models\Follow;
use App\Models\Genre;
use App\Models\History_transaction;
use App\Models\Level;
use App\Models\Like;
use App\Models\Movie;
use App\Models\Movies_user;
use App\Models\Reply;
use App\Models\Social;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;

class Admin_categoryController extends Controller
{
    public function index()
    {
        $categories=Category::all();
        return view('admin.category.index',['categories'=>$categories]);
    }

    public function addCategory(Request $request)
    {
        $category=new Category();
        $category->name=$request->name;
        $category->save();
    }

    public function updateCategory(Request $request)
    {
        $category=Category::find($request->id);
        $category->name=$request->name;
        $category->save();
    }

    public function deleteCategory(Request $request)
    {
       Category::where('id',$request->id)->delete();
    }

    public function genre()
    {
        $genres=Genre::all();
        return view('admin.genre.index',['genres'=>$genres]);
    }

    public function addGenre(Request $request)
    {
        $genre=new Genre();
        $genre->name=$request->name;
        $genre->save();
    }
    public function updateGenre(Request $request)
    {
        $genre=Genre::find($request->id);
        $genre->name=$request->name;
        $genre->save();
    }

    public function deleteGenre(Request $request)
    {
       Genre::where('id',$request->id)->delete();
    }

    public function country()
    {
        $countries=Country::all();
        return view('admin.country.index',['countries'=>$countries]);
    }

    public function addCountry(Request $request)
    {
        $country=new Country();
        $country->name=$request->name;
        $country->save();
    }
    public function updateCountry(Request $request)
    {
        $country=Country::find($request->id);
        $country->name=$request->name;
        $country->save();
    }

    public function deleteCountry(Request $request)
    {
       Country::where('id',$request->id)->delete();
    }

    public function user()
    {
        $users=User::all();
        $decentralization=Decentralization::all();
        return view('admin.user.index',['users'=>$users,'decentralization'=>$decentralization]);
    }

    public function deleteUser($id)
    {
        $user=User::find($id);
        Comment::where('user_id',$id)->delete();
        Follow::where('user_id',$id)->delete();
        Wallet::where('user_id',$id)->delete();
        Movies_user::where('user_id',$id)->delete();
        Like::where('user_id',$id)->delete();
        Reply::where('user_id',$id)->delete();
        History_transaction::where('user_id',$id)->delete();
        $user->delete();
        return redirect()->route('admin-user');

    }

    public function updateDecentralization(Request $request)
    {
        $decentralization=User::find($request->user_id);
        $decentralization->decentralization_id=$request->id;
        $decentralization->save();
    }

    public function level()
    {
        $level=Level::all();
        return view('admin.level.index',['level'=>$level]);
    }

    public function addLevel(Request $request)
    {
        $level=new Level();
        $level->name=$request->name;
        $level->discount=$request->discount;
        $level->quantity=$request->quantity;
        $level->save();
    }

    public function updateLevel(Request $request)
    {
        $level=Level::find($request->id);
        $level->name=$request->name;
        $level->discount=$request->discount;
        $level->quantity=$request->quantity;
        $level->save();
    }

    public function deleteLevel(Request $request)
    {
        $user=User::where('level_id',$request->id)->count();
        $social=Social::where('level_id',$request->id)->count();
        if($user !=0 || $social !=0)
        {
            return response()->json(['message'=>'ok']);
        }else{
            $level=Level::find($request->id);
            $level->delete();
        }
       
    }
}
