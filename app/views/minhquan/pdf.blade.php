@extends("master")
@section('content')
<h1>{{$title}}</h1>
<table style="width:98%" class="table table-bordered table-hover" id="cate_list">
	<tr >
		<td>Tên tài liệu</td>
		<td>Ngày tạo</td>
		<td>Ngày cập nhật sau cùng</td>
		<td>Người tạo</td>
		<td>Xoá</td>
	</tr>
	@foreach($pdfs as $pdf)
	<tr id="pdf_{{$pdf->id}}">
		<td><a href="{{URL::route('get_view_pdf', array($pdf->id))}}">{{$pdf->name}}</a></td>
		<td>{{$pdf->created_at}}</td>
		<td>{{$pdf->updated_at}}</td>
		<td>{{$pdf->users->username}}</dt>
		<td><a href="javascritp:void(0)" onclick="deletePdf({{$pdf->id}})">Xoá</a></td>
	</tr>
	@endforeach
</table>
@stop
@section("data_code")
<style type="text/css">
	.main-content
	{
		width: 100% !important;
	}
</style>
<script type="text/javascript">
function deletePdf(id)
		{
			if(confirm("Bạn có chắc chắn muốn xoá tài liệu này không ?"))
			{
				$.get("{{URL::to('pdf/delete')}}/"+id, function(data){
					if(typeof data == "object"){
							alert(data.mess);
						}else{
							alert("Xoá tài liệu thành công");
							$("tr#pdf_"+id).remove();
						}
				});
			}
		}
$(function () {
$(document).ready(function () {
	$(".main-menu").hide();
});
});
</script>
@stop