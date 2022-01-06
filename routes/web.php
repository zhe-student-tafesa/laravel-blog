<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\IndexController; // lavarel 8 必须 先 引入  
use App\Http\Controllers\Admin\ArticleController; // lavarel 8 必须 先 引入  
//引入 LoginController
use App\Http\Controllers\Admin\LoginController; // lavarel 8 必须 先 引入

use App\Http\Controllers\ViewController;  //ViewController

//use App\Http\Controllers\IndexController; // lavarel 8 必须 先 引入 

use App\Http\Middleware\AdminLogin;

//CategoryController
use App\Http\Controllers\Admin\CategoryController;

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




// //正常 是通过 控制器处理后 再 做出 回应: 本例子：当用户 访问**/test时，调用控制器IndexControllers的index方法   
// Route::get('test', [IndexControllers::class,'index']);



// Route::get('user',['as'=> 'profile', function () {
//     // 通过路由名称生成 URL
//     return '命名 路由my url: ' . route('profile');
// }]) ;



// //控制器  命名 路由

// Route::get(
//     '/user/profile2',
//     [IndexControllers::class, 'index']
// )->name('profile2');
 

// Route::get('Admin/login', [IndexControllers::class,'login']);
// Route::get('Admin/index', [IndexControllers::class,'index']);



// Route::prefix('Admin')->group(function () {                    // 分组后    **区分 大小写
//     //Route::get('login', [IndexControllers::class,'login']);
//     Route::get('index', [IndexControllers::class,'index'])->middleware([AdminLogin::class]); // 调用admin.login中间件  ['middleware' => ['web','admin.login']],
    
// });//['middleware' => ['admin.login']],
// Route::get('Admin/login', [IndexControllers::class,'login']);//使用 web 可以 操作 session




//资源 路由
// Route::prefix('Admin')->group(function () {                    // 分组后    **区分 大小写
//     Route::resource('article', ArticleController::class);//官网  牛逼 
    
// });


// Route::get('/test', function () {
//     echo 'test11';
//     //
// })->middleware([AdminLogin::class,'web']);


 
// Route::get('/view', function () {
//     return view('my_laravel');
// });    
     
//Route::get('/view', [ViewController::class,'index']);//使用 web 可以 操作 session  

// Route::get('/view', [ViewController::class,'view']);
// Route::get('/article', [ViewController::class,'article']);
// Route::get('/layouts', [ViewController::class,'layouts']);

Route::any('admin/login', [LoginController::class,'login']);
Route::get('admin/code', [LoginController::class,'code']);  //生成 验证码


//Route::get('admin/getcode', [LoginController::class,'getCode']);  //获取 验证码
//Route::any('admin/crypt', [LoginController::class,'crypt']);
//////////Route::any('admin/index', [IndexController::class,'index']);// 登陆成功
//////////Route::any('admin/info', [IndexController::class,'info']);// 登陆成功右侧 iframe模块


//admin/login 和 admin/info 使用 中间件 过滤   开始
Route::get('admin/index', [IndexController::class,'index'])->middleware([AdminLogin::class,'web']);
Route::get('admin/info', [IndexController::class,'info'])->middleware([AdminLogin::class,'web']);
Route::any('admin/changepassword', [IndexController::class,'changepassword'])->middleware([AdminLogin::class,'web']);//get post

Route::get('admin/quit', [LoginController::class,'quit'])->middleware([AdminLogin::class,'web']);


//admin/login 和 admin/info 使用 中间件 过滤   结束

























// Route::get('/fz', function () {
//     echo 'get方法';
// });

// Route::post('/fz', function () {
//     echo 'post方法,需要在 VerifyCsrfToken.php 增加 网址';
// });


// Route::put('/fz', function () {
//     echo 'put方法';
// });



// Route::delete('/fz', function () {
//     echo 'delete 方法';
// });



// Route::patch('/fz', function () {
//     echo 'patch 方法';
// });



// Route::options('/fz', function () {
//     echo 'options 方法';
// });


// //匹配[] 里的这几个方法，任何 一个方法都会 执行 该函数
// Route::match(['get', 'post'], '/test', function () {//如果 路径是'/test' ，使用 post或者get 都会 返回 'This is a request from get or post'
//     return 'This is a request from get or post';
// });


// Route::any('bar', function () {//如果 路径是'/bar' ，使用 post或者get或任何 一个请求， 都会 返回 'This is a request from any HTTP verb'
//     return 'This is a request from any HTTP verb';
// });

// // //传递 参数
// // Route::get('user/{id}', function ($id) {
// //     return 'User ' . $id;
// // });

// //传递  2个 参数
// Route::get('posts/{post}/comments/{comment}', function ($postId, $commentId) {
//     return $postId . '-' . $commentId;
// });

// //正则约束 id 必须 是 数字
// Route::get('user/{id}', function ($id) {
//     // $id 必须是数字
//     return 'User ' . $id;
// })->where('id', '[0-9]+');

// Route::get(
//     '/',
//     [IndexController::class, 'index']
// );
//资源 路由
Route::prefix('admin')->group(function () {                    // 分组后    **区分 大小写
    Route::resource('category', CategoryController::class)->middleware([AdminLogin::class,'web']);//  增加 中间件
    Route::post('cate/changeorder', [CategoryController::class,'changeOrder'])->middleware([AdminLogin::class,'web']);//admin/cate/changeorder
});