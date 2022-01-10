@extends('layouts.admin')
@section('content')

<!--面包屑导航 开始-->
<div class="crumb_warp">
    <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
    <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章管理
</div>
<!--面包屑导航 结束-->

<!--结果集标题与导航组件 开始-->
<div class="result_wrap">
    <div class="result_title">
        <h3>添加文章</h3>
        @if( $errors)
        <div class="mark">
            @if( is_object($errors) )
                 @foreach($errors->all() as $error)
                     <p>{{$error}}</p>
                 @endforeach
            @else
                <p>{{$errors}}</p>
            @endif
        </div>
        @endif
    </div>
    <div class="result_content">
        <div class="short_wrap">
            <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>添加文章</a>
            <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>

        </div>
    </div>
</div>
<!--结果集标题与导航组件 结束-->

<div class="result_wrap">
    <form action="{{url('admin/article')}}" method="POST" enctype="multipart/form-data">
        {{csrf_field()}}
        <table class="add_tab">
            <tbody>
                <tr>
                    <th width="120"> 分类：</th>
                    <td>
                        <select name="cate_id">

                            <!-- _cate_name 字段 是我们后来 自己 加的 -->
                            @foreach($data as $d)
                            <option value="{{$d->cate_id}}">{{$d->_cate_name}}</option>
                            @endforeach

                        </select>
                    </td>
                </tr>



                <tr>
                    <th><i class="require">*</i>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title">

                    </td>
                </tr>

                <tr>
                    <th> 编辑</th>
                    <td>
                        <input type="text" class="sm" name="art_editor">

                    </td>
                </tr>

                <tr>
                    <th><i class="require">*</i>缩略图：</th>
                    <td>
                        <!-- <input type="text" size="50" name="art_thumb"> -->
                        <div class="form-group">
                                <label for="file"> Choose File</label>
                                <input type="file"  class="form-control" name="file" id="file"/>
                        </div>

                        

                    </td>
                </tr>

                <tr>
                    <th>关键词：</th>
                    <td>
                        <input type="text" class="lg" name="art_tag">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="art_description"></textarea>
                    </td>
                </tr>



                <tr>
                    <th><i class="require">*</i>文章内容</th>
                    <td>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.config.js')}}"></script>
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/ueditor.all.min.js')}}"> </script>
                        <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                        <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                        <script type="text/javascript" charset="utf-8" src="{{asset('resources/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
                        <script id="editor" name="art_content" type="text/plain" style="width:888px;height:500px;"></script>
                        <script type="text/javascript">
                            //实例化编辑器
                            //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
                            var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default {
                                line-height: 28px;
                            }

                            div.edui-combox-body,
                            div.edui-button-body,
                            div.edui-splitbutton-body {
                                overflow: hidden;
                                height: 20px;
                            }

                            div.edui-box {
                                overflow: hidden;
                                height: 22px;
                            }
                        </style>

                    </td>
                </tr>





                <tr>
                    <th></th>
                    <td>
                        <button type="submit" class="btn btn-success"> Upload</button>
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
            </tbody>
        </table>
    </form>
</div>
@endsection