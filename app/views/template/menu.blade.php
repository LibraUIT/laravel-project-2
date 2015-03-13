<h3>Các chủ đề</h3>
<ul>
			
			@foreach($menus as $menu)
			<li class="menu"><a href="{{URL::route('categorie_question_get', array($menu->id, Unicode::make($menu->title).'.html'))}}">{{$menu->title}}</a></li>
			@endforeach
</ul>
<div class="tag-cloud">
<b><span style="color:#337ab7" class="glyphicon glyphicon-tags" aria-hidden="true"></span> Tag cloud</b>
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


