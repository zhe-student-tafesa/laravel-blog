<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <!-- 插入 title 描述 -->
    @yield ('info');
    <link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
    <link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
    <!-- 列表页专用 -->
    <link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
    <!-- 新闻页专用 -->
    <link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
    <!--[if lt IE 9]>
<script src="{{asset('resources/views/home/js/modernizr.js')}}"  ></script>
<![endif]-->
</head>

<body>
    <header>
        <div id="logo"><a href="{{url('/')}}"></a></div>
        <nav class="topnav" id="topnav">
            <!-- $v->nav_name 使用对象 变量 -->
            @foreach($navs as $k=>$v)
            <a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>@endforeach

        </nav>
    </header>

    @section('content');

    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($hotNewList8 as $k=>$v)
        <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach

    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hotArticle5 as $k=>$v)
        <li><a href="{{url('a/'.$v->art_id)}}" title="{{$v->art_title}}" target="_blank">"{{$v->art_title}}"</a></li>
        @endforeach

    </ul>
    @show

    <footer>
        <p>{!!Config::get('web.copyright')!!} {!!Config::get('web.web_count')!!}</p>
    </footer>

</body>

</html>