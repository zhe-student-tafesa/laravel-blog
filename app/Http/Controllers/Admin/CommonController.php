<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;


use App\Models\User;
use Illuminate\View\View;
use Symfony\Component\Console\Input\Input;

class CommonController extends Controller
{
    //图片 上传
    public function upload(Request $request){
        //echo '图片上传888999';
        //dd($request) ;
        //dd(Input::all());
        dd($request->post()) ;
    }
}

?>