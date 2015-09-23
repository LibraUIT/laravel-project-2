<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Noi dung email</title>
</head>
<body>
	<h1>Xin chào, {{$user}}</h1>
	Cám ơn bạn đã thực hiện yêu cầu xác nhận lấy lại mật khẩu, sau đây là mật khẩu mới của bạn.<br />
	Mật khẩu: <b>{{$pass}}</b>
	<br /><br />
	<a href="{{URL::route("index")}}" target="_blank">Nhấp chuột để trở về trang web</a>
	<br />
	Trân trọng.

</body>
</html>