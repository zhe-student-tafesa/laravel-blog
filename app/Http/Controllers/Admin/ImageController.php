<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use App\Http\Model\Category;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ImageController extends Controller
{
    public function upload(){//           显示 文件 上传 页面
        echo  view('admin/article/upload');
    } 
    public function uploadFile(Request $request){//           显示 文件 上传成功  页面
         //$request->file->store('public');
         //$file = $request->file('file');
         if ($request->file('file')->isValid()) {
            //
            $FirstName= $request->post()["FirstName"];// 读取 post 上传的 数据
            $filename=date('YmdHis').mt_rand(100,999).'.'.$request->file->extension(); //获取 后缀 名

            $path = $request->file->storeAs( 'public', $filename);//保存 文件
            $filepathDB='storage/app/public/'.$filename;
            
   
           var_dump( $filepathDB); 
        }

        
         //echo $path;
        //return  back();
    } 


    //GET|HEAD                               | admin/article 
    public function index(){               //全部文章   列表
        //return 'Admin/article的 index';//返回 欢迎 界面
        echo 'GET|HEAD                               | admin/article ';
        //$categorys = DB::table('category');//  ->where('cate_id', 1)->first()

        // $categorys = Category::all();
        // //dd($categorys);
        // $field_name='cate_name';
        // $field_id='cate_id';
        // $field_pid= 'cate_pid';
        // $pid= 0;
        // $data =$this->getTree($categorys,$field_name,$field_id, $field_pid ,$pid);
        ///////////////////////$categorys= (new Category())->tree();

        //dd($data);
        ////////////////////////////return view('admin.category.index')->with('data',$categorys);//  在admin新建 category文件夹，里面存放 index.blade.php
    } 




    //POST                                   | admin/article
    public function store(Request $request){ // 添加 分类，post来的数据写入 DB
        //echo '<h1>Arti登录</h1>';
        if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
           //dd($request->post()) ;  //已经获得了所有 数据
            $cate_pid= $request->post()["cate_pid"];
            $cate_name= $request->post()["cate_name"];
            $cate_title= $request->post()["cate_title"];
            $cate_keywords= $request->post()["cate_keywords"];
            $cate_description= $request->post()["cate_description"];
            $cate_order= $request->post()["cate_order"];
            /////////////////////////////////////////////////////////////开始
            $message=[
                'cate_name.required'=>'必须输入分类名称' ,     //数组
               
            ];

            $validator = Validator::make($request->all(), [
                'cate_name' => 'required' 
            ],$message);
        
            if ($validator->fails()) {
                
                return back()->withErrors($validator); //  在 页面 打印 错误 原因   //返回 类型为 对象  在 html 输出时 应该使用 if

            }else{ // 成功
                $input=$request->post();
                //( $request->post())::except('_token');
                array_splice($input,0, 1);
                //dd($input) ;
                // 一句话  写入 很多（数组）字段 
                $result=Category::create($input);// 写入数据库      public $guarded= [];// 没有需要保护的 
                if($result){//成功 写入数据库
                    return redirect('admin/category');
                }else{
                    return back()->with('errors','数据保存失败!请重试');
                }

            }
            /////////////////////////////////////////////////////////////结束

            //$cate= Category::find($order_id);
        }

    } 

    //GET|HEAD                               | admin/article/create 
    public function create(){//             添加文章
        //获取 父级 分类
        //echo '<h1>添加文章</h1>';
        // $data= Category::where('cate_pid',0)->get();
        $data= (new Category())->tree();
         
        return view('admin/article/add',compact('data')); // 使用add.blade.php页面 +返回 数据   
    } 









    //GET|HEAD                               | admin/article/{category}      | category.show    有参数
    public function show(){//           显示 单个分类 信息
        echo '<h1>Arti登录</h1>';
    } 




    // GET|HEAD                               | admin/article/{category}/edit | category.edit 
    public function edit($cate_id){//               编辑/修改 分类
        //echo  $cate_id;
        $data= Category::where('cate_pid',0)->get();
        $field= Category::find($cate_id);
        //dd($field);
        return view('admin.category.edit',compact('field','data'));//打开编辑页面，且把要修改的原始数据 传过来
    }  
    //PUT|PATCH                              | admin/article/{category}      | category.update    有参数
    public function update($cate_id,Request $request){//         更新 分类
        //echo '<h1>Arti登录</h1>';
        //dd(Input::all());
        //dd( $request->post() );
        $input=$request->post();
        //( $request->post())::except('_token');
        array_splice($input,0, 2);// 删除"_token"和   "_method"
        //dd( $input );
        $result= Category::where('cate_id',$cate_id)->update($input);
        //dd( $result);
        if($result){
            return redirect('admin/category');
        }else{
            return back()->with('errors','数据更新失败!请稍后重试');
        }

    } 
    
    
    //changeOrder
    public function changeOrder(Request $request){
            //session(['admin'=>1]);
            //$_SESSION['admin'] = 1111111;
            //echo '<h1>修改顺序</h1>';
            if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
                //var_dump($request->post()) ;  //已经获得了所有 数据
                $order_id= $request->post()["order_id"];
                $cate_order= $request->post()["cate_order"];

                $cate= Category::find($order_id);
                $cate->cate_order= $cate_order;
                $result= $cate->update();
                //echo $result;
                if($result){
                    $data=[
                        'status'=> 1, //1 代表 成功
                        'msg'=>'分类排序更新成功'
                    ];
                }else{
                    $data=[
                        'status'=> 0, //1 代表 成功
                        'msg'=>'分类排序更新失败，请稍后重试'
                    ];
                }
                return $data;
                
            }    
    }
    //DELETE                                 | admin/article/{category}      | category.destroy
    public function destroy($cate_id){//            删除 单个 分类
            //echo '<h1>Arti登录</h1>';
            //echo $cate_id;
            $result= Category::where('cate_id',$cate_id)->delete();
            // 如果删除的是父类，则把他的子类 升级为 父类
            Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);

            if($result){// 返回 json
                $data=[
                    'status'=> 1, //1 代表 成功
                    'msg'=>'分类删除成功'
                ];
            }else{
                $data=[
                    'status'=> 0, //1 代表 成功
                    'msg'=>'分类删除失败，请稍后重试'
                ];
            }
            return $data; // 返回 到 post/delete 的 回调函数里
    }       

}

?>