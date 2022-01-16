<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use App\Http\Model\Category;
use Illuminate\Support\Facades;///  Input
use App\Http\Model\Links;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class LinksController extends Controller
{
    //GET|HEAD                               | admin/links 
    public function index(){               //友情链接 列表
        
         $data= Links::orderBy('link_order','asc')->get();

        // $categorys = Category::all();
        //dd($data);
       
        //$categorys= (new Links())->tree();

        //dd($data);
        return view('admin.links.index',compact('data')) ;//  在admin新建 category文件夹，里面存放 index.blade.php
    } 




    //POST                                   | admin/links
    public function store(Request $request){ // 添加 友情链接 ，post来的数据写入 DB
        //echo '<h1>Arti登录</h1>';
        if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
           //dd($request->post()) ;  //已经获得了所有 数据
             
            /////////////////////////////////////////////////////////////开始
            $message=[
                'link_url.required'=>'必须输入URL' ,     //数组
                'link_name.required'=>'必须输入友情链接名称' 
               
            ];

            $validator = Validator::make($request->all(), 
                [
                'link_name' => 'required' ,
                'link_url' => 'required'
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
                $result=Links::create($input);// 写入数据库      public $guarded= [];// 没有需要保护的 
                if($result){//成功 写入数据库
                    return redirect('admin/links');
                }else{
                    return back()->with('errors','数据保存失败!请重试');
                }

            }
            /////////////////////////////////////////////////////////////结束

            //$cate= Category::find($order_id);
        }

    } 

    //GET|HEAD                               | admin/links/create 
    public function create(){//             添加links 友情链接
        //获取 父级 分类
        $data= Category::where('cate_pid',0)->get();
        return view('admin/links/add' ,compact('data')); // 使用add.blade.php页面 +返回 数据 
    } 









    //GET|HEAD                               | admin/links/{category}      | category.show    有参数
    public function show(){//           显示 单个分类 信息
        echo '<h1>Arti登录</h1>';
    } 




    // GET|HEAD                               | admin/links/{category}/edit | category.edit 
    public function edit($link_id){//               编辑/修改  友情链接
        
        //$data= Links::where('link_pid',0)->get();
        $field= Links::find($link_id);
        //dd($field);
        return view('admin.links.edit',compact('field'));//打开编辑页面，且把要修改的原始数据 传过来
    }  
    //PUT|PATCH                              | admin/links/{category}      | category.update    有参数
    public function update($link_id,Request $request){//         更新 分类
        
        $input=$request->post();
        //( $request->post())::except('_token');
        array_splice($input,0, 2);// 删除"_token"和   "_method"
        //dd( $input );
        $result= Links::where('link_id',$link_id)->update($input);
        //dd( $result);
        if($result){
            return redirect('admin/links');
        }else{
            return back()->with('errors','友情链接更新失败!请稍后重试');
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
                $link_id= $request->post()["link_id"];
                $link_order= $request->post()["link_order"];

                $links= Links::find($link_id);
                $links->link_order= $link_order;
                $result= $links->update();
                //echo $result;
                if($result){
                    $data=[
                        'status'=> 1, //1 代表 成功
                        'msg'=>'友情链接排序更新成功'
                    ];
                }else{
                    $data=[
                        'status'=> 0, //1 代表 成功
                        'msg'=>'友情链接排序更新失败，请稍后重试'
                    ];
                }
                return $data;
                
            }    
    }
    //DELETE                                 | admin/links/{category}      | category.destroy
    public function destroy($link_id){//            删除 单个 友情链接
            //echo '<h1>Arti登录</h1>';
            //echo $cate_id;
            $result= Links::where('link_id',$link_id)->delete();
             
            if($result){// 返回 json
                $data=[
                    'status'=> 1, //1 代表 成功
                    'msg'=>'友情链接删除成功'
                ];
            }else{
                $data=[
                    'status'=> 0, //1 代表 成功
                    'msg'=>'友情链接删除失败，请稍后重试'
                ];
            }
            return $data; // 返回 到 post/delete 的 回调函数里
    }       

}

?>