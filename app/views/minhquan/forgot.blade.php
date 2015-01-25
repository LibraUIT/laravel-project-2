@extends("master")
@section('content')
<h1>{{$title}}</h1>
{{Form::open(array('route'=>'forgot_post','class' => 'form-horizontal'))}}
<div class="form-group">
{{Form::label('username', 'Tên truy cập ', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::text('username', '', array('id'=>'txtuser', 'class'=>'form-control'))}}
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
{{Form::submit('Xác nhận', array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg'))}}
</div></div>
{{Form::close()}}
@stop