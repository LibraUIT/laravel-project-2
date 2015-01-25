@extends("master")
@section('content')
<h1>{{$title}}</h1>
<?php
	$dateFrom = date("d-M-Y", strtotime('-15 day'));
	$dateToView = date("d-M-Y");
	$dateTo = date("d-M-Y", strtotime('+1 day'));
	$from = new Datetime($dateFrom);
	$from = $from->format('Y-m-d H:i:s');
	$to = new Datetime($dateTo);
	$to = $to->format('Y-m-d H:i:s');
?>
<div id="reportrange" class="pull-left date-filter">
    <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
    <span id="view-date">{{$dateFrom}} - {{$dateToView}}</span><b class="caret"></b>
</div>
<div class="all-chart">
<div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
@stop
@section("data_code")

<script type="text/javascript">
var dateFrom = "{{$from}}";
var dateTo = "{{$to}}";
var cate = null;
$.ajax({
	"url" : "{{URL::route('get_cate')}}",
	"type" : "post",
	"data" : {},
	"async" :true,
	"success" : function(data){
			cate = data;
		}
});
$('#reportrange').daterangepicker(
    {
      ranges: {
         'Today': [moment(), moment()],
         'Yesterday': [moment().subtract('days', 1), moment().subtract('days', 1)],
         'Last 7 Days': [moment().subtract('days', 6), moment()],
         'Last 30 Days': [moment().subtract('days', 29), moment()],
         'This Month': [moment().startOf('month'), moment().endOf('month')],
         'Last Month': [moment().subtract('month', 1).startOf('month'), moment().subtract('month', 1).endOf('month')]
      },
      startDate: moment().subtract('days', 29),
      endDate: moment()
    },
    function(start, end) {
        $('#reportrange span#view-date').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    	dateFrom = start.format('YYYY-MM-D')+' 00:00:00';
    	dateTo = end.format('YYYY-MM-D')+' 00:00:00';
    }
);
function DrawChartQuestionByCate(from, to)
{
	$.ajax({
	"url" : "{{URL::route('draw_chart_question_by_cate')}}",
	"type" : "post",
	"data" : {"dateFrom":from, "dateTo":to},
	"async" :true,
	"success" : function(data){
		$('#chart1').highcharts({
	          chart: {
	                plotBackgroundColor: null,
	                plotBorderWidth: null,
	                plotShadow: false
	            },
	            title: {
	                text: 'Thống kê các câu hỏi theo chủ đề'
	            },
	            exporting: { enabled: false },
	            credits: {
						            enabled: false
						        },
	            tooltip: {
	                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
	            },
	            plotOptions: {
	                pie: {
	                    allowPointSelect: true,
	                    cursor: 'pointer',
	                    dataLabels: {
	                        enabled: false
	                    },
	                    showInLegend: true,
	                     

	                }
	            },
	            series: [{
	                type: 'pie',
	                name: 'Số câu hỏi thuộc chủ đề',
	                data: data,
	                point:{
	                events:{
	                      click: function (event) {
	                          if (typeof cate[this.name] != 'undefined') {
                            			getQuestionByCate(cate[this.name]);
									}
	                      }
	                  }
	              }    
	            }]
	        });
	}
});
}
function DrawChartQuestionByDate(from, to){
	$.ajax({
	"url" : "{{URL::route('draw_chart_question_by_date')}}",
	"type" : "post",
	"data" : {"dateFrom":from, "dateTo":to},
	"async" :true,
	"success" : function(data){
		$('#chart2').highcharts({
		        title: {
		            text: 'Thống kê câu hỏi theo ngày',
		            x: -20 //center
		        },
		        subtitle: {
		            text: '',
		            x: -20
		        },
		        xAxis: {
		            categories: data.date
		        },
		        yAxis: {
		            title: {
		                text: 'Số câu hỏi mới'
		            },
		            plotLines: [{
		                value: 0,
		                width: 1,
		                color: '#808080'
		            }]
		        },
		        exporting: { enabled: false },
			    credits: {
						enabled: false
						},
		        tooltip: {
		            valueSuffix: ' câu hỏi mới'
		        },
		        plotOptions:{
                series:{
                    allowPointSelect: true,
                    point: {
                        events:{
                            	select: function(e) {                                
                            		//$("#displayText").html(e.currentTarget.y);
                            		if (typeof data.series[this.series.name] != 'undefined') {
                            			getQuestionByDate(this.category, data.series[this.series.name]);
									}
                            		

                            	}
                        	}                        
                    	}
                	}
           		 },
		        legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'middle',
		            borderWidth: 0
		        },
		        series: data.data
		    });
		}
	});

}
function DrawChartAnswerByCate(from, to)
{
		$.ajax({
		"url" : "{{URL::route('draw_chart_answer_by_cate')}}",
		"type" : "post",
		"data" : {"dateFrom":from, "dateTo":to},
		"async" :true,
		"success" : function(data){
			$('#chart3').highcharts({
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,//null,
		            plotShadow: false
		        },
		        title: {
		            text: 'Thống kê câu trả lời theo chủ đề'
		        },
		        tooltip: {
		            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
		        },
		        exporting: { enabled: false },
				credits: {
							enabled: false
						},
		        plotOptions: {
		            pie: {
		                allowPointSelect: true,
		                cursor: 'pointer',
		                dataLabels: {
		                    enabled: true,
		                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
		                    style: {
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
		                    }
		                }
		            }
		        },
		        series: [{
		            type: 'pie',
		            name: 'Các câu trả lời thuộc chủ đề',
		            data: data
		        }]
		    });
		}
	});
}

function DrawChartQuestionAndAns(from, to)
{
	$.ajax({
		"url" : "{{URL::route('draw_chart_ques_ans')}}",
		"type" : "post",
		"data" : {"dateFrom":from, "dateTo":to},
		"async" :true,
		"success" : function(data){
			console.log(data);
			$('#chart4').highcharts({
		        chart: {
		            type: 'column'
		        },
		        title: {
		            text: 'Thống kê câu hỏi & câu trả lời theo chủ đề'
		        },
		        xAxis: {
		            categories: data.categories
		        },
		        exporting: { enabled: false },
		        credits: {
		            enabled: false
		        },
		        series: data.data
		    });
		}
	});
}
function getQuestionByDate(d, id)
{
	var currentYear = new Date().getFullYear();
    var currentMonth = new Date().getMonth()+1;
    var date = new Date(d+"-"+currentYear);
    var day = date.getDate();
    var month = date.getMonth()+1;
    var year = currentYear;
    if(month > currentMonth)
    {
        year = currentYear - 1;
    }
    var url = "{{URL::to('/')}}/question/date/"+day+"/"+month+"/"+year+"/"+id;
    window.open(
				  url,
				  '_blank'
				);
}
function getQuestionByCate(id)
{
  dFrom = new Date(dateFrom);
  dayFrom = dFrom.getDate();
  mFrom  = dFrom.getMonth()+1;
  yFrom = dFrom.getFullYear();
  date_from = dayFrom+"-"+mFrom+"-"+yFrom;
  dTo = new Date(dateTo);
  dayTo = dTo.getDate();
  mTo = dTo.getMonth()+1;
  yTo = dTo.getFullYear();
  date_to = dayTo+"-"+mTo+"-"+yTo;
  var url = "{{URL::to('/')}}/question/cate/date/"+date_from+"/"+date_to+"/"+id;
  console.log(url);
  window.open(
				  url,
				  '_blank'
				);
}
$(function () {
	$(document).ready(function () {
		DrawChartQuestionByCate(dateFrom, dateTo);
		DrawChartQuestionByDate(dateFrom, dateTo);
		DrawChartAnswerByCate(dateFrom, dateTo);
		DrawChartQuestionAndAns(dateFrom, dateTo);
		$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
			DrawChartQuestionByCate(dateFrom, dateTo);
			DrawChartQuestionByDate(dateFrom, dateTo);
			DrawChartAnswerByCate(dateFrom, dateTo);
			DrawChartQuestionAndAns(dateFrom, dateTo);
		});
	});
})
</script>
@stop