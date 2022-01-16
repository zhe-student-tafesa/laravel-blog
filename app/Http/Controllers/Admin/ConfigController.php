<?php

namespace App\Http\Controllers\Admin;  // namespace 代表 当前文件 在 哪个 目录下*********

use App\Http\Controllers\Controller; 

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use App\Http\Model\Category;
use Illuminate\Support\Facades;///  Input
use App\Http\Model\Config;
use Illuminate\Cache\Events\CacheHit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\Console\Input\Input;

class ConfigController extends Controller
{
    //GET|HEAD                               | admin/config 
    public function index(){               //配置项 列表
        //dd("配置项 列表");
        
         $data= Config::orderBy('conf_order','asc')->get();

        //在 页面 输出 前，进行一些 处理, 分别 按照input textarea radio 样式 显示
        foreach($data as $k=> $v){  //$v 是 $data的一个数据
            switch( $v->field_type){
                case 'input'://                                                      @                  @
                    $data[$k]->_html='<input type="text"  class="lg" name="conf_content[]"  value="'.$v->conf_content.'" >';
                    //echo $data[$k]->_html;
                    break;
                case 'textarea':
                    $data[$k]->_html='<textarea  class="lg" name="conf_content[]"> '.$v->conf_content.'  </textarea> ';
                    //echo $data[$k]->_html; 
                    break;
                case 'radio':
                    //echo $v->field_value;  //   1|开启, 0|关闭    以下代码实现 出现两个选项，并且按照 value 进行 选择
                    $arr= explode(',' ,  $v->field_value); // 把  1|开启, 0|关闭  按照 ， 进行 拆分
                    //dd( $arr);
                    $str='';// 用来 拼接 n个                        $data[$k]->_html=   checked 
                    
                    foreach($arr as $mm=> $nn){// 内 遍历
                        $arrSingle= explode('|' , $nn); // 把  1|开启 按照  | 进行 拆分      1   开启 and  0   关闭
                        //判断是否选中
                        $c='';
                        if($v->conf_content==$arrSingle[0]){
                            $c= ' checked ';
                        }
                        //echo ( $arrSingle);
                        $str= $str.'<input type="radio"'.$c.' name="conf_content[]"  value="'.$arrSingle[0].'" >'.$arrSingle[1].'　';
                    }
                    //echo (  $str);
                    $data[$k]->_html=$str;

                    break;                 
            }
        }

        return view('admin.config.index',compact('data')) ;//  在admin新建 category文件夹，里面存放 index.blade.php
    } 




    //POST                                   | admin/config
    public function store(Request $request){ // 添加 配置项 ，post来的数据写入 DB
        //echo '<h1>Arti登录</h1>';
        if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
           //dd($request->post()) ;  //已经获得了所有 数据
             
            /////////////////////////////////////////////////////////////开始
            $message=[
                'conf_title.required'=>'必须输入配置项标题' ,     //数组
                'conf_name.required'=>'必须输入配置项名称' 
               
            ];

            $validator = Validator::make($request->all(), 
                [
                'conf_name' => 'required' ,
                'conf_title' => 'required'
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
                $result=Config::create($input);// 写入数据库      public $guarded= [];// 没有需要保护的 
                if($result){//成功 写入数据库
                    return redirect('admin/config');
                }else{
                    return back()->with('errors','数据保存失败!请重试');
                }

            }
            /////////////////////////////////////////////////////////////结束

            //$cate= Category::find($order_id);
        }

    } 

    //GET|HEAD                               | admin/config/create 
    public function create(){//             添加config 配置项
        //获取 父级 分类
        $data= Category::where('cate_pid',0)->get();
        return view('admin/config/add' ,compact('data')); // 使用add.blade.php页面 +返回 数据 
    } 


    //changeContent
    //  admin/config/changecontent
    public function changeContent(Request $request){//             修改 config 配置项
        //echo '修改 config 配置项';
        if( $request->isMethod('post') ){//如果是 post 提交  Input::all()
            $input= ($request->post()) ;  //已经获得了所有 数据
            foreach($input['conf_id'] as $k=>$v ){
                       // 选中                更新
                Config::where('conf_id',$v)->update(['conf_content'=>$input['conf_content'][$k]]);
            }
        }
        $this->putFile();//  更新 config 的web.php
        return back()->with('errors','配置项更新成功');

        //$data= Category::where('cate_pid',0)->get();
        //return view('admin/config/add' ,compact('data')); // 使用add.blade.php页面 +返回 数据 
    }









    //GET|HEAD                               | admin/config/{category}      | category.show    有参数
    public function show(){//           显示 单个分类 信息
        echo '<h1>Arti登录</h1>';
    } 




    // GET|HEAD                               | admin/config/{category}/edit | category.edit 
    public function edit($conf_id){//               编辑/修改  配置项
        
        //$data= Config::where('conf_pid',0)->get();
        $field= Config::find($conf_id);
        //dd($field);
        return view('admin.config.edit',compact('field'));//打开编辑页面，且把要修改的原始数据 传过来
    }  
    //PUT|PATCH                              | admin/config/{category}      | category.update    有参数
    public function update($conf_id,Request $request){//         更新 分类
        
        $input=$request->post();
        //( $request->post())::except('_token');
        array_splice($input,0, 2);// 删除"_token"和   "_method"
        //dd( $input );
        $result= Config::where('conf_id',$conf_id)->update($input);
        //dd( $result);
        if($result){
            $this->putFile();//  更新 config 的web.php
            return redirect('admin/config');
        }else{
            return back()->with('errors','配置项更新失败!请稍后重试');
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
                $conf_id= $request->post()["conf_id"];
                $conf_order= $request->post()["conf_order"];

                $config= Config::find($conf_id);
                $config->conf_order= $conf_order;
                $result= $config->update();
                //echo $result;
                if($result){
                    $data=[
                        'status'=> 1, //1 代表 成功
                        'msg'=>'配置项排序更新成功'
                    ];
                }else{
                    $data=[
                        'status'=> 0, //1 代表 成功
                        'msg'=>'配置项排序更新失败，请稍后重试'
                    ];
                }
                return $data;
                
            }    
    }
    //DELETE                                 | admin/config/{category}      | category.destroy
    public function destroy($conf_id){//            删除 单个 配置项
            //echo '<h1>Arti登录</h1>';
            //echo $cate_id;
            $result= Config::where('conf_id',$conf_id)->delete();
             
            if($result){// 返回 json
                $this->putFile();//  更新 config 的web.php
                $data=[
                    'status'=> 1, //1 代表 成功
                    'msg'=>'配置项删除成功'
                ];
            }else{
                $data=[
                    'status'=> 0, //1 代表 成功
                    'msg'=>'配置项删除失败，请稍后重试'
                ];
            }
            return $data; // 返回 到 post/delete 的 回调函数里
    } 

    //把 配置项 从 数据库移到  config 文件夹1. 把数据从 数据库 拿出来  2. 数据整理后 写入 config 文件夹
    public function putFile(){//
        //echo \Illuminate\Support\Facades\Config::get('web.web_title'); 读取 web.php 文件 中的web_title键对应的值   // 22  成功 读取
        //$config= Config::all();
        $config= Config::pluck('conf_content','conf_name')->all();// 键值对
        //echo var_export($config, true); //数组 转成 字符串

        //dd($config );
        $path= base_path().'\config\web.php';
        //echo $path;
        $str='<?php return '.var_export($config, true).';';
        file_put_contents($path, $str); //111111111成功 写入

    }      

}

?>