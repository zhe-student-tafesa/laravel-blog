<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********
//session_start();
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;  //  post  11111111111

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use Illuminate\Support\Facades\Crypt; // 引入 加密


class IndexController extends Controller
{
    public function index(){
        //echo '<h1>登录</h1>';
        return view('admin.index');//返回 欢迎 界面
    } 
    public function login(){
        //session(['admin'=>1]);
        $_SESSION['admin'] = 1111111;
        echo '<h1>登录</h1>';
    } 
    //info
    public function info(){
        return view('admin.info');
    }
    //changepassword
    public function changepassword(Request $request ){// 修改 密码//  post 提交 ，提交到 本身
        if( $request->isMethod('post') ){  //如果是post请求
            //var_dump($request->post());
            $input =$request->isMethod('post') ;
         

            //$validator= Validator::make($input,$rules);
            // $validatedData = $request->validate([//  如果验证失败，相应的响应会自动生成。如果验证通过，控制器将会继续往下执行。
                
            //     'password_o' => 'required',
            //     'password' => 'required',
            //     'password_c' => 'required'
            // ]);
            // echo '合法收入';
            $message=[
                'password_o.required'=>'老密码必须输入' ,     //数组
                'password.required'=>'新密码必须输入' ,
                'password.between'=>'新密码必须6-20位长' ,
                'password.confirmed'=>'新密码输入与密码确认输入不一致' ,
                'password_confirmation.required'=>'确认密码必须输入' 
            ];

            $validator = Validator::make($request->all(), [
                'password_o' => 'required',
                'password' => 'required|between:6,20|confirmed',
                'password_confirmation' => 'required'
            ],$message);
        
            if ($validator->fails()) {
                // return redirect('admin/changepassword')
                
                //echo 'wrong';
                //dd($validator->errors()->all());//  打印 错误 原因
                return back()->withErrors($validator); //  在 页面 打印 错误 原因

            }else{
                //echo 'right';
                //读取 数据库
                $users = DB::table('user')->where('user_id', 1)->first();
                //解密
                $DBPassword=Crypt::decrypt($users-> user_password)   ; 
                if($DBPassword== $request->post()["password_o"] ){//原 密码正确
                    $users->user_password=Crypt::encrypt($request->post()["password"]);//新密码加密
                    //$users->save();

                    DB::table('user')
                        ->updateOrInsert(
                        ['user_name' => 'admin'],
                         ['user_password' =>(Crypt::encrypt($request->post()["password"])) ]
                        );
                    return redirect('admin/info');
                }else{
                    return back()->with('errors','原密码错误 !');
                }

            }
          

        }else{                              //如果是get请求
            return view('admin.pass');   // pass.blade.php
        }
        
        
    } 
}

?>