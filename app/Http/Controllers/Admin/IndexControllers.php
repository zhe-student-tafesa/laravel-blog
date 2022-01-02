<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********
session_start();
use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;


class IndexControllers extends Controller
{
    public function index(){
        return view('welcome');//返回 欢迎 界面
    } 
    public function login(){
        //session(['admin'=>1]);
        $_SESSION['admin'] = 1111111;
        echo '<h1>登录</h1>';
    } 
}

?>