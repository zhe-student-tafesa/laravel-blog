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
use Illuminate\Support\Facades\Crypt;

use function Ramsey\Uuid\v6;

//引入 验证码
require_once('resources/org/code/Code.class.php');

//
use Illuminate\Support\Facades\DB;// 引入 DB 数据库

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
            }
            $inputName=$request->post()["user_name"];
            $inputPassEn=  $request->post()["user_password"] ;
            
            // //20220118开始
            // dd(encrypt($inputPassEn));  //);encrypt($inputPassEn);
            // //j结束



            $users = DB::table('user')->where('user_id', 1)->first();
            $DBName=$users-> user_name;
            $DBPassword=Crypt::decrypt($users-> user_password)   ; //必须 使用 解密  ，然后再比较    不能把用户输入进行加密
            // echo '<br/>';
            // echo $DBName;
            // echo '<br/>';
            // echo $DBPassword;

            if( $inputName!=$DBName ||  $inputPassEn!= $DBPassword){
                
                return back()->with('msg','用户名或者密码错误');

            }
            session(['user'=>$inputName]);
            //dd(session('user'));
             //echo '登陆成功';
             return redirect('admin/index'); // 登陆成功 成功 跳转 到 后台 首页
            

        }else{//不是post
            //  $users=DB::table('user')->where('user_id',1)->get();	
            //  //dd($users);
            //  var_dump($users);
            //  echo '<br/>';
            //  echo	$users[0];
            // $user = DB::table('user')->where('user_id', 1)->first();
            // echo $user->user_name;
            //dd($_SERVER);
            //session(['user'=>null]);
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
    // public function crypt(){// 
    //     //echo '<h1>code </h1>';
    //     //return view('admin.login');
    //      $str='123456';
    //      echo Crypt::encrypt($str);
    //      $str_p='eyJpdiI6IjV6N2thdmN3RVFxaTZidEQxNTdFbVE9PSIsInZhbHVlIjoiQlZ0VVNwMWtXNHRPOHlRQTFnZkJwZz09IiwibWFjIjoiYjJhZjBiNTg0M2RjZWVhMGE5ZjNlM2YyMjNmYTQ1ZWZjN2FjMzEzYmRiYjQ4YzljYjliMjJlZjM5YWYyMTViOSIsInRhZyI6IiJ9';
    //      echo '<br/>';
    //      echo Crypt::decrypt($str_p);
    //  } 
    public function quit(){//生成验证码 ，且输出图片
        //echo '<h1>code </h1>';
        //return view('admin.login');
        session(['user'=>null]);
        return redirect('admin/login');
    } 

}


?>