@extends("master")
@section('content')
<h1>{{$title}} với party id là  : {{$id}}</h1>
<div class="chat">
	<div class="form-chat">
		<label>Nhập vào nội dung bạn muốn chat</label>
			<input placeholder="Nội dung chat" type="text" class='form-control message-text'>
		</div>
	<div class="chat-log">
	</div>
</div>	
@stop
@section("data_code")
{{HTML::script('public/js/modernizr-2.6.2.min.js')}}
{{HTML::script('public/js/brain-socket.min.js')}}
<script type="text/javascript">
	$(document).ready(function(){
			var fake_user_id = '{{Sentry::getUser()->username}}';
			var fake_user_avatar = '{{Sentry::getUser()->avatar}}';
			var curent_party_id = {{$id}};
			window.app = {};
			app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);
			//var fake_user_name = {{Sentry::getUser()->username}};
			//make sure to update the port number if your ws server is running on a different one.
			
		  	
			app.BrainSocket.Event.listen('generic.event',function(msg){
				if(curent_party_id == msg.client.data.party_id && msg.client.data.user_id == fake_user_id){
					$('.chat-log').append('<div class="alert alert-success"><img width="20" src="{{asset(Sentry::getUser()->avatar)}}" alt="avatar default"> {{Sentry::getUser()->username}}: '+msg.client.data.message+'</div>');
				}else if(curent_party_id == msg.client.data.party_id){
					console.log("you have message form party id : "+msg.client.data.party_id); 
					$('.chat-log').append('<div class="alert alert-info">'+msg.client.data.message+' : '+msg.client.data.user_id+' <img width="20" src="{{URL::to('/')}}/'+msg.client.data.user_avatar+'" alt="avatar default"></div>');
				}
			});
			$('.message-text').keypress(function(event) {
						if(event.keyCode == 13){
							app.BrainSocket.message('generic.event',
									{
										'message':$(this).val(),
										'user_id':fake_user_id,
										'user_avatar': fake_user_avatar,
										'party_id' : curent_party_id,
									}
							);
							$(this).val('');
						}
						return event.keyCode != 13; }
			);
			//
			
	});
</script>
@stop