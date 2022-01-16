<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<link rel="stylesheet"   href={{asset("resources/views/admin/style/css/ch-ui.admin.css")}} >
	<link rel="stylesheet" href={{asset('resources/views/admin/style/font/css/font-awesome.min.css')}} >
	<script type="text/javascript"   src="{{asset('resources/views/admin/style/js/jquery.js')}}"    ></script>
    <script type="text/javascript" src="{{asset('resources/views/admin/style/js/ch-ui.admin.js')}}"      ></script>
	<!-- 弹窗 js 文件 -->
	<script type="text/javascript" src="{{asset('resources/org/layer/layer.js')}}"      ></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

</head>
<body>
  @yield('content');
</body>
</html>