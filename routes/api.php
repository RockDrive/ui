<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Repositories\BlogRepository;
use App\Models\User;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Auth::loginUsingId(1);

Route::get("test/{vps}", [\App\Http\Controllers\Admin\Servers\VpsController::class, "index"]);


// routes/api.php
//Route::get("test/{blog_id}", function ($blog_id, App\Repositories\BlogRepository $blogs) {
//    $blog = $blogs->find($blog_id);
//    return $blog;
//});
//
//Route::get("test/{blog}", function (App\Repositories\BlogRepository $blog) {
//    return $blog;
//});

//
