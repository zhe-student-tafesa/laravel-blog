<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use App\Http\Model\Category;
use Illuminate\Support\Facades;///  Input
use App\Http\Model\Navs;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class NavsController extends Controller
{
    //GET|HEAD                               | admin/navs 
    public function index(){               //自定义导航 列表
        
         $data= Navs::orderBy('nav_order','asc')->get();

        // $categorys = Category::all();
        //dd($data);
       
        //$categorys= (new Navs())->tree();

        //dd($data);
        return view('admin.navs.index',compact('data')) ;//  在admin新建 category文件夹，里面存放 index.blade.php
    } 




    //POST                                   | admin/navs
    public function store(Request $request){ // 添加 自定义导航 ，post来的数据写入 DB
        //echo '<h1>Arti登录</h1>';
        if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
           //dd($request->post()) ;  //已经获得了所有 数据
             
            /////////////////////////////////////////////////////////////开始
            $message=[
                'nav_url.required'=>'必须输入URL' ,     //数组
                'nav_name.required'=>'必须输入自定义导航名称' 
               
            ];

            $validator = Validator::make($request->all(), 
                [
                'nav_name' => 'required' ,
                'nav_url' => 'required'
                ],
                $message);
        
            if ($validator->fails()) {
                
                return back()->withErrors($validator); //  在 页面 打印 错误 原因   //返回 类型为 对象  在 html 输出时 应该使用 if

            }else{ // 成功
                $input=$request->post();
                //( $request->post())::except('_token');
                array_splice($input,0, 1);
                //dd($input) ;
                // 一句话  写入 很多（数组）字段 
                $result=Navs::create($input);// 写入数据库      public $guarded= [];// 没有需要保护的 
                if($result){//成功 写入数据库
                    return redirect('admin/navs');
                }else{
                    return back()->with('errors','数据保存失败!请重试');
                }

            }
            /////////////////////////////////////////////////////////////结束

            //$cate= Category::find($order_id);
        }

    } 

    //GET|HEAD                               | admin/navs/create 
    public function create(){//             添加navs 自定义导航
        //获取 父级 分类
        $data= Category::where('cate_pid',0)->get();
        return view('admin/navs/add' ,compact('data')); // 使用add.blade.php页面 +返回 数据 
    } 









    //GET|HEAD                               | admin/navs/{category}      | category.show    有参数
    public function show(){//           显示 单个分类 信息
        echo '<h1>Arti登录</h1>';
    } 




    // GET|HEAD                               | admin/navs/{category}/edit | category.edit 
    public function edit($nav_id){//               编辑/修改  自定义导航
        
        //$data= Navs::where('nav_pid',0)->get();
        $field= Navs::find($nav_id);
        //dd($field);
        return view('admin.navs.edit',compact('field'));//打开编辑页面，且把要修改的原始数据 传过来
    }  
    //PUT|PATCH                              | admin/navs/{category}      | category.update    有参数
    public function update($nav_id,Request $request){//         更新 分类
        
        $input=$request->post();
        //( $request->post())::except('_token');
        array_splice($input,0, 2);// 删除"_token"和   "_method"
        //dd( $input );
        $result= Navs::where('nav_id',$nav_id)->update($input);
        //dd( $result);
        if($result){
            return redirect('admin/navs');
        }else{
            return back()->with('errors','自定义导航更新失败!请稍后重试');
        }

    } 
    
    
    //changeOrder
    public function changeOrder(Request $request){
            //session(['admin'=>1]);
            //$_SESSION['admin'] = 1111111;
            //echo '<h1>修改顺序</h1>';
            //dd(Input::all());

            if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
                //var_dump($request->post()) ;  //已经获得了所有 数据
                $nav_id= $request->post()["nav_id"];
                $nav_order= $request->post()["nav_order"];

                $navs= Navs::find($nav_id);
                $navs->nav_order= $nav_order;
                $result= $navs->update();
                //echo $result;
                if($result){
                    $data=[
                        'status'=> 1, //1 代表 成功
                        'msg'=>'自定义导航排序更新成功'
                    ];
                }else{
                    $data=[
                        'status'=> 0, //1 代表 成功
                        'msg'=>'自定义导航排序更新失败，请稍后重试'
                    ];
                }
                return $data;
                
            }    
    }
    //DELETE                                 | admin/navs/{category}      | category.destroy
    public function destroy($nav_id){//            删除 单个 自定义导航
            //echo '<h1>Arti登录</h1>';
            //echo $cate_id;
            $result= Navs::where('nav_id',$nav_id)->delete();
             
            if($result){// 返回 json
                $data=[
                    'status'=> 1, //1 代表 成功
                    'msg'=>'自定义导航删除成功'
                ];
            }else{
                $data=[
                    'status'=> 0, //1 代表 成功
                    'msg'=>'自定义导航删除失败，请稍后重试'
                ];
            }
            return $data; // 返回 到 post/delete 的 回调函数里
    }       

}

?>