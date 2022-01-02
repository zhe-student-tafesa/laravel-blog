<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 
use App\Http\Controllers\Admin\CommonController;

use App\Models\User;
use Code;
use Illuminate\View\View;
use Symfony\Component\Console\Input\Input;
//use Symfony\Component\Console\Input\Input;
use Illuminate\Http\Request;

use function Ramsey\Uuid\v6;

//引入 验证码
require_once('resources/org/code/Code.class.php');

class LoginController extends CommonController
{
    public function index(){
        return 'Admin/article的 index';//返回 欢迎 界面
    } 
    
    public function login(Request $request ){
        //echo '<h1>19登录</h1>';
        if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
            //var_dump($request->post()) ;  //已经获得了所有 数据
            $code= new Code;
            $newCode= $code->get();
            if($newCode!= strtoupper($request->post()["code"]) ){
                return back()->with('msg','验证码错误');
            }else{

            }

        }else{
            return view('admin.login');
        }
        
    } 
    public function code(){//生成验证码 ，且输出图片
        //echo '<h1>code </h1>';
        //return view('admin.login');
        $code= new Code;
        $code->make();
    } 
    public function getCode(){ //获得验证码 字符串
        //echo '<h1>code </h1>';
        //return view('admin.login');
        $code= new Code;
        echo $code->get();
    } 
}


?>