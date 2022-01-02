<?php

namespace App\Http\Controllers;  // namespace 代表 当前文件 在 哪个 目录下*********

use Illuminate\Support\Facades\DB;// 引入 DB 数据库
session_start();
use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;


class IndexController extends Controller
{
    public function index(){
        //return view('welcome');//返回 欢迎 界面

        // echo '<h1>登录数据库</h1>';
        //$pdo= DB::connection('read')->getPDO();
        $users=DB::table('user')->where('user_id','>',5)->get();
        dd($users);
        // $users = DB::select('select * from users where active = ?', [1]);

        // return view('user.index', ['users' => $users]);
    } 
    public function login(){
        //session(['admin'=>1]);
        $_SESSION['admin'] = 1111111;
        echo '<h1>登录</h1>';
    } 
}

?>