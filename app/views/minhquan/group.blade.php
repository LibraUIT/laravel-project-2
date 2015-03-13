@extends("master")
@section('content')
<div class="groups">
<h1>Quản lý group</h1>
<p>
	<a href="javascript:void(0)" onclick="showForm('add_group')">Thêm group</a>
</p>
<table style="width:98%" class="table table-bordered table-hover" id="group_list">
	<tr >
		<td>Tên group</td>
		<td>Xoá</td>
	</tr>
	@foreach($groups as $group)
	<tr id="group_{{$group->id}}">
		<td>{{$group->name}}</td>
		<td><a href="javascritp:void(0)" onclick="deleteGroup({{$group->id}})">Xoá</a></td>
	</tr>
	@endforeach
</table>
{{Form::open(array("route"=>"post_create_group", "id"=>"add_group", "class"=>"form-horizontal", "style"=>"display:none"))}}
	<div class="form-group">
	{{Form::label('name', 'Tên group', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-10">
	{{Form::text('add_group_name', '', array('id'=>'add_group_name', 'class'=>'form-control'))}}
	</div>
	</div>
	<div class="form-group">
	{{Form::label('permissions', 'Permissions', array('class' => 'col-sm-2 control-label'))}}
	<div class="col-sm-10">
	{{Form::text('add_group_permissions', '', array('id'=>'add_group_permissions', 'class'=>'form-control'))}}
	</div>
	</div>
	<div class="form-group">
	<div class="col-sm-offset-2 col-sm-10">
	{{Form::submit("Thêm group", array('class'=> 'btn btn-primary btn-lg'))}}
	</div>
	</div>	
</div>
@stop
@section('data_code')
<script type="text/javascript">
	function showForm(idform)
		{
			$idForm = $("#"+idform);
			if($idForm.is(":hidden"))
			{
				$idForm.fadeIn("fast");
			}else
			{
				if(idform !="edit_group")
				{
					$idForm.fadeOut("fast");
				}
				
			}
		}
	function deleteGroup(id)
	{
		if(confirm("Bạn có chắc chắn muốn xoá group này không ?"))
			{
				$.get("{{URL::to('group/delete')}}/"+id, function(data){
					if(typeof data == "object"){
							alert(data.mess);
						}else{
							alert("Xoá group thành công");
							$("tr#group_"+id).remove();
						}
				});
			}
	}	
</script>
@stop