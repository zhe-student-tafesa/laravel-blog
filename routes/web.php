<?php

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

Route::get('/fz', function () {
    echo 'get方法';
});

Route::post('/fz', function () {
    echo 'post方法,需要在 VerifyCsrfToken.php 增加 网址';
});


Route::put('/fz', function () {
    echo 'put方法';
});



Route::delete('/fz', function () {
    echo 'delete 方法';
});



Route::patch('/fz', function () {
    echo 'patch 方法';
});



Route::options('/fz', function () {
    echo 'options 方法';
});


//匹配[] 里的这几个方法，任何 一个方法都会 执行 该函数
Route::match(['get', 'post'], '/test', function () {//如果 路径是'/test' ，使用 post或者get 都会 返回 'This is a request from get or post'
    return 'This is a request from get or post';
});


Route::any('bar', function () {//如果 路径是'/bar' ，使用 post或者get或任何 一个请求， 都会 返回 'This is a request from any HTTP verb'
    return 'This is a request from any HTTP verb';
});

// //传递 参数
// Route::get('user/{id}', function ($id) {
//     return 'User ' . $id;
// });

//传递  2个 参数
Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
    return $postId . '-' . $commentId;
});

//正则约束 id 必须 是 数字
Route::get('user/{id}', function ($id) {
    // $id 必须是数字
    return 'User ' . $id;
})->where('id', '[0-9]+');
