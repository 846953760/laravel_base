<!DOCTYPE html>
<html>
<head>
    <title>index</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/index.css')}}">
    <script src="{{ asset('js/jquery-1.8.0.js') }}"></script>
</head>
<body>
    <div>{{$msg}} 使用@{{$msg}}输出</div>
    <div>{{$msg1}} 使用@{{$msg1}}输出</div>
    <div>{!!$msg1!!} 使用@{!!$msg1!!}输出</div>
    <span>account:</span><input type="text" name="account" class="account">
    <button class="get_account">获取account</button>
</body>
<script type="text/javascript">
    var msg = "{{$msg}}";
    var msg1 = "{{$msg1}}";
    console.log(msg);
    console.log(msg1);
    $('.get_account').click(function(){
    	alert($('.account').val());
    });
</script>
</html>

<!-- <!DOCTYPE html>
<html>
<head>
	<title>应用名 - @yield('title')</title>
</head>
<body>
	@section('sidebar')
		这是侧边栏
	@show

	<div class="container">
		@yield('content')
	</div>
</body>
</html> -->