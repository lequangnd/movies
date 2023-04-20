<?php

use App\Http\Controllers\Admin_categoryController;
use App\Http\Controllers\BackendController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SocialAuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/admin/login/admin',[MovieController::class,'loginAdmin'])->name('loginAdmin');
Route::post('/admin/login/admin',[MovieController::class,'postLoginAdmin'])->name('postLoginAdmin');
Route::get('/admin/logout/admin',[MovieController::class,'logoutAdmin'])->name('logoutAdmin');
Route::middleware(['loginAdmin'])->group(function()
{
//admin movie
Route::get('/admin/movie/index',[MovieController::class,'index'])->name('movie');
Route::get('/admin/movie/add',[MovieController::class,'add'])->name('add-movie');
Route::post('/admin/movie/add',[MovieController::class,'addMovie'])->name('addMovie');
Route::get('/admin/movie/update/{id}',[MovieController::class,'update'])->name('update-movie');
Route::post('/admin/movie/update/{id}',[MovieController::class,'updateMovie'])->name('updateMovie');
Route::get('/admin/movie/delete',[MovieController::class,'deleteMovie'])->name('deleteMovie');
Route::get('/admin/movie/espisode/{id}',[MovieController::class,'espisode'])->name('espisode');
Route::get('/admin/movie/espisode_add',[MovieController::class,'addEspisode'])->name('addEspisode');
Route::get('/admin/movie/espisode_update',[MovieController::class,'updateEspisode'])->name('updateEspisode');
Route::get('/admin/movie/espisode_delete',[MovieController::class,'deleteEspisode'])->name('deleteEspisode');
Route::get('/admin/movie/trailer_add',[MovieController::class,'addTrailer'])->name('addTrailer');
Route::get('/admin/movie/trailer_update',[MovieController::class,'updateTrailer'])->name('updateTrailer');
Route::get('/admin/movie/trailer_delete',[MovieController::class,'deleteTrailer'])->name('deleteTrailer');

//dashboard
Route::get('/admin/movie/dashboard',[DashboardController::class,'index'])->name('dashboard');
Route::get('/admin/movie/dashboard/day',[DashboardController::class,'day'])->name('day');
Route::get('/admin/movie/dashboard/month',[DashboardController::class,'month'])->name('month');
Route::get('/admin/movie/dashboard/year',[DashboardController::class,'year'])->name('year');
Route::get('/admin/movie/dashboard/all',[DashboardController::class,'all'])->name('all');

//admin category genre country level
Route::get('/admin/category/index',[Admin_categoryController::class,'index'])->name('admin-category');
Route::get('/admin/category/add',[Admin_categoryController::class,'addCategory'])->name('addCategory');
Route::get('/admin/category/update',[Admin_categoryController::class,'updateCategory'])->name('updateCategory');
Route::get('/admin/category/delete',[Admin_categoryController::class,'deleteCategory'])->name('deleteCategory');

Route::get('/admin/genre/index',[Admin_categoryController::class,'genre'])->name('admin-genre');
Route::get('/admin/genre/add',[Admin_categoryController::class,'addGenre'])->name('addGenre');
Route::get('/admin/genre/update',[Admin_categoryController::class,'updateGenre'])->name('updateGenre');
Route::get('/admin/genre/delete',[Admin_categoryController::class,'deleteGenre'])->name('deleteGenre');

Route::get('/admin/country/index',[Admin_categoryController::class,'country'])->name('admin-country');
Route::get('/admin/country/add',[Admin_categoryController::class,'addCountry'])->name('addCountry');
Route::get('/admin/country/update',[Admin_categoryController::class,'updateCountry'])->name('updateCountry');
Route::get('/admin/country/delete',[Admin_categoryController::class,'deleteCountry'])->name('deleteCountry');

Route::get('/admin/user/index',[Admin_categoryController::class,'user'])->name('admin-user');
Route::get('/admin/user/delete/{id}',[Admin_categoryController::class,'deleteUser'])->name('admin-user-delete');
Route::get('/admin/user/decentralization',[Admin_categoryController::class,'updateDecentralization'])->name('updateDecentralization');

Route::get('/admin/level/index',[Admin_categoryController::class,'level'])->name('admin-level');
Route::get('/admin/level/add',[Admin_categoryController::class,'addLevel'])->name('addLevel');
Route::get('/admin/level/update',[Admin_categoryController::class,'updateLevel'])->name('updateLevel');
Route::get('/admin/level/delete',[Admin_categoryController::class,'deleteLevel'])->name('deleteLevel');

//banner
Route::get('/admin/banner/index',[BannerController::class,'index'])->name('banner');
Route::get('/admin/banner_add',[BannerController::class,'addBanner'])->name('addBanner');
Route::get('/admin/banner_status',[BannerController::class,'status'])->name('statusBanner');
Route::get('/admin/banner_update',[BannerController::class,'updateBanner'])->name('updateBanner');
Route::get('/admin/banner_delete',[BannerController::class,'deleteBanner'])->name('deleteBanner');
});


//index
Route::get('/index',[BackendController::class,'index'])->name('index');
Route::get('/details/{id}',[BackendController::class,'details'])->name('details');
Route::get('/category/{id}',[BackendController::class,'category'])->name('category');
Route::get('/paid_movies',[BackendController::class,'paid_movies'])->name('paid_movies');
Route::get('/paid_movies_category/{id}',[BackendController::class,'paid_movies_category'])->name('paid_movies_category');
Route::get('/genre/{id}',[BackendController::class,'genre'])->name('genre');
Route::get('/country/{id}',[BackendController::class,'country'])->name('country');
Route::get('/watching/{id}',[BackendController::class,'watching'])->name('watching');
Route::get('/watching_espisode/{id}/{movie_id}',[BackendController::class,'watching_espisode'])->name('watching-espisode');
Route::get('/search',[BackendController::class,'search'])->name('search');
Route::get('/buy_movie',[BackendController::class,'buy_movie'])->name('buy_movie');

//user
Route::get('/login',[UserController::class,'login'])->name('login');
Route::post('/login',[UserController::class,'addLogin'])->name('addLogin');
Route::get('/register',[UserController::class,'register'])->name('register');
Route::post('/register',[UserController::class,'addRegister'])->name('addRegister');
Route::get('/logout',[UserController::class,'logout'])->name('logout');

Route::get('/comment/{id}',[UserController::class,'comment'])->name('comment');

Route::get('/like',[UserController::class,'like'])->name('like');
Route::get('/unlike',[UserController::class,'unlike'])->name('unlike');

Route::get('/reply',[UserController::class,'reply'])->name('reply');

Route::get('/profile',[UserController::class,'profile'])->name('profile');
Route::get('/profile/update',[UserController::class,'update_profile'])->name('update_profile');
Route::post('/profile/update',[UserController::class,'updateProfile'])->name('updateProfile');
Route::get('/profile/change_email/{id}/{token}',[UserController::class,'change_email'])->name('change_email');

Route::get('/forget_password',[UserController::class,'forget_password'])->name('forget_password');
Route::post('/forget_password',[UserController::class,'forgetPassword'])->name('forgetPassword');
Route::get('/active/{id}/{token}',[UserController::class,'active'])->name('active');
Route::post('/active/{id}/{token}',[UserController::class,'post_active'])->name('post_active');

Route::get('/account_active',[UserController::class,'active_account_login'])->name('active_account_login');
Route::get('/actived_login/{id}/{token}',[UserController::class,'actived_login'])->name('actived_login');

Route::get('/follow',[UserController::class,'follow'])->name('follow');
Route::get('/follow_add',[UserController::class,'addFollow'])->name('addFollow');
Route::get('/unfollow',[UserController::class,'unfollow'])->name('unfollow');

Route::get('/star',[UserController::class,'star'])->name('star');

//social
Route::get('/active_social',[SocialAuthController::class,'active_social'])->name('active_social');

//login facebook and login google
Route::get('/auth/facebook/redirect',[SocialAuthController::class,'facebookRedirect'])->name('facebookRedirect');
Route::get('/auth/facebook/callback',[SocialAuthController::class,'facebookCallback'])->name('facebookCallback');
Route::get('/auth/google/redirect',[SocialAuthController::class,'googleRedirect'])->name('googleRedirect');
Route::get('/auth/google/callback',[SocialAuthController::class,'googleCallback'])->name('googleCallback');

//wallet
Route::get('/wallet',[WalletController::class,'wallet'])->name('wallet');
Route::get('/movies_user',[WalletController::class,'movies_user'])->name('movies_user');
Route::get('/delete_movies_user',[WalletController::class,'delete_movies_user'])->name('delete_movies_user');
Route::get('/history_transaction',[WalletController::class,'history_transaction'])->name('history_transaction');

//vnpay
Route::post('/vnpay',[WalletController::class,'vnpay'])->name('vnpay');
