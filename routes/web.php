<?php

use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', function (){
    return redirect()->route('posts.index');
});

Route::resource('users','UserController',[
    'only' => ['index','show','edit','update','destroy'],
    'middleware' => ['auth']
]);
Route::resource('posts','PostController',[
    'only' => ['index'],
    'middleware'=>['auth']
]);
Route::resource('users.posts','User\PostController',[
    'only' => ['create','store','edit','update','destroy'],
    'middleware' => ['auth']
]);
