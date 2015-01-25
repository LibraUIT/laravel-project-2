@extends("master")
@section('content')
<h1>{{$title}}</h1>
<div class="avatar-profile">
	@if($users->avatar == '')
	<img src="{{asset('public/images/avatar_default.svg')}}" alt="avatar default">
	@else
	<img width="171" src="{{asset($users->avatar)}}" alt="avatar default">
	@endif

	@if(Sentry::check() && Sentry::getUser()->id == $users->id | Sentry::getUser()->hasAccess("admin"))
	<div class="edit-avatar"><a href="{{URL::route('profile_get_upload', array($users->id))}}"><span style="color:#FFF" class="glyphicon glyphicon-camera" aria-hidden="true"></span></a></div>
	@endif
</div>
<div class="status-user">
	
	@if($users->status == 0)
	<div id="status-off">
	<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> Đã offline
	@else
	<div id="status-on">
	<span style="color:#04B45F" class="glyphicon glyphicon-log-in" aria-hidden="true"></span> Đang online
	@endif
	</div>
</div>
<div class="clear"></div>
<div class="profile-info">
	<ul class="profile-info-label">
		<li>Tên truy cập :</li>
		<li>Họ tên :</li>
		<li>Email :</li>
		<li>Trạng thái :</li>
		<li>Lần đăng nhập cuối cùng :</li>
	</ul>
	<ul class="profile-info-detail">
		<li>{{$users->username}}</li>
		@if(Sentry::check() && Sentry::getUser()->id == $users->id | Sentry::getUser()->hasAccess("admin"))
		<li id="view_form">
			{{Form::open(array('route'=>'profile_post_name','class' => 'form-horizontal'))}}
			{{Form::hidden("username", $users->username)}}
			{{Form::hidden("id", $users->id)}}
			{{Form::text("name", "$users->last_name $users->first_name", array('class'=>'form-control username'))}}
			{{Form::submit("Xác nhận", array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg submit_name'))}}
			{{Form::button('Huỷ', array('id'=>'cancel', 'class'=> 'btn btn-danger btn-lg cancel_name') )}}
			{{Form::close()}}
		</li>
		<div class="clear"></div>
		<li id="view_name">{{$users->last_name." ".$users->first_name}} <a id="getform" style="margin-left:100px" href="javascript:void(0)" ><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> Sửa</a></li>
		@else
		<li id="view_name">{{$users->last_name." ".$users->first_name}} </li>
		@endif
		<li>{{$users->email}}</li>
		@if($users->activated == 1)
		<li>Đã kích hoạt</li>
		@else
		<li>Chưa kích hoạt</li>
		@endif
		<li>{{$users->last_login}}</li>
	</ul>
</div>
<div class="profile-activity">
<a href="{{URL::route('question_user_get', array($users->username))}}"><span style="color:#337ab7" class="glyphicon glyphicon-eye-open" aria-hidden="true"></span> Xem các câu hỏi của {{$users->username}}</a>	
</div>
@if(Sentry::check() && Sentry::getUser()->id != $users->id)
<div class="chat">
<h4>Chat với <b style="color:#04B45F">{{$users->username}}</b> ngay bây giờ</h4>
<button class="btn btn-success btn-lg btn-suggest-chat">Gửi yêu cầu chat</button>
</div>
@endif

@stop
@section("data_code")
<script type="text/javascript">
	$(document).ready(function(){
		$("#view_form").hide();
		$("#getform").on("click", function(e){
			e.preventDefault();
			$("#view_form").fadeIn("fast");
			$("#view_name").hide();
		});
		$("#cancel").on("click", function(){
			$("#view_form").hide();
			$("#view_name").fadeIn("fast");
		});
		//chat
			@if(Sentry::check())
			var party_id = null;
			var fake_user_id = '{{Sentry::getUser()->username}}';
			var fake_user_avatar = '{{Sentry::getUser()->avatar}}';
			var user_to = "{{$users->username}}";
			$(".btn-suggest-chat").on("click", function(){
				console.log("Gui yeu cau chat den {{$users->username}}");
				party_id = Math.floor((Math.random()*1000)+1);
				app.BrainSocket.message('generic.event',
									{
										'user_id':fake_user_id,
										'user_avatar': fake_user_avatar,
										'party_id' : party_id,
										'user_to' : user_to,
									}
							);
				//window.location.href="{{URL::to('/')}}/member/chat/"+party_id;
				window.open(
				  '{{URL::to("/")}}/member/chat/'+party_id,
				  '_blank' // <- This is what makes it open in a new window.
				);
			});
		//
		@endif

	});
</script>
@stop
