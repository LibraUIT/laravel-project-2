@extends("Mobile.master")
@section("content")
<h3>{{$title}}</h3>
<div class="sort-question" data-role="navbar" data-grid="c">
    <ul id="sort-question">   
		<li class="tab-link" style="width:22%"><a href="{{Request::url();}}?tab=active">Mới</a></li>
		<li class="tab-link"><a href="{{Request::url();}}?tab=hot">Nổi bật</a></li>
		<li class="tab-link"><a href="{{Request::url();}}?tab=week">Tuần</a></li>
		<li class="tab-link"><a href="{{Request::url();}}?tab=month">Tháng</a></li>
    </ul>
</div><!-- /navbar -->
<table class="table table-condensed">
     <thead>
       <tr>
         <th>Tiêu đề</th>
         <th data-priority="3">Thời gian</th>
         <th data-priority="1"><abbr title="Bình chọn">Bình chọn</abbr></th>
         <th data-priority="5">Lượt xem</th>
       </tr>
     </thead>
     <tbody>
       @foreach($questions as $question)
			<tr>
		         <td><a href="{{URL::route('question_detail_get', array($question->id, Unicode::make($question->title). ".html"))}}">{{$question->title}}</a></td>
		         <td>{{$question->timeAgo}}</td>
		         <td>{{$question->votes}}</td>
		         <td>{{$question->viewed}}</td>
		    </tr>	
	   @endforeach
     </tbody>
   </table>
{{$questions->links()}}
<!-- ket thuc cau hoi -->
@stop
@section("data_code")
<style type="text/css">
</style>
@stop