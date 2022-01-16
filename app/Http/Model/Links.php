<?php

namespace App\Http\Model;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Links  extends Authenticatable
{
     
    protected $table="links";
    protected $primaryKey="link_id";  //设置 主键 是user_id
    public $timestamps= false;
    public $guarded= [];// 没有需要保护的 



    public function tree(){
        //$categorys = Category::all();
        //$categorys = $this->all();  5/1/2022
        $categorys = $this->orderBy('cate_order','asc')->get(); 
        //dd($categorys);
        $field_name='cate_name';
        $field_id='cate_id';
        $field_pid= 'cate_pid';
        $pid= 0;
        return $this->getTree($categorys,$field_name,$field_id, $field_pid ,$pid);
    }
    
    /*****
    非常好用的函数
    $data原始数据
    $field_id： id  父类,  默认值为'id'
    $field_pid       子类的pid等于 父类的id  （默认值为'pid'）
    $pid=0 ：        父类的pid等于0   （默认值为0）
     */
    public function getTree($data,$field_name, $field_id='id', $field_pid='pid',$pid= 0){
        //echo '<h1>Arti登录</h1>';
        $arr= array(); //新数组 用来 存放要 返回的数组

        foreach( $data as $k => $v){
            if($v->$field_pid== $pid){
                //echo $v->cate_name;
                //$arr[]= $data[$k];
                //为了，显示 更好看，再增加一个字段_cate_name
                $data[$k]["_".$field_name]= $data[$k][$field_name];// 父分类等于 原来的
                array_push($arr, $data[$k]);
                foreach( $data as $kkk => $vvv){
                    if($vvv->$field_pid== $v->$field_id){//  父id等于  当前pid的id
                        //为了，显示 更好看，再增加一个字段_cate_name
                        $data[$kkk]["_".$field_name]= '--- '.$data[$kkk][$field_name];// 子分类等于 ---原来的
                        array_push($arr, $data[$kkk]);
                    }
                }
            }
        }
        //dd( $arr);
        return $arr;
    } 

 
}
