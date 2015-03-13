<!DOCTYPE html>
<html ng-app="myApp">
<head>
	<title>{{ $title}}</title>
	<meta charset="utf-8">
	
	{{HTML::style('public/css/bootstrap.css')}}
	{{HTML::style('public/css/bootstrap-responsive.css')}}
	{{HTML::style('public/css/style.css')}}
	{{HTML::style('public/css/jquery.Jcrop.css')}}
	{{HTML::style('public/css/jquery.Jcrop.min.css')}}
	{{HTML::style('public/css/daterangepicker-bs2.css')}}
</head>
<body>
@include("template.header")
<div class="container">
	<div class="pull-left main-content">
		@yield("content")
	</div>
	<div class="pull-left main-menu">
		@include("template.menu")
	</div>
</div>
<div class="bottom">
	Copy &copy; 2014 - Quan Nguyen
</div>
	{{HTML::script('public/js/jquery-1.9.1.min.js')}}
	{{HTML::script('public/js/bootstrap.js')}}
	{{HTML::script('public/js/jquery.Jcrop.js')}}

	{{HTML::script('public/js/modernizr-2.6.2.min.js')}}
	{{HTML::script('public/js/brain-socket.min.js')}}

	{{HTML::script('public/js/moment.js')}}
	{{HTML::script('public/js/daterangepicker.js')}}

	{{HTML::script('public/js/highcharts.js')}}
	{{HTML::script('public/js/modules/exporting.js')}}

	{{HTML::script('public/js/jquery.tagcloud.js')}}

	{{HTML::script('public/js/bootstrap-select.js')}}
	@yield("data_code")
</body>
<script type="text/javascript">
$(document).ready(function(){
	//Tag cloud
			$.fn.tagcloud.defaults = {
			  size: {start: 14, end: 18, unit: 'pt'},
			  color: {start: '#cde', end: '#f52'}
			};

			$(function () {
			  $('#whatever a').tagcloud();
			});
});
</script>
@if(Sentry::check())
<script type="text/javascript">
	$(document).ready(function(){
			window.app = {};
			app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);
			var party_id = null;
			var fake_user_id = '{{Sentry::getUser()->username}}';
			var fake_user_avatar = '{{Sentry::getUser()->avatar}}';

			app.BrainSocket.Event.listen('app.success',function(data){
				console.log('An app success message was sent from the ws server!');
				console.log(data);
			});

			app.BrainSocket.Event.listen('app.error',function(data){
				console.log('An app error message was sent from the ws server!');
				console.log(data);
			});

			app.BrainSocket.Event.listen('generic.event',function(msg){
				if(msg.client.data.user_to == fake_user_id)
				{
					console.log(msg.client.data.user_id +" vua gui yeu cau chat voi party_id:" +msg.client.data.party_id);
					$('.no-alert').hide();
					$(".dropdown-menu-alert").append('<li role="presentation"><a class="acceptParty" data-id="'+msg.client.data.party_id+'" role="menuitem" tabindex="-1" href="{{URL::to('/')}}/member/chat/'+msg.client.data.party_id+'" target="_blank">'+msg.client.data.user_id +' yêu cầu chat với bạn</a></li>');
					$(".dropdown-alert-bell").addClass('dropdown-alert-bell-has-alert');
				}
				if(msg.client.data.party_id == party_id && msg.client.data.accept == "yes" )
				{
					$('.no-alert').hide();
					$(".dropdown-menu-alert").append('<li role="presentation"><a class="acceptParty" data-id="'+msg.client.data.party_id+'" role="menuitem" tabindex="-1" href="{{URL::to('/')}}/member/chat/'+msg.client.data.party_id+'" target="_blank">'+msg.client.data.user_id +' đã đồng ý chat với bạn</a></li>');
					$(".dropdown-alert-bell").addClass('dropdown-alert-bell-has-alert');	
				}
				if(msg.client.data.user_id == fake_user_id && msg.client.data.title && msg.client.data.question_id)
				{
					$('.no-alert').hide();
					$(".dropdown-menu-alert").append('<li role="presentation"><a class="acceptParty" role="menuitem" tabindex="-1" href="{{URL::to('/')}}/question/detail/'+msg.client.data.question_id+'/'+msg.client.data.title+'.html" target="_blank">'+msg.client.data.user_from+' đã trả lời câu hỏi của bạn</a></li>');
					$(".dropdown-alert-bell").addClass('dropdown-alert-bell-has-alert');	
				}
				console.log(msg);

			});
			$(".bnt-drop-alert").on("click", function(){
				$(".dropdown-alert-bell").removeClass('dropdown-alert-bell-has-alert');
			});
			
		});

</script>
@endif
</html>