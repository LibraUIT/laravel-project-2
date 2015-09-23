<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Noi dung email</title>
</head>
<body>
<h1>Xin chao {{$user}}</h1>
<p>Ban vua yeu cau gui lai mat khau cho chung toi.</p>
<p>Vui long click vao day <a href="{{URL::route('active_reset', array($user, $code))}}"></a>{{URL::route('active_reset', array($user, $code))}}</p>
</body>
</html>