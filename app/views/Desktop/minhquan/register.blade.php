@extends("Desktop.master")
@section('content')
<h1>{{$title}}</h1>
{{Form::open(array('route'=>'register_post','class' => 'form-horizontal'))}}
<div class="form-group">
{{Form::label('lastname', 'Họ', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::text('last_name', '', array('id'=>'last_name', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('firstname', 'Tên', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::text('first_name', '', array('id'=>'first_name', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('username', 'Tên truy cập', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::text('username', '', array('id'=>'txtuser', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('email', 'Địa chỉ email', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::email('email', '', array('id'=>'email', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('password', 'Mật khẩu', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::password('password', array('id'=>'password', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('repassword', 'Xác nhận mật khẩu', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::password('repassword', array('id'=>'re-password', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('recaptcha', 'Mã xác nhận', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::captcha()}}
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-5">
{{Form::submit('Đăng kí', array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg'))}}
</div></div>
{{Form::close()}}
@stop