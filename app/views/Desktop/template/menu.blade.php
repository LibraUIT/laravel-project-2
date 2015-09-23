<ul>
			<li class="menu menu-label"> Các chủ đề</li>
			@foreach($menus as $menu)
			<li class="menu"><a href="{{URL::route('categorie_question_get', array($menu->id, Unicode::make($menu->title).'.html'))}}"><span style="color:#337ab7" class="glyphicon glyphicon-play" aria-hidden="true"></span>
 {{$menu->title}}</a></li>
			@endforeach
</ul>
<div class="tag-cloud">
<h4>Từ khoá phổ biến</h4>
<div id="whatever">
  @foreach($tagcloud as $tc)
  	<a href="{{URL::route("question_tags_get",array($tc->alias))}}" rel="{{$tc->id}}">{{$tc->tag}}</a>
  @endforeach
</div>
</div>
@section("data_code")
	<style type="text/css">
	
	</style>
@stop


