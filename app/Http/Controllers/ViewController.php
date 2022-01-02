<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller; 

use Illuminate\Http\Request;

class ViewController extends Controller
{
    //
    public function index(){
        //session(['admin'=>1]);
        //$_SESSION['admin'] = 1111111;
        //echo '<h1>视图 </h1>';
        
        
        // $name= 'Frank';
        // $age= 19;
        // return view('my_laravel', ['name' =>  $name,'age' =>  $age]  );

        $data= ['name'=>'Frank',
                'age'=>18,
                'article'=>[
                    'news1',
                    'news2',
                    'news3',
                    'news4',
                    'news5'
                ]
        ];
        $title= 'learn Laravel';
        $address='53 Gray';
        $str='<script>alert("您好");</script>';
        return view('my_laravel', compact('data','title','address','str') );
    } 
        public function view(){
            //echo '<h1>视图 </h1>';
            //return view('index');
            echo config('app.debug');  //因为 APP_DEBUG=true， 所以 输出1

        }
        //article
        public function article(){
            //echo '<h1>视图 </h1>';
            return view('article');

        }
        //layouts
        public function layouts(){
            //echo '<h1>视图 </h1>';
            return view('layouts');

        }
}
