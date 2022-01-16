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

    @yield('content');

    <footer>
        <p>Design by 陈华编程社区 <a href="http://www.miitbeian.gov.cn/" target="_blank">http://www.chenhua.club</a> <a href="/">网站统计</a></p>
    </footer>
    
</body>

</html>