@extends("Desktop.master")
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

<div id="index-line">
	<ul id="tab-line">
		<li><a href="{{Request::url()}}?tab=active">Mới nhất</a></li>
		<li><a href="{{Request::url();}}?tab=hot">Nổi bật</a></li>
		<li><a href="{{Request::url();}}?tab=week">Tuần</a></li>
		<li><a href="{{Request::url();}}?tab=month">Tháng</a></li>
	</ul>
</div>

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
	var task = "active";
	var currentPageUrl = "";
    if (typeof this.href === "undefined") {
        currentPageUrl = document.location.toString().toLowerCase();
    }
    else {
        currentPageUrl = this.href.toString().toLowerCase();
    }
    var params = currentPageUrl.split('?');
    getparam = params[1];
    if(getparam != undefined)
    {
	    getparam = getparam.split('=');
	    if(getparam[0] == 'tab')
	    {
	    	task = getparam[1];
	    }else{
	    	task = getparam[2];
	    }
	}
    if(task == undefined)
	{
		task = "active";
	}
    switch(task)
    {
    	case "active":
    		cssCurentTab(1);
    		break;
    	case "hot":
    		cssCurentTab(2);
    		break;
    	case "week":
    		cssCurentTab(3);
    		break;
    	case "month":
    		cssCurentTab(4);
    		break;		
    	default:
    		cssCurentTab(1);
    		break;
    }
 function cssCurentTab($num)
 {
 			$("#tab-line li:nth-child("+$num+")").css({"border-left" : "1px solid #CCC",	
			"border-right" : "1px solid #CCC",
			"border-top" : "3px solid #333",
			"border-bottom" : "1px solid #FFF"});
			$("#tab-line li:nth-child("+$num+")").find('a').css({"color" : "#333"});
 }

$('.pagination li').each(function(){
	url = $(this).find('a').attr('href');
	newurl = url+'&tab='+task;
	$(this).find('a').removeAttr('href');
	$(this).find('a').attr('href', newurl);
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
	#index-line{
		width: 98%;
		margin-left: 1%;
		height: 40px;
		border-bottom:  1px solid #CCC;
		margin-bottom: 10px;
	}
	#tab-line li
	{
		width: 80px;
		/*border-left: 1px solid #CCC;
		border-right: 1px solid #CCC;			
		border-top: 3px solid #333;*/
		text-align: center;
		height:40px;
		padding-top: 10px;
		float: left;
	}
	#tab-line li a
	{
		color: #999;
	}
	#tab-line li a:hover
	{
		text-decoration: none;
	}
	#tab-line li:hover
	{
		border-left: 1px solid #CCC;
		border-right: 1px solid #CCC;			
		border-top: 3px solid #333;
		border-bottom: 1px solid #FFF;
	}
</style>
@stop
