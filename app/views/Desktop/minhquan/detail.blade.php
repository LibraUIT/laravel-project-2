@extends("Desktop.master")
@section('content')
<h4 id="replyh">{{$title}}</h4>
@if(Session::has("success"))
<div class="alert alert-success answer-success">
<h4>{{Session::get('success')}}</h4>
<button class="btn btn-success close-success-answer">Đóng</button>
</div>
@endif
<div class="question-detail">
	<ul class="fastbar">
	<li><span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{$question->viewed}} lượt xem</li>
	<li><span class="glyphicon glyphicon glyphicon-comment" aria-hidden="true"></span> {{count($answers)}} trả lời</li>
	@if(Sentry::check())
		<li class="answer"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> trả lời</a></li>
		@if(Sentry::getUser()->hasAccess("admin"))
		<li class="trash"><a href="{{URL::route("question_delete_get",array($question->id))}}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> xoá</a></li>
		@endif
		
		</ul>
	@endif
</div>
<div class="question-info">
<div class="author-info">Gởi bởi <a href="{{URL::route("question_user_get",array($question->users->username))}}">{{$question->users->username}}</a> cách đây {{$question->timeAgo}}</div>
<div class="question-content">
<div class="question-content-1">
@if(Sentry::check())
	<div class="votebox">
		<a href="{{URL::route("question_vote_get",array("like",$question->id))}}" class="like"></a>
		<a href="{{URL::route("question_vote_get",array("dislike",$question->id))}}" class="dislike"></a>
	</div>
@endif
<div class="cntbox">
	<div class="cntcount">{{$question->votes}}</div>
	<div class="cnttext">Bình chọn</div>
</div>
<?php 
		$isOK = false;
		foreach ($answers as $answer) {
			if($answer->correct == "1")
			{
				 $isOK = true;
				 break;
			}
		}
		?>
		@if($isOK == true)
		<!--<div class="cntbox">-->
		@else
		<!--<div class="cntbox cntboxred">-->
		@endif
		<!--<div class="cntcount">{{count($answers)}}</div>
		<div class="cnttext">Trả lời</div>
	</div>-->
</div>
<div class="question-content-2"><p>{{$question->content}}</p></div>
<div class="tag-info-1">
	<h4>Từ khoá : </h4>
	<ul class="tag-info">
	@foreach($question->tags as $tag)
	<li><a href="{{URL::route("question_tags_get",array($tag->alias))}}">{{$tag->tag}}</a></li>
	@endforeach
	</ul>
	</div>
</div>	
</div>

<div class="question-reply">
				<h4>{{count($answers)}} Trả lời</h4>
				<div class="rrepol" id="replyarea" style="margin-bottom:10px">
					{{Form::open(array("route"=>array("question_reply_post",$question->id,Unicode::make($question->title).".html")))}}
						<div class="form-group">
						{{Form::textarea("answer",Input::old("answer"),array('id'=>'answer','class'=>'form-control'))}}
						</div>
						<div class="form-group">
						{{Form::submit("Gửi trả lời của bạn", array("class"=>"btn btn-primary"))}}
						</div>
					{{Form::close()}}
	</div>
</div>
<div class="question-reply-content">
	@foreach($answers as $answer)
					<div class="rrepol2 correct">
						@if(Sentry::check())
						<div class="arrowbox">
						<a href="{{URL::route("answer_vote_get",array("like",$answer->id))}}" class="like"></a>
						<a href="{{URL::route("answer_vote_get",array("dislike",$answer->id))}}" class="dislike"></a>
						</div>
								@if(Sentry::getUser()->hasAccess("admin"))
									<div class="close"><a href='{{URL::route("answer_delete_get",array($answer->id))}}'><span  class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></div>
								@endif
						@endif
						<div class="arrowbox-2 cntbox">

							<div class="cntcount">{{$answer->votes}}</div>
							<div class="cnttext">Bình chọn</div>
						</div>		
						@if($answer->correct == "1")		
							<div class="bestanswer"> <span style="color:#04B486"   class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Câu trả lời đúng nhất</div>
						@else
						<?php
							$admin = Sentry::findGroupByName('Administrator');
							$mod = Sentry::findGroupByName('Moderator');
						?>

							@if(Sentry::check())
								@if($question->userID == Sentry::getUser()->id || Sentry::getUser()->inGroup($mod) || Sentry::getUser()->inGroup($admin))
									<a class="chooseme" href="{{URL::route("answer_correct_get",array($answer->id))}}"><div style="color:red" class="choosebestanswer "><span style="color:red"   class="glyphicon glyphicon-question-sign" aria-hidden="true"></span>  Đúng</div></a>
								@endif
							@endif
						@endif
						<div class="reply-content">
							<div class="rbox2">
								<p>{{$answer->content}}</p>
							</div>
							<div class="rrepolinf">
								<p>Gởi bởi <a href="{{URL::route("question_user_get",array($answer->users->username))}}">{{$answer->users->username}}</a> cách đây {{$answer->timeAgo}} </p>
								
							</div>
						</div>
					</div>
					@endforeach	
		{{$answers->links()}}			
</div>
@stop

@section("data_code")
@if(Sentry::check())
<script type="text/javascript">
		
	$(document).ready(function(){
		var fake_user_id = '{{$question->users->username}}';
		var question_id = {{$question->id}};
		var title = "{{Unicode::make($question->title)}}";
		var user_from = '{{Sentry::getUser()->username}}';
		window.app = {};
		app.BrainSocket = new BrainSocket(
					new WebSocket('ws://localhost:8080'),
					new BrainSocketPubSub()
			);
		$(".close-success-answer").on("click", function(){
			$('.answer-success').fadeOut();
			app.BrainSocket.message('generic.event',
									{
										'user_id':fake_user_id,
										'question_id' : question_id,
										'title' : title,
										'user_from' : user_from,
									}
							);
		});
	})
</script>
@endif
{{HTML::script('public/CK/ckeditor.js')}}
<script type="text/javascript">
		
	$(document).ready(function(){
		CKEDITOR.on('dialogDefinition', function (ev) {
        // Take the dialog name and its definition from the event data.
        var dialogName = ev.data.name;
        var dialogDefinition = ev.data.definition;
        // Check if the definition is from the dialog we're
        // interested in (the 'image' dialog).
        if (dialogName == 'image') {
            // Get a reference to the 'Image Info' tab.
            var infoTab = dialogDefinition.getContents('info');
            // Remove unnecessary widgets/elements from the 'Image Info' tab.
            infoTab.remove('browse');
            infoTab.remove('txtHSpace');
            infoTab.remove('txtVSpace');
            infoTab.remove('txtBorder');
            infoTab.remove('txtAlt');
            infoTab.remove('txtWidth');
            infoTab.remove('txtHeight');
            infoTab.remove('htmlPreview');
            infoTab.remove('cmbAlign');
            infoTab.remove('ratioLock');
        }
    });
		CKEDITOR.replace( 'answer',
		{
		    uiColor: '#e4edf4'
		} );
		CKEDITOR.config.toolbar = [
		    ['-', 'NewPage', 'Preview', '-', 'Templates' ],
		    [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
		    [ 'Bold', 'Italic' ],
		    ['Link'],
		    ['Image']
		];
		$(".success").hide();
		
		$('.votebox a.like, .votebox a.dislike').on('click', function(event){
			event.preventDefault();
			$this = $(this);
			url = $this.attr('href');
			$.get(url, function(data){
				$this.parent(".votebox").next(".cntbox").find(".cntcount").text(data);
			});
		});
		$('.arrowbox a.like, .arrowbox a.dislike').on('click', function(event){
			event.preventDefault();
			$this = $(this);
			url = $this.attr('href');
			$.get(url, function(data){
				$this.parent(".arrowbox").parent(".rrepol2 ").find(".arrowbox-2").find(".cntcount").text(data);
			});
		});
		$('li.trash a').on('click', function(){
			return confirm("Bạn có chắc chắn muốn xoá câu hỏi này không ?");
		});
		$reply = $('#replyarea');
		//$reply.hide();
		$('li.answer a').on('click', function(e){
			e.preventDefault();
			if($reply.is(":hidden"))
			{
				$reply.fadeIn("fast");
			}else
			{
				$reply.fadeOut("fast");
			}
		});
		$('div.close a').on('click', function(){
			return confirm("Bạn có chắc chắn muốn xoá câu trả lời này không ?");
		});
	});
</script>

@stop