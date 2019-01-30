<!DOCTYPE html>
<html>
<head>
    <title>index</title>
</head>
<body>
    <div>{{$msg}} 使用{ {$msg} }输出</div>
    <div>{{$msg1}} 使用{ {$msg1} }输出</div>
    <div>{!!$msg1!!} 使用{ ! ! $msg1 ! ! }输出</div>
</body>
<script type="text/javascript">
    var msg = "{{$msg}}";
    var msg1 = "{{$msg1}}";
    console.log(msg);
    console.log(msg1)
</script>
</html>