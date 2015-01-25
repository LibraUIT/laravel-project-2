@extends("master")
@section('content')
<h1>{{$title}}</h1>
<div class="upload-profile">
<h6>Ảnh đại diện hiện tại</h6>
<div class="avatar-profile">
	@if($users->avatar == '')
	<img src="{{asset('public/images/avatar_default.svg')}}" alt="avatar default">
	@else
	<img width="171" src="{{asset($users->avatar)}}" alt="avatar default">
	@endif
</div>
</div>
@if(Session::get('image'))
<h4 style="margin-left:10px">Chọn vùng để cắt ảnh</h4>
<div class="review-image">
	
	<img width="342" id="image-crop" src="{{asset(Session::get('url'))}}" alt="avatar default">
	
</div>
	{{Form::open(array('route'=>'profile_crop_upload','class' => 'form-horizontal'))}}
	{{Form::hidden('x', '', array('id'=>'x'))}}
	{{Form::hidden('y', '', array('id'=>'y'))}}
	{{Form::hidden('w', '', array('id'=>'w'))}}
	{{Form::hidden('h', '', array('id'=>'h'))}}
	{{Form::hidden('id', Session::get('userid'))}}
	{{Form::hidden('username', Session::get('username'))}}
	{{Form::hidden('image', Session::get('image'))}}
	{{Form::submit('Chọn', array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg crop_submit'))}}
	
	{{Form::close()}}
	<button  class ='btn btn-danger btn-lg cancel_crop'>Huỷ</button>
@else
<div class="form-upload">
	{{Form::open(array('route'=>'profile_post_upload','class' => 'form-horizontal', 'files'=>true))}}
	{{Form::hidden('id', $users->id)}}
	{{Form::hidden('username', $users->username)}}
	{{Form::label('image', 'Ảnh mới')}}
	{{Form::file('img', array('class'=>'img'))}}
	{{Form::submit('Tải lên', array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg submit_name'))}}
	{{Form::close()}}
</div>
@endif

@stop
@section("data_code")
<script type="text/javascript">
$(document).ready(function(){
	$("#image-crop").Jcrop({
		onSelect : updateImg,

	})
	$(".cancel_crop").on("click", function(){
		window.location.href = "{{URL::to('remove/session/img/1')}}";
	});
})
function updateImg(e)
{
	$('#x').val(e.x);
	$('#y').val(e.y);
	$('#w').val(e.w);
	$('#h').val(e.h);
}
</script>
@stop	