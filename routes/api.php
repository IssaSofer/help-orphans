<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post("register", "RegisterController@register");
Route::post("login", "LoginController@login");
Route::get("/", "api\homeController@welcome");


Route::middleware('auth:api')->group(function() {
    Route::resource("post", "api\postController");
    Route::put("change/{id}", "api\postController@change");
    Route::resource("profile", "api\profileController");
    Route::post("logout", "api\profileController@logout");
    Route::get("search", "api\searchController@list");
    Route::get("search/crop/{id}", "api\searchController@showcrop");
    Route::get("home", "api\homeController@index");
    Route::get("savepost", "api\savepostController@index");
    Route::get("user/{id}/{donate}/message/{post}", "api\chatController@getMessage");
    Route::post("user/{id}/{donate}/message/{post}", "api\chatController@sendMessage");
    Route::resource("donate", "api\donateController");
});