<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use App\Http\Model\Category;
//Article
use App\Http\Model\Article;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ArticleController extends Controller
{
    //GET|HEAD                               | admin/article 
    public function index(){               //全部文章   列表
        $data= Article::orderBy('art_id','desc')->paginate(6);  //倒着排，即最新的在上边 
        ($data->links());// 分页
        return view('admin/article/index',compact('data')); //index .blade.php
        //echo 'GET|HEAD                               | admin/article ';
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
           $input = $request->post();
           array_splice($input,0, 1);//把第一个  数据删除

            //dd($input) ;  //已经获得了所有 数据, 马上写入数据库
             
            //dd($result) ;


            //$cate_order= $request->post()["cate_order"];
            /////////////////////////////////////////////////////////////开始
            $message=[
                'art_title.required'=>'必须输入文章标题' ,     //数组
                'art_content.required'=>'必须输入文章内容'
            ];

            $validator = Validator::make($request->all(), [
                'art_title' => 'required' ,
                'art_content' => 'required'
            ],$message);
        
            if ($validator->fails()) {
                
                return back()->withErrors($validator); //  在 页面 打印 错误 原因   //返回 类型为 对象  在 html 输出时 应该使用 if

            }else{ // 成功
                if ($request->file('file')->isValid()) {
           
                    $filename=date('YmdHis').mt_rand(100,999).'.'.$request->file->extension(); //获取 后缀 名
    
                    $path = $request->file->storeAs( 'public', $filename);//保存 文件
                    $filepathDB='storage/app/public/'.$filename;
                }
                //不能 删除  
                //array_splice($input,3, 1);//把第4个  数据删除
                //添加$filepathDB     $arrayname[indexname] = $value;  
                $input['art_thumb']=$filepathDB;
                //压入 时间戳
                $input['art_time']= time();

                $result=Article::create($input);// 写入数据库      public $guarded= [];// 没有需要保护的
                 
                if($result){//成功 写入数据库
                    return redirect('admin/article');
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
    
        $data= (new Category())->tree();
         
        return view('admin/article/add',compact('data')); // 使用add.blade.php页面 +返回 数据   
    } 









    //GET|HEAD                               | admin/article/{category}      | category.show    有参数
    public function show(){//           显示 单个分类 信息
        echo '<h1>Arti登录</h1>';
    } 




    // GET|HEAD                               | admin/article/{article}/edit | category.edit 
    public function edit($art_id){//               编辑/修改 文章
         
        $data= (new Category())->tree();//  类别
        
        $field= Article::find($art_id);
        //dd($field);
        return view('admin.article.edit',compact('field','data'));//打开编辑页面，且把要修改的原始数据 传过来
    }  




    //PUT|PATCH                              | admin/article/{category}      | category.update    有参数
    public function update($art_id,Request $request){//         更新 文章
        //echo '<h1>Arti登录</h1>';
        //dd(Input::all());
        //dd( $request->post() );
        $input=$request->post();

        //( $request->post())::except('_token');
        array_splice($input,0, 2);// 删除"_token"和   "_method"
        //dd( $input );
        $result= Article::where('art_id',$art_id)->update($input);
        //dd( $result);
        if($result){
            return redirect('admin/article');
        }else{
            return back()->with('errors','文章更新失败!请稍后重试');
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
    public function destroy($art_id){//            删除 单个 文章  
            //echo '<h1>Arti登录</h1>';
            //echo $cate_id;
            $result= Article::where('art_id',$art_id)->delete();
            // 如果删除的是父类，则把他的子类 升级为 父类
            //Article::where('cate_pid',$art_id)->update(['cate_pid'=>0]);

            if($result){// 返回 json
                $data=[
                    'status'=> 1, //1 代表 成功
                    'msg'=>'文章删除成功'
                ];
            }else{
                $data=[
                    'status'=> 0, //1 代表 成功
                    'msg'=>'文章删除失败，请稍后重试'
                ];
            }
            return $data; // 返回 到 post/delete 的 回调函数里
    }       

}

?>