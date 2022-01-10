<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;


class ArticleController extends Controller
{
    public function index(){
        return 'Admin/article的 index';//返回 欢迎 界面
    } 
    public function login(){
        echo '<h1>Arti登录</h1>';
    } 
}

?>