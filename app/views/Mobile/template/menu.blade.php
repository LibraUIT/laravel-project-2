<div data-role="collapsible" data-collapsed="true">
    <h4>Các chủ đề</h4>
    <ul data-role="listview">
        @foreach($menus as $menu)
		<li><a href="{{URL::route('categorie_question_get', array($menu->id, Unicode::make($menu->title).'.html'))}}">{{$menu->title}}</a></li>
		@endforeach
    </ul>
</div>



