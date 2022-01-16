<?php

namespace App\Http\Controllers\Home;  // namespace 代表 当前文件 在 哪个 目录下*********
//session_start();
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;  //  post  11111111111

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use Illuminate\Support\Facades\Crypt; // 引入 加密
use App\Http\Controllers\Admin\NavsController;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View as FacadesView;

class IndexHomeController extends Controller
{
    public function __construct(){
        //echo 5698;
        $navs=Navs::all();
        FacadesView::share('navs',$navs);// 把 $navs 变成 全局变量，各个 页面 都 可以 访问 此变量 

    }
    public function index(){
        //echo '<h1>home 登录</h1>';
        //$navs=Navs::all();
        //dd($navs);
        return view('home.index');//返回 home 文件夹的index.blade.php 视图  ,compact('navs')
    } 

    //    路由 /category ，调用  list.blade.php
    public function category(){  
        //session(['admin'=>1]);
        //$_SESSION['admin'] = 1111111;
        return view('home.list');//返回 home 文件夹的list.blade.php 视图
    } 
 
    public function article(){
        return view('home.news');
    }  
      
 
}

?>