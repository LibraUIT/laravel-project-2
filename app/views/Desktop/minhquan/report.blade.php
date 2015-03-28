<?php
	$dateFrom = date("M d , Y", strtotime('-15 day'));
	$dateTo = date("M d , Y");
	$select ='';
	foreach ($menus as $key => $value) {
		$select .="<option value=\"".$value->id."\">".$value->title."</option>";
	}
	if(isset($docs))
	{
		$Doctitle = $docs->title;
	}else
	{
		$Doctitle = "Unidentified Document";
	}
?>
@extends("Desktop.master")
@section('content')
<h1>{{$title}}</h1>
<div class="report-tree">
	<div class="box">
        <div class="box-one"><h2>THÊM</h2></div>
        <ul class="tree-chart">
        	<li id="add-chart-1">Câu hỏi theo chủ đề </li>
        	<li id="add-chart-2">Câu hỏi theo ngày </li>
        	<li id="add-chart-3">Câu trả lời theo chủ đề</li>
        	<li id="add-chart-4">Câu trả lời theo ngày</li>
        	<li id="add-chart-5">Câu hỏi & trả lời theo chủ đề </li>
        	<li id="add-chart-6">So sánh </li>
        	<li id="add-chart-7">Thống kê đăng nhập người dùng  </li>
        </ul>
    </div>
</div>	
<div class="report-document">
	<div id="title-report">
		<h4><input value="@if(isset($docTitle)){{$docTitle}}@endif" id="title-report-input" type="text" placeholder="Vui lòng nhập vào tiêu đề của báo cáo ( nhấn enter để hoàn tất )" /><b style="font-weight:normal">@if(isset($docTitle)){{$docTitle}}@else Unidentified Document @endif</b><a id="show-input-report-title" href="javascript:void(0)"><span style="font-size:13px;margin-left:20px;" class="glyphicon glyphicon-edit" aria-hidden="true"></span></a></h4>
	</div>
	<div class="packery">
		
	</div> 
</div>
<div class="export-save-chart">
<span data-toggle="modal" data-target="#myModal" class="glyphicon glyphicon-floppy-saved saved" aria-hidden="true"></span>
<span data-toggle="modal" data-target="#myModal" class="glyphicon glyphicon-download-alt pdfed" aria-hidden="true"></span>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Đặt tên cho tài liệu</h4>
      </div>
      <div class="modal-body">
		      <input value="@if(isset($docName)){{$docName}}@endif" type="text" class="form-control name-of-document" placeholder="Nhập vào tên của tài liệu">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
        <button  @if(isset($docTitle)) data-id="{{$docId}}" @endif type="button" class="btn btn-primary btn-apply">Xác nhận</button>
      </div>
    </div>
  </div>
</div>
@stop

@section("data_code")
{{HTML::style('public/css/report.css')}}
{{HTML::script('public/js/packery.pkgd.js')}}
{{HTML::script('public/js/draggabilly.pkgd.js')}}
{{HTML::script('public/js/report.js')}}
<script type="text/javascript">
  var chartItem = '<div class="item w1 h1">'+
  				'<div class="chart-view" id="show-chart"></div>'+
		  		'<div class="option-chart">'+
		  		'<div id="reportrange" class="pull-right reportrange" style="cursor: pointer; padding: 5px 10px; position: absolute; left:15px">'+
			    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>'+
			    '<span id="show"><?php echo $dateFrom; ?> - <?php echo $dateTo; ?> </span><b class="caret"></b>'+
			    '</div>'+
			    '<div class="remove-edit-chart">'+
			    '<span class="glyphicon glyphicon-ok-circle apply" aria-hidden="true"></span>'+
			    '<span class="glyphicon glyphicon-cog edit" aria-hidden="true"></span>'+
			    '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>'+
			    '</div>'+
				'</div>'+
		  		'</div>';

  var chartItemVs = '<div class="item w1 h1">'+
  					'<div class="chart-view" id="show-chart"></div>'+
					'<div class="option-chart">'+
						'<div id="reportrange" class="pull-right reportrange" style="cursor: pointer; padding: 5px 10px; position: absolute; left:15px">'+
						    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>'+
						    '<span id="show"><?php echo $dateFrom; ?> - <?php echo $dateTo; ?> </span><b class="caret"></b>'+
						'</div>'+
						'<div id="select-cate">'+
						'<select  class="select-1">'+
					      '{{$select}}'+
					  	'</select>'+
					  	'<select  class="select-2">'+
					      '{{$select}}'+
					  	'</select>'+
					  	'</div>'+
					  	'<div class="remove-edit-chart">'+
					    '<span class="glyphicon glyphicon-ok-circle apply" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-cog edit" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>'+
					    '</div>'+
					'</div>'+
				'</div>';
var urlDrawChartQuestionByCate = "{{URL::route('draw_chart_question_by_cate')}}";
var urlDrawChartQuestionByDate = "{{URL::route('draw_chart_question_by_date')}}";
var urlDrawChartAnswerByCate = "{{URL::route('draw_chart_answer_by_cate')}}";
var urlDrawChartAnswerByDate = "{{URL::route('draw_chart_ans_by_date')}}";
var urlDrawChartQuestionAndAns = "{{URL::route('draw_chart_ques_ans')}}";
var urlDrawChartQuestionAndAnsVs = "{{URL::route('get_vs_ques_and_ans')}}";
var urlDrawChartLastLoginByDate = "{{URL::route('draw_chart_user_last_login_by_date')}}";
var urlCreatePdf = "{{URL::to('pdf/create')}}";
var urlInsertPdf = "{{URL::to('pdf/insert')}}";
var urlUpdatePdf = "{{URL::to('pdf/update')}}";

@if(isset($docName))
var sqlChart = {{$docData}};
for(s = 0; s < sqlChart.length; s++)
{
	chart_type = sqlChart[s].type;
	get_date_from = sqlChart[s].dateFrom;
	nextDay = new Date(sqlChart[s].dateTo);
	dnextDay = nextDay.getDate();
	mnextDay = parseInt(nextDay.getMonth());
	ynextDay = nextDay.getFullYear();
	nextDate = months[mnextDay] + " " + dnextDay + " , " + ynextDay;
	get_date_to = nextDate;
	if(chart_type == "chart6")
	{
		crId = idChart;
		get_cate1 = sqlChart[s].cate1;
		get_cate2 = sqlChart[s].cate2;
		drawChartVs(chart_type);
		$("#chart-"+crId).find("#show").html(get_date_from+ "-"+ get_date_to);
		$("#chart-"+crId).find(".select-1 option").each(function(){
			if($(this).val() == get_cate1)
			{
				$(this).attr("selected", "selected");
			}
		});
		$("#chart-"+crId).find(".select-2 option").each(function(){
			if($(this).val() == get_cate2)
			{
				$(this).attr("selected", "selected");
			}
		});
		
		$("#chart-"+(idChart-1)).find("span.apply").trigger('click');
	}else
	{		
		crId = idChart;
		drawChart(chart_type);
		$("#chart-"+crId).find("#show").html(get_date_from+ "-"+ get_date_to);
		$("#chart-"+crId).find("span.apply").trigger('click');
	}
}
@endif
</script>
@stop