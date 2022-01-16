@extends('layouts.adminarticle')
@section('content')


<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
</div>
<!--面包屑导航 结束-->

<!--结果页快捷搜索框 开始-->
<div class="search_wrap">


</div>
<!--结果页快捷搜索框 结束-->

<!--搜索结果页面 列表 开始-->
<form action="#" method="post">
    <div class="result_wrap">
        <!--快捷导航 开始-->
        <div class="result_title">
            <h3>文章列表</h3>
        </div>

        <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
            <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>

        </div>
        </div>
        <!--快捷导航 结束-->
    </div>

    <div class="result_wrap">
        <div class="result_content">
            <table class="list_tab">
                <tr>
                   
                    <th class="tc">ID</th>
                    <th>标题</th>
                    <th>点击</th>
                    <th>编辑</th>
                    <th>发布时间</th>
                    <th>操作</th>
                </tr>

                @foreach($data as $v)
                <tr>
                   
                    <td class="tc">{{$v->art_id}}</td>
                    <td>
                        <a href="#">{{$v->art_title}}</a>
                    </td>
                    <td>{{$v->art_view}}</td>
                    <td>{{$v->art_editor}}</td>
                    <td>{{date('Y-m-d',$v->art_time)}}</td>
                     <td>
                        <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">修改</a>
                        <a href="javascript:;" onclick="deleteArticle({{$v->art_id}})">删除</a>
                    </td>
                </tr>
                @endforeach




            </table>


 

            <!-- 分页 显示 -->

            <div class="page_list" id = 'pagessss'>
                {{$data->links()}}  
            </div>
        </div>
    </div>
</form>
<style>
   #pagessss{
       width: 100%;
       height: 200px;
       overflow: hidden;

   }
</style>    
<!--搜索结果页面 列表 结束-->


<script>
        function changeOrder(obj, order_id){
            var cate_order=$(obj).val();
             
            $.post("{{url('admin/cate/changeorder')}}",
                    {'_token':'{{csrf_token()}}', 'order_id' : order_id, 'cate_order':cate_order },
                    function(data){
                        //console.log(data);
                        if(data.status==1){
                            layer.msg(data.msg,{icon: 6});
                        }else{
                            layer.msg(data.msg,{icon: 5});
                        }
                    });
        }
        //删除
        function deleteArticle(art_id){
            layer.confirm('确定要删除id='+art_id+' 的文章吗？',{
                btn:['确定','取消']
            },function(){                      //确定时
                //alert( art_id);
                //layer.msg('zy',{icon:1});

                //使用  delete 删除（AJAX）  路径，参数，回调函数
                $.post("{{url('admin/article')}}"+"/"+art_id,
                        {'_method':'delete','_token':"{{csrf_token()}}"},
                        function(data){  //回调函数
                            //console.log(data);
                            if(data.status==1){
                                //刷新当前页面
                                location.href= location.href;
                                layer.msg(data.msg,{icon: 6});
                            }else{
                                layer.msg(data.msg,{icon: 5});
                            }
                        }
                );
            },function(){                      //取消时
                // layer.msg('yang',{
                //     time:20000,//20秒后 自动关闭    
                //     btn:['','']
                // });
            }
            );
        }
       
    </script>
@endsection