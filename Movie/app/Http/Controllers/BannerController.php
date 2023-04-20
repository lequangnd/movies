<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $movies=Movie::all();
        $banner=Banner::all();
        $categories = Category::all();
        $genres = Genre::all();
        return view('admin.banner.index',['movies'=>$movies,'banner'=>$banner, 'categories' => $categories, 'genres' => $genres]);
    }

    public function addBanner(Request $request)
    {
        $banner=new Banner();
        $banner->content=$request->content;
        $banner->image=$request->image;
        $banner->movie_id=$request->movie_id;
        $banner->status=0;
        $banner->save();
    }

    public function status(Request $request)
    {
        $banner=Banner::find($request->id);
        $banner->status=$request->status;
        $banner->save();
    }

    public function updateBanner(Request $request)
    {
        $banner=Banner::find($request->id);
        $banner->content=$request->content;
        if($request->image==null){
            $banner->image=$banner->image;
        }else{
            $banner->image=$request->image;
        }
        $banner->movie_id=$request->movie_id;
        $banner->save();
    }

    public function deleteBanner(Request $request)
    {
        $banner=Banner::find($request->id);
        $banner->delete();
    }
}