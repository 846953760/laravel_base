<!DOCTYPE html>
<html>
<head>
    <title>form</title>
</head>
<body>
    <form method="get" action="update/1">
        <input type="text" name="account">
        <input type="password" name="password">
        {{ csrf_field()}}
        <!-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> -->
        <input type="submit" value="提交">
    </form>
</body>
</html>