@extends("Desktop.master")
@section('content')
<h1>{{$title}}</h1>
{{Form::open(array('route'=>'changepass_post','class' => 'form-horizontal'))}}
<div class="form-group">
{{Form::label('oldpassword', 'Mật khẩu cũ', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::password('oldpassword', array('id'=>'password', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('newpassword', 'Mật khẩu mới', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::password('newpassword', array('id'=>'password', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('renewpassword', 'Nhập lại mật khẩu mới', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::password('renewpassword', array('id'=>'re-password', 'class'=>'form-control'))}}
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
{{Form::submit('Đổi mật khẩu', array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg'))}}
</div></div>
{{Form::close()}}
@stop