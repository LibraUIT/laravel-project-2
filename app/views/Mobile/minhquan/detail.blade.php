@extends("Mobile.master")
@section('content')
<h4 id="replyh">{{$title}}</h4>
<div class="question-detail">
	<span class="glyphicon glyphicon glyphicon-eye-open" aria-hidden="true"></span> {{$question->viewed}} lượt xem
	<br />
	<span class="glyphicon glyphicon glyphicon-comment" aria-hidden="true"></span> {{count($answers)}} trả lời
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
<div class="question-content-2"><pre>{{$question->content}}</pre></div>
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
				<h4>Trả lời</h4>
				<div class="rrepol" id="replyarea" style="margin-bottom:10px">
					
	</div>
</div>
<div class="question-reply-content">
	@foreach($answers as $answer)
					<div class="rrepol2 correct">
						<div class="arrowbox-2 cntbox">

							<div class="cntcount">{{$answer->votes}} Bình chọn</div>
						</div>		
						@if($answer->correct == "1")		
							<div class="bestanswer"> <span style="color:#04B486"   class="glyphicon glyphicon-ok-sign" aria-hidden="true"></span> Câu trả lời đúng nhất</div>
						@endif
						<div class="reply-content">
							<div class="rbox2">
								<pre>{{$answer->content}}</pre>
							</div>
							<div class="rrepolinf">
								<p>Gởi bởi <a href="{{URL::route("question_user_get",array($answer->users->username))}}">{{$answer->users->username}}</a> cách đây {{$answer->timeAgo}} </p>
								
							</div>
						</div>
					</div>
					@endforeach	
</div>
@stop

