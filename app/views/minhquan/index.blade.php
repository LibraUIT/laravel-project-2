@extends("master")
@section("content")
<div class="form-inline search">
  <div class="form-group">
      <select class="form-control select-cate">
      		<option value="0">Chọn chủ đề hoặc để trống</option>
      	@foreach($menus as $menu)
      		<option value="{{$menu->id}}">{{$menu->title}}</option>
      	@endforeach
      </select>
    </div>
  <div class="form-group">
    <label class="sr-only" for="exampleInputAmount">Nhập từ khoá, câu hỏi cần tìm kiếm</label>
    <div class="input-group">
      <div class="input-group-addon"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></div>
      <input type="text" class="form-control text-search"  placeholder="Nhập từ khoá, câu hỏi cần tìm kiếm">
    </div>
  </div>
  <button class="btn btn-primary btn-search-submit">Tìm kiếm</button>
</div>
<h1>{{$title}}</h1>
@if(isset($userid))
<a class="profile_link" href="{{URL::route('profile_get', array($userid))}}">Xem trang cá nhân</a>
@endif
@foreach($questions as $question)
			<div class="qwrap questions">
				@if(Sentry::check())
				<div class="arrowbox ">
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
				 foreach ($question->answers as $answer) {
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
					<div class="cntcount">{{count($question->answers)}}</div>
					<div class="cnttext">Trả lời</div>
				</div>
				<div class="qtext">
					<div class="qhead">
						<a href="{{URL::route('question_detail_get', array($question->id, Unicode::make($question->title). ".html"))}}">{{$question->title}}</a>
					</div>
					<div class="qinfo">Gởi bởi <a href="{{URL::route("question_user_get",array($question->users->username))}}">{{$question->users->username}}</a> cách đây {{$question->timeAgo}}
						<ul class="qtagul">
							@foreach($question->tags as $tag)
							<li><a href="{{URL::route("question_tags_get",array($tag->alias))}}">{{$tag->tag}}</a></li>
							@endforeach
						</ul>
					</div>
				</div>
			</div>
			<div class="clear"></div>
			@endforeach
			{{$questions->links()}}
			<!-- ket thuc cau hoi -->
@stop
@section("data_code")
<script type="text/javascript">
$(".btn-search-submit").on("click", function(){
	var text = $(".text-search").val();
	var cate = $(".select-cate").val();
	var dem = 0;
	for(i = 0; i<text.length; i++)
	{
		if(text[i] != " ")
		{
			dem++;
		}
	}
	if(dem != 0)
	{
		var url = "{{URL::to('/')}}/search/question/"+cate+"/"+text;
		console.log(url);
		window.location.href=url;
	}else
	{
		$(".text-search").attr("placeholder", "Vui lòng nhập vào từ khoá, câu hỏi").addClass("search-danger").css({"border-color":"#F78181"});
		$(".text-search").parent('.input-group').find(".input-group-addon").css({"border-color":"#F78181"});
		$(".text-search").parent('.input-group').find(".glyphicon-search").attr("style", "color:#F78181");
	}
});	
$(document).ready(function(){
		$('.arrowbox a.like, .arrowbox a.dislike').on('click', function(event){
			event.preventDefault();
			$this = $(this);
			url = $this.attr('href');
			$.get(url, function(data){
				$this.parent(".arrowbox").next(".cntbox").find(".cntcount").text(data);
			});
	});
});
</script>
<style type="text/css">
	
    .search-danger::-webkit-input-placeholder { /* WebKit browsers */
    color:    #F78181;
	}
	.search-danger::-moz-placeholder { /* Mozilla Firefox 4 to 18 */
	   color:    #F78181;
	   opacity:  1;
	}
	.search-danger::-moz-placeholder { /* Mozilla Firefox 19+ */
	   color:    #F78181;
	   opacity:  1;
	}
	.search-danger::-ms-input-placeholder { /* Internet Explorer 10+ */
	   color:    #F78181;
	}  
</style>
@stop
