@extends("Desktop.master")
@section('content')
<h1>{{$title}}</h1>
<?php
	$dateFrom = date("M d , Y", strtotime('-15 day'));
	$dateToView = date("M d , Y");
	$dateTo = date("M d , Y", strtotime('+1 day'));
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
<div id="chart6" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart2" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart3" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart5" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div id="chart4" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
</div>
@stop
@section("data_code")
<style type="text/css">
.main-content
{
	width: 100% !important;
}
</style>
<script type="text/javascript">
var dateFrom = "{{$from}}";
var dateTo = "{{$to}}";
var cate = null;
var urlGetCate = "{{URL::route('get_cate')}}";
var urlGetQuesByCate = "{{URL::route('draw_chart_question_by_cate')}}";
var urlGetQuesByDate = "{{URL::route('draw_chart_question_by_date')}}";
var urlGetAnsByCate = "{{URL::route('draw_chart_answer_by_cate')}}";
var urlGetQuesAndAns = "{{URL::route('draw_chart_ques_ans')}}";
var urlGetAnsByDate = "{{URL::route('draw_chart_ans_by_date')}}";
var urlGetLastLoginByDate = "{{URL::route('draw_chart_user_last_login_by_date')}}";
var urlGetUserLastLoginByDate = "{{URL::route('get_user_last_login')}}";


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
        $('#reportrange span#view-date').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
    	dateFrom = start.format('YYYY-MM-D')+' 00:00:00';
    	dateTo = end.format('YYYY-MM-D')+' 00:00:00';
    }
);
$.ajax({
  "url" : urlGetCate,
  "type" : "post",
  "data" : {},
  "async" :true,
  "success" : function(data){
      cate = data;
    }
});
function DrawChartQuestionByCate(from, to)
{
  $.ajax({
  "url" : urlGetQuesByCate,
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
  "url" : urlGetQuesByDate,
  "type" : "post",
  "data" : {"dateFrom":from, "dateTo":to},
  "async" :true,
  "success" : function(data){
    $('#chart2').highcharts({
        chart: {
                type: 'spline'
            },
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
    "url" : urlGetAnsByCate,
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
    "url" : urlGetQuesAndAns,
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
function DrawChartAnswerByDate(from, to){
  $.ajax({
  "url" : urlGetAnsByDate,
  "type" : "post",
  "data" : {"dateFrom":from, "dateTo":to},
  "async" :true,
  "success" : function(data){
    $('#chart5').highcharts({
        chart: {
                type: 'spline'
            },
            title: {
                text: 'Thống kê câu trả lời theo ngày',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: data.categories
            },
            yAxis: {
                title: {
                    text: 'Số câu trả lời mới'
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
                valueSuffix: ' câu trả lời mới'
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
function DrawChartLastLoginByDate(from, to){
  $.ajax({
  "url" : urlGetLastLoginByDate,
  "type" : "post",
  "data" : {"dateFrom":from, "dateTo":to},
  "async" :true,
  "success" : function(data){
    console.log(data);
    $('#chart6').highcharts({
        chart: {
                type: 'spline'
            },
            title: {
                text: 'Thống kê lần đăng nhập cuối cùng của người dùng',
                x: -20 //center
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: data.categories
            },
            yAxis: {
                title: {
                    text: 'Số người dùng đăng nhập lần cuối'
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
              shared: true,
                    useHTML: true,
                    headerFormat: '<small>Thời gian : {point.key}</small><div class="tooltip-ul-hover"><ul id="tooltip-ul-hover">',
                    pointFormat: '<li><span class="glyphicon glyphicon-refresh spin" aria-hidden="true"></span></li>',
                    footerFormat: '</ul></div>',
                    valueDecimals: 10
            },
            plotOptions:{
                series:{
                    allowPointSelect: true,
                    point: {
                        events:{
                            mouseOver: function(e) { 
                                getUserLastLogin(data.categories[this.x], data.categories[this.x]);
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
function getUserLastLogin(from, to)
{
  $.ajax({
  "url" : urlGetUserLastLoginByDate,
  "type" : "post",
  "data" : {dateFrom: from, dateTo : to},
  "async" :true,
  "success" : function(data){
        if(data != "")
        {
          setTimeout(function(){
            $("#tooltip-ul-hover").html('');
            j = 0;
            while(j<data.length)
            {
              $("#tooltip-ul-hover").append('<li style="color:rgb(124, 181, 236)">'+data[j]+'</li>');
              j++;
            }

          }, 1000);
        }else
        {
          $("#tooltip-ul-hover").html('');
          $("#tooltip-ul-hover").append('<li style="color:rgb(124, 181, 236)">Không có dữ liệu</li>');
        }
    }
  });
}
$(function () {
  $(document).ready(function () {
    $(".main-menu").hide();
    DrawChartQuestionByCate(dateFrom, dateTo);
    DrawChartQuestionByDate(dateFrom, dateTo);
    DrawChartAnswerByCate(dateFrom, dateTo);
    DrawChartQuestionAndAns(dateFrom, dateTo);
    DrawChartAnswerByDate(dateFrom, dateTo);
    DrawChartLastLoginByDate(dateFrom, dateTo);
    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
      DrawChartQuestionByCate(dateFrom, dateTo);
      DrawChartQuestionByDate(dateFrom, dateTo);
      DrawChartAnswerByCate(dateFrom, dateTo);
      DrawChartQuestionAndAns(dateFrom, dateTo);
      DrawChartAnswerByDate(dateFrom, dateTo);
      DrawChartLastLoginByDate(dateFrom, dateTo);
    });
  });
})
</script>
<style type="text/css">
#tooltip-ul-hover
{
	height: 50px;
	 overflow-y: visible;
}
#tooltip-ul-hover >li
{
	text-align: center;
}
.spin{
     -webkit-transform-origin: 50% 58%;
     transform-origin:50% 58%;
     -ms-transform-origin:50% 58%; /* IE 9 */
     -webkit-animation: spin .5s infinite linear;
     -moz-animation: spin .5s infinite linear;
     -o-animation: spin .5s infinite linear;
     animation: spin .5s infinite linear;
}
@-moz-keyframes spin {
  from {
    -moz-transform: rotate(0deg);
  }
  to {
    -moz-transform: rotate(360deg);
  }
}

@-webkit-keyframes spin {
  from {
    -webkit-transform: rotate(0deg);
  }
  to {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  from {
    transform: rotate(0deg);
  }
  to {
    transform: rotate(360deg);
  }
}
</style>
@stop
