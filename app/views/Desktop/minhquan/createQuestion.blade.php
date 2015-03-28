@extends("Desktop.master")
@section("content")
<h1>{{$title}}</h1>
{{Form::open(array('route'=>'question_create_post','style'=>'margin-left:15px','class' => 'form-horizontal'))}}
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
<div class="col-sm-9">
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
{{HTML::script('public/js/jquery-1.9.1.min.js')}}
{{HTML::script('public/CK/ckeditor.js')}}
<script>
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
		CKEDITOR.replace( 'content',
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
	});
</script>
