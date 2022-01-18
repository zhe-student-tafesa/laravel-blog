<?php

namespace App\Http\Controllers\Home;  // namespace 代表 当前文件 在 哪个 目录下*********
//session_start();
use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;  //  post  11111111111

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;// 引入 DB 数据库
use Illuminate\Support\Facades\Crypt; // 引入 加密
use App\Http\Controllers\Admin\NavsController;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\View as FacadesView;
use App\Http\Model\Article;
use App\Http\Model\Links;
use App\Http\Model\Category;

class IndexHomeController extends Controller
{
    public function __construct(){
        //echo 5698;
        $navs=Navs::all();
        FacadesView::share('navs',$navs);// 把 $navs 变成 全局变量，各个 页面 都 可以 访问 此变量
        //最新发布文章8篇 右侧
        $hotNewList8= Article::orderBy('art_time','desc')->take(8)->get(); 
        FacadesView::share('hotNewList8',$hotNewList8);

        //点击量最高的5篇文章 右下部   
        $hotArticle5= Article::orderBy('art_view','desc')->take(5)->get();
        FacadesView::share('hotArticle5',$hotArticle5);

    }
    public function index(){
        //点击量最高的6篇文章 上部 图片  站长推荐
        $hotArticle= Article::orderBy('art_view','desc')->take(6)->get();
        
        
        //图文列表  带分页  左侧 大部分区域
        $hotList= Article::orderBy('art_time','desc')->paginate(5);//最新  到 最 早
        //dd($hotList);


        //友情链接
        $links= Links::orderBy('link_order','asc')->get();
        //网站配置项 标题...

        return view('home.index' ,compact('hotArticle', 'hotList', 'links'));//返回 home 文件夹的index.blade.php 视图  ,compact('navs')
    } 

    

 


    //    路由 /category ，调用  list.blade.php
    public function category($cate_id){  
        //session(['admin'=>1]);
        //$_SESSION['admin'] = 1111111;
        //view次数 自增
        Category::where('cate_id', $cate_id)->increment('cate_view',1) ;//想 一次加几，最后 一个 参数 写几
        //echo $cate_id;
        $field= Category::find($cate_id);
        //4篇文章 
        //读取当前分类的子 分类
        $submenu= Category::where("cate_pid",$cate_id)->get();  

         $hotArticle4= Article::where('cate_id',$cate_id)->orderBy('art_time','desc')->paginate(4);

        return view('home.list',compact('field','hotArticle4','submenu'));//返回 home 文件夹的list.blade.php 视图
    } 

    //  路由  ('/a/{art_id}'
    public function article($art_id){
        //echo $art_id;  在 页面 显示 id

        //view次数 自增
        Article::where('art_id', $art_id)->increment('art_view',1) ;//想 一次加几，最后 一个 参数 写几

        //联合 查询   使用 first 获得 一维数组          连接条件=                      筛选                    first变成一维数组/用get获得多维数组
        $field = Article::Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();  
        //dd($field);
        $article['prev']= Article::where('art_id','<',$art_id)->orderBy('art_id','desc')->first();//查询id小于这个的，然后排序，取第一个
        $article['next']= Article::where('art_id','>',$art_id)->orderBy('art_id','asc')->first();//查询id大于这个的，然后asc排序，取第一个

        //读取 相关的文章 即category id 相同的位置
        $data= Article::where('cate_id',$field->cate_id)->orderBy('art_id','desc')->take(6)->get();
        //dd($data);
        return view('home.news',compact('field','article','data'));
    }      
      
 
}

?>