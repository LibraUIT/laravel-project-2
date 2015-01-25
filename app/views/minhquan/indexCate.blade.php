@extends("master")
@section("content")
<h1>{{$title}}</h1>
<p><a href="javascript:void(0)" onClick="showForm('add_cate')">Thêm chủ đề</a></p>
<table style="width:98%" class="table table-bordered table-hover" id="cate_list">
	<tr >
		<td>Tên chủ đề</td>
		<td>Chỉnh sửa</td>
		<td>Xoá</td>
	</tr>
	@foreach($cates as $cate)
	<tr id="cate_{{$cate->id}}">
		<td>{{$cate->title}}</td>
		<td><a href="javascritp:void(0)" onclick="editCate({{$cate->id}}, '{{$cate->title}}')">Chỉnh sửa</a></td>
		<td><a href="javascritp:void(0)" onclick="deleteCate({{$cate->id}})">Xoá</a></td>
	</tr>
	@endforeach
</table>
	{{Form::open(array("route"=>"categorie_create_post", "id"=>"add_cate", "class"=>"form-horizontal", "style"=>"display:none"))}}
	<div class="form-group">
	{{Form::label('title', 'Tên chủ đề', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-10">
	{{Form::text('add_cate_title', '', array('id'=>'add_cate_title', 'class'=>'form-control'))}}
	</div>
	</div>
	<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	{{Form::submit("Thêm chủ đề", array('class'=> 'btn btn-primary btn-lg'))}}
	</div>
	</div>
	{{Form::close()}}
	<p></p>
	{{Form::open(array("route"=>"categorie_update_post", "id"=>"edit_cate", "class"=>"form-horizontal", "style"=>"display:none"))}}
	<div class="form-group">
	{{Form::label('title', 'Tên chủ đề', array('class' => 'col-sm-2 control-label'))}}
	{{Form::hidden("cate_id", "", array("id"=>"cate_id"))}}
	<div class="col-sm-10">
	{{Form::text('edit_cate_title', '', array('id'=>'edit_cate_title', 'class'=>'form-control'))}}
	</div>
	</div>
	<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	{{Form::submit("Sửa chủ đề", array('class'=> 'btn btn-primary btn-lg'))}}
	</div>
	</div>
	<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	{{Form::button("Huỷ", array( 'onClick'=>'hideForm("edit_cate")','class'=> 'btn btn-danger btn-lg'))}}
	</div>
	</div>
	{{Form::close()}}
@stop
@section("data_code")
	<script type="text/javascript">
		function showForm(idform)
		{
			$idForm = $("#"+idform);
			if($idForm.is(":hidden"))
			{
				$idForm.fadeIn("fast");
			}else
			{
				if(idform !="edit_cate")
				{
					$idForm.fadeOut("fast");
				}
				
			}
		}
		function clearForm()
		{
			$("inpiut[type=text], input[type=hidden]").val('');
			$('form').hide();
		}
		function hideForm(idform)
		{
			$("#"+idform).hide();
			return false;
		}
		function editCate(id, title)
		{
			$('#edit_cate_title').val(title);
			$('#cate_id').val(id);
			showForm('edit_cate');
		}
		function deleteCate(id)
		{
			if(confirm("Bạn có chắc chắn muốn xoá chủ đề này không ?"))
			{
				$.get("{{URL::to('categorie/delete')}}/"+id, function(data){
					if(typeof data == "object"){
							alert(data.mess);
						}else{
							alert("Xoá chủ đề thành công");
							$("tr#cate_"+id).remove();
						}
				});
			}
		}
		$(document).ready(function(){
			$("#add_cate").submit(function(e){
			e.preventDefault();
			$name=$("#add_cate_title").val();
			$url=$("#add_cate").attr("action");
			if($name == "")
			{
				alert("Bạn cần nhập tên cho chủ đề");
			}else
			{
				$.ajax({
					"url": $url,
					"type":"post",
					"data":{"name":$name},
					"async":true,
					"success":function(data){
						if(typeof data == "object"){
							alert(data.mess);
						}else{
							alert("Thêm chủ đề thành công");
							$("#cate_list").append(data);
							clearForm();
						}
					}
				})
			}
		});
		$("#edit_cate").submit(function(e){
			e.preventDefault();
			$cateid = $("#cate_id").val();
			$name = $("#edit_cate_title").val();
			if($name == '')
			{
				alert("Bạn cần nhập vào tên của chủ đề");
			}else
			{
				$.ajax({
					"url" : "{{URL::route('categorie_update_post')}}",
					"type" : "post",
					"data" : {"name":$name, "id":$cateid},
					"async" : true,
					"success" : function(data)
					{
						if(typeof data == "object"){
							alert(data.mess);
						}else{
							alert("Sửa chủ đề thành công");
							clearForm();
							$("tr#cate_"+$cateid).html(data);
							
						}
					}
				})
			}
		});	
	})
	</script>
@stop