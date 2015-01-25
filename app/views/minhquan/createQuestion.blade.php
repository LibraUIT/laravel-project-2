@extends("master")
@section("content")
<h1>{{$title}}</h1>
{{Form::open(array('route'=>'question_create_post','class' => 'form-horizontal'))}}
<div class="form-group">
{{Form::label('title', 'Tiêu đề câu hỏi', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::text('title', '', array('id'=>'title', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('categorie', 'Chủ đề', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::select('cate', $cate)}}
</div>
</div>
<div class="form-group">
{{Form::label('content', 'Nội dung', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::textarea('content', '', array('id'=>'content', 'class'=>'form-control'))}}
</div>
</div>
<div class="form-group">
{{Form::label('tag', 'Tag', array('class' => 'col-sm-2 control-label'))}}
<div class="col-sm-5">
{{Form::text('tag', '', array('id'=>'title', 'class'=>'form-control'))}}
<p>Các được cách nhau bởi dấu ";" . Ví dụ : php ; html</p>
</div>
</div>
<div class="form-group">
<div class="col-sm-offset-2 col-sm-5">
{{Form::submit('Tạo câu hỏi', array('id'=>'submit', 'class'=> 'btn btn-primary btn-lg'))}}
</div></div>
{{Form::close()}}
@stop