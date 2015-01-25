@extends("master")
@section('content')
<h1 id="replyh">{{$title}}</h1>
			<!-- bat dau cau hoi -->
			<div class="qwrap questions">
				<div id="rcount"><span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{$question->viewed}} lượt xem</div>
				<div id="rreplycount"><span class="glyphicon glyphicon glyphicon-comment" aria-hidden="true"></span> {{count($answers)}} trả lời</div>
				@if(Sentry::check())
					<div class="qwrap">
						<ul class="fastbar">
							@if(Sentry::getUser()->hasAccess("admin"))
							<li class="trash"><a href="{{URL::route("question_delete_get",array($question->id))}}"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span> xoá</a></li>
							@endif
							<li class="answer"><a href="#"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span> trả lời</a></li>
						</ul>
					</div>
					@endif
				@if(Sentry::check())
				<div class="arrowbox">
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
				<div class="cntbox">
				@else
				<div class="cntbox cntboxred">
				@endif
					<div class="cntcount">{{count($answers)}}</div>
					<div class="cnttext">Trả lời</div>
				</div>
				
				<div class="rblock">
					<div class="rbox">
						<p>{{$question->content}}</p>
					</div>
					<div class="qinfo">Gởi bởi <a href="{{URL::route("question_user_get",array($question->users->username))}}">{{$question->users->username}}</a> - {{$question->timeAgo}}</div>
						<ul class="qtagul">
							@foreach($question->tags as $tag)
							<li><a href="{{URL::route("question_tags_get",array($tag->alias))}}">{{$tag->tag}}</a></li>
							@endforeach
						</ul>

				</div>
				
				<h4 style="color:#000">Trả lời</h4>
				<div class="rrepol" id="replyarea" style="margin-bottom:10px">
					<p> <b>Trả lời của bạn</b></p>
					{{Form::open(array("route"=>array("question_reply_post",$question->id,Unicode::make($question->title).".html")))}}
						<div class="form-group">
						{{Form::textarea("answer",Input::old("answer"),array('class'=>'form-control'))}}
						</div>
						<div class="form-group">
						{{Form::submit("Gửi trả lời", array("class"=>"btn btn-primary"))}}
						</div>
					{{Form::close()}}
				</div>
				<!-- noi dung cau tra loi -->
					@foreach($answers as $answer)
					<div class="rrepol2 correct">
						@if(Sentry::check())
									<div class="qwrap">
										<ul class="fastbar">
											@if(Sentry::getUser()->hasAccess("admin"))
												<li class="close"><a style="color:#000"  href='{{URL::route("answer_delete_get",array($answer->id))}}'><span style="color:#000"  class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></li>
											@endif
										</ul>
									</div>
								@endif
						@if(Sentry::check())
						<div class="arrowbox">
						<a href="{{URL::route("answer_vote_get",array("like",$answer->id))}}" class="like"></a>
						<a href="{{URL::route("answer_vote_get",array("dislike",$answer->id))}}" class="dislike"></a>
						</div>
						@endif
						<div class="cntbox">

							<div class="cntcount">{{$answer->votes}}</div>
							<div class="cnttext">Bình chọn</div>
						</div>		
						@if($answer->correct == "1")		
							<div class="bestanswer"> <span style="color:green"   class="glyphicon glyphicon-ok" aria-hidden="true"></span> Best Answer</div>
						@else
							@if(Sentry::check())
								@if($question->userID == Sentry::getUser()->id || Sentry::getUser()->hasAccess("admin"))
									<a class="chooseme" href="{{URL::route("answer_correct_get",array($answer->id))}}"><div style="color:red" class="choosebestanswer ">  Correct ?</div></a>
								@endif
							@endif
						@endif
						<div class="rblock2">
							<div class="rbox2">
								<p>{{$answer->content}}</p>
							</div>
							<div class="rrepolinf">
								<p>Gởi bởi <a href="{{URL::route("question_user_get",array($answer->users->username))}}">{{$answer->users->username}}</a> - {{$answer->timeAgo}} </p>
								
							</div>
						</div>
					</div>
					@endforeach
			</div>

@stop
@section("data_code")
<script type="text/javascript">
	
	$(document).ready(function(){
		$('.arrowbox a.like, .arrowbox a.dislike').on('click', function(event){
			event.preventDefault();
			$this = $(this);
			url = $this.attr('href');
			$.get(url, function(data){
				$this.parent(".arrowbox").next(".cntbox").find(".cntcount").text(data);
			});
		});
		$('li.trash a').on('click', function(){
			return confirm("Are you sure delete question ?");
		});
		$reply = $('#replyarea');
		$reply.hide();
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
		$('li.close a').on('click', function(){
			return confirm("Are you sure ?");
		});
	});
</script>
@stop
<style>
	
</style>