$(function () {
	$(document).ready(function () {
		$(".main-menu").hide();
		$(".tree-chart").hide();
		$("#title-report-input").hide();
		var i = 0;
		$(".box-one").mouseenter(function(){
			if(i % 2 ==0)
			{
				$( ".tree-chart" ).animate({ "left": "80px" }, "slow" );
				$( ".tree-chart" ).show("slow");
			}
			i++;
		});
		$(".box").mouseleave(function(){
			$( ".tree-chart" ).hide("fast");
			$( ".tree-chart" ).animate({ "left": "0px" }, "fast" );	
			i++;
		});
		$("#show-input-report-title").on("click", function(){
			$("#title-report-input").show();
			$("#show-input-report-title").hide();
			$("#title-report h4 b").hide();
		});
		$("#title-report-input").keyup(function(e){
		    if(e.keyCode == 13)
		    {
		        var reportTitle = $("#title-report-input").val();
		        var checkString = false;
		        for(i=0; i<reportTitle.length; i++)
		        {
		        	if(reportTitle[i] == " ")
		        	{
		        		checkString = false;
		        	}else
		        	{
		        		checkString = true;
		        	}
		        }
		        if(checkString == true)
		        {
		        	$("#title-report h4 b").html(reportTitle).show();
		        	$("#title-report-input").hide();
		        	$("#show-input-report-title").show();
		        }else
		        {
		        	$("#title-report-input").addClass("error-input-title-report");
		        }
		    }
		});

	});
})
function DrawChartQuestionByCate(from, to, chart)
{
	$.ajax({
	"url" : urlDrawChartQuestionByCate,
	"type" : "post",
	"data" : {"dateFrom":from, "dateTo":to},
	"async" :true,
	"success" : function(data){
			$('#'+chart).find('#show-chart').highcharts({
		          chart: {
		                plotBackgroundColor: null,
		                plotBorderWidth: null,
		                plotShadow: false,
		            },
		            title: {
		                text: 'Thống kê các câu hỏi theo chủ đề',
		                style: {
								fontFamily: 'DejaVuSans', // default font
								fontSize: '18px'
							}
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
		                        enabled: true,
		                        style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
		                    },
		                    showInLegend: false

		                     

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
//
function DrawChartQuestionByDate(from, to, chart){
	$.ajax({
	"url" : urlDrawChartQuestionByDate,
	"type" : "post",
	"data" : {"dateFrom":from, "dateTo":to},
	"async" :true,
	"success" : function(data){
		$('#'+chart).find('#show-chart').highcharts({
				chart: {
		            type: 'spline'
		        },
		        title: {
		            text: 'Thống kê câu hỏi theo ngày',
		            x: -20 ,
		            style: {
								fontFamily: 'DejaVuSans', // default font
								fontSize: '18px'
							}
		        },
		        subtitle: {
		            text: '',
		            x: -20
		        },
		        xAxis: {
		            categories: data.date,
		            style: {
								fontFamily: 'DejaVuSans', // default font
								fontSize: '12px'
							}
		        },
		        yAxis: {
		            title: {
		                text: 'Số câu hỏi mới',
		                style: {
								fontFamily: 'DejaVuSans', // default font
								fontSize: '12px'
							}
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
		            borderWidth: 0,
		             itemStyle: {
		                 fontFamily: 'DejaVuSans', // default font
						 fontSize: '12px'
		              },
		        },
		        series: data.data,

		    });
		}
	});

}
//
function DrawChartAnswerByCate(from, to, chart)
{
		$.ajax({
		"url" : urlDrawChartAnswerByCate ,
		"type" : "post",
		"data" : {"dateFrom":from, "dateTo":to},
		"async" :true,
		"success" : function(data){
			$('#'+chart).find('#show-chart').highcharts({
		        chart: {
		            plotBackgroundColor: null,
		            plotBorderWidth: null,//null,
		            plotShadow: false
		        },
		        title: {
		            text: 'Thống kê câu trả lời theo chủ đề',
		            style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '18px'
								}
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
		                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black',
		                        fontFamily : 'DejaVuSans',
		                        fontSize : '12px'
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
//
function DrawChartAnswerByDate(from, to, chart){
	$.ajax({
	"url" : urlDrawChartAnswerByDate,
	"type" : "post",
	"data" : {"dateFrom":from, "dateTo":to},
	"async" :true,
	"success" : function(data){
		$('#'+chart).find('#show-chart').highcharts({
				chart: {
		            type: 'spline'
		        },
		        title: {
		            text: 'Thống kê câu trả lời theo ngày',
		            style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '18px'
								},
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
		                text: 'Số câu trả lời mới',
		                style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
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
		            borderWidth: 0,
		            itemStyle: {
		                 fontFamily: 'DejaVuSans', // default font
						 fontSize: '12px'
		              },

		        },
		        series: data.data
		    });
		}
	});

}
//
function DrawChartQuestionAndAns(from, to, chart)
{
	$.ajax({
		"url" : urlDrawChartQuestionAndAns,
		"type" : "post",
		"data" : {"dateFrom":from, "dateTo":to},
		"async" :true,
		"success" : function(data){
			$('#'+chart).find('#show-chart').highcharts({
		        chart: {
		            type: 'column'
		        },
		        legend: {
		            reversed: true,
		            itemStyle: {
		                 fontFamily: 'DejaVuSans', // default font
						 fontSize: '12px'
		              },
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Số lượng',
		                style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
		            }
		        },
		        title: {
		            text: 'Thống kê câu hỏi & câu trả lời theo chủ đề',
		            style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '18px'
								}
		        },
		        xAxis: {
		            categories: data.categories,
		            labels: {
		            	style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
		            }
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
//
function DrawChartQuestionAndAnsVs(from, to, chart, cate1, cate2)
{
	$.ajax({
		"url" : urlDrawChartQuestionAndAnsVs,
		"type" : "post",
		"data" : {"dateFrom":from, "dateTo":to, "cate1": cate1, "cate2":cate2},
		"async" :true,
		"success" : function(data){
			$('#'+chart).find('#show-chart').highcharts({
		        chart: {
		            type: 'column'
		        },
		        legend: {
		            reversed: true,
		            itemStyle: {
		                 fontFamily: 'DejaVuSans', // default font
						 fontSize: '12px'
		              },
		        },
		        title: {
		            text: 'So sánh câu hỏi & câu trả lời của 2 chủ đề',
		            style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '18px'
								}
		        },
		        yAxis: {
		            min: 0,
		            title: {
		                text: 'Số lượng',
		                style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
		            }
		        },
		        xAxis: {
		            categories: data.categories,
		            labels: {
		            	style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
		            }
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
//
function DrawChartLastLoginByDate(from, to, chart){
	$.ajax({
	"url" : urlDrawChartLastLoginByDate,
	"type" : "post",
	"data" : {"dateFrom":from, "dateTo":to},
	"async" :true,
	"success" : function(data){
		$('#'+chart).find('#show-chart').highcharts({
				chart: {
		            type: 'spline'
		        },
		        title: {
		            text: 'Thống kê lần đăng nhập cuối cùng của người dùng',
		             style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '18px'
								},
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
		                text: 'Số người dùng đăng nhập lần cuối',
		                 style: {
									fontFamily: 'DejaVuSans', // default font
									fontSize: '12px'
								}
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
							
		        },
		        plotOptions:{
                series:{
                    allowPointSelect: true,
                    point: {
                        events:{
                        		mouseOver: function(e) { 
                            	}
                        	}                        
                    	}
                	}
           		 },
		        legend: {
		            layout: 'vertical',
		            align: 'right',
		            verticalAlign: 'middle',
		            borderWidth: 0,
		            itemStyle: {
		                 fontFamily: 'DejaVuSans', // default font
						 fontSize: '12px'
		              },
		        },
		        series: data.data
		    });
		}
	});

}
//
function removeChart()
{
	$(".remove").on("click", function(event){
			currentChart = $(this).parent().parent().parent().attr("id");
			$("#"+currentChart).remove();
			applyLayout();
	});
}
function applyLayout()
{
	container = document.querySelector('.packery');
  	pckry = new Packery(container);
	pckry.layout();
	// Scroll bottom when add chart
	$(document).scrollTop($(document).height());
}
function drawChart(type)
{
		var $items = $(chartItem);
		$items.attr("id","chart-"+idChart);
		$items.attr("data-chart", type);
		$items.find(".chart-view").hide();
    	$container.append($items)
                .packery('appended', $items)
        $items.each(makeEachDraggable);
        $items.find('#reportrange').daterangepicker({
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
		        $items.find('#reportrange span#show').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));  
		    }
		);
	    $items.find('#reportrange').on('apply.daterangepicker', function(ev, picker) {
	   
	    });
	    applyChart($items.attr("id"));
	    idChart++;
	    removeChart();
	    applyLayout();
}
function drawChartVs(type)
{
		var $items = $(chartItemVs);
		$items.attr("id","chart-"+idChart);
		$items.attr("data-chart", type);
		$items.find(".chart-view").hide();
    	$container.append($items)
                .packery('appended', $items)
        $items.each(makeEachDraggable);
        $items.find('#reportrange').daterangepicker({
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
		        $items.find('#reportrange span#show').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));  
		    }
		);
	    $items.find('#reportrange').on('apply.daterangepicker', function(ev, picker) {
	   
	    });
	    applyChart($items.attr("id"));
	    idChart++;
	    removeChart();
	    applyLayout();
}
function applyChart(chart)
{
 		$("#"+chart).find("span.apply").on("click", function(){
 		typeChart = $("#"+chart).attr("data-chart");
 		dateChart = $("#"+chart).find('#reportrange span#show').html();
 		dateChart = dateChart.split('-');
 		dateFrom = dateChart[0];
 		dateTo = dateChart[1];
 		nextDay = new Date(dateTo);
 		dnextDay = nextDay.getDate()+1;
 		mnextDay = nextDay.getMonth()+1;
 		if(dnextDay > 31)
 		{
 			dnextDay = 1;
 			mnextDay = mnextDay+1;
 		}
 		ynextDay = nextDay.getFullYear();
 		nextDate = mnextDay + " " + dnextDay + " , " + ynextDay;
 		dateTo = nextDate;
 		$("#"+chart).find(".chart-view").show();
 		$("#"+chart).find(".option-chart .reportrange").hide();
 		$("#"+chart).find(".option-chart #select-cate").hide();
 		//$("#"+chart).find(".remove-edit-chart").css({"opacity":"0.5"});
 		$("#"+chart).find('.edit, .remove').css({"opacity":"0.5"});
 		$("#"+chart).find(".option-chart .apply").hide();
 		$("#"+chart).css({"border":"none"});
 		$(".edit, .remove").mouseenter(function(){
			$(this).css({"opacity":"1"});
		});
		$(".edit, .remove").mouseleave(function(){
			$(this).css({"opacity":"0.5"});
		});
		$(".edit").on("click", function(){
			currentChart = $(this).parent().parent().parent().attr("id");
			$("#"+currentChart).find(".chart-view").hide();
			$("#"+currentChart).find(".option-chart .reportrange").show();
			$("#"+currentChart).find(".option-chart #select-cate").show();
			$("#"+currentChart).find('.edit, .remove').css({"opacity":"1"});
			$("#"+currentChart).find(".option-chart .apply").show();
			$("#"+currentChart).css({"border":"none"});
			$(".edit, .remove").mouseleave(function(){
				$(this).css({"opacity":"1"});
			});
		});

 		switch(typeChart)
 		{
			case "chart1":
				DrawChartQuestionByCate(new Date(dateFrom+" 00:00:00"), new Date(dateTo+" 00:00:00"), chart);
 				break;
 			case "chart2":
 				DrawChartQuestionByDate(new Date(dateFrom+" 00:00:00"), new Date(dateTo+" 00:00:00"), chart);
 				break;
 			case "chart3":
 				DrawChartAnswerByCate(new Date(dateFrom+" 00:00:00"), new Date(dateTo+" 00:00:00"), chart);
 				break;
 			case "chart4":
 				DrawChartAnswerByDate(new Date(dateFrom+" 00:00:00"), new Date(dateTo+" 00:00:00"), chart);
 				break;
 			case "chart5":
 				DrawChartQuestionAndAns(new Date(dateFrom+" 00:00:00"), new Date(dateTo+" 00:00:00"), chart);
 				break;
 			case "chart6":
 				var cate1 = $("#"+chart).find(".select-1").val();
 				var cate2 = $("#"+chart).find(".select-2").val();
 				DrawChartQuestionAndAnsVs(new Date(dateFrom+" 00:00:00"), new Date(dateTo+" 00:00:00"), chart, cate1, cate2);
 				break;
 			case "chart7":
 				var date_from = new Date(dateFrom+" 00:00:00");
 				var tomorrow1 = new Date(date_from);
				tomorrow1.setDate(date_from.getDate());

 				var date_to = new Date(dateTo+" 00:00:00");
 				var tomorrow = new Date(date_to);
				tomorrow.setDate(date_to.getDate());
 				DrawChartLastLoginByDate(tomorrow1, tomorrow, chart);
 				break;			
 		}
			
		});

}
var pckry;
var $container = $('.packery');
var container = document.querySelector('.packery');
var pckry = new Packery(container);
$container.packery({
        columnWidth: 1049,
        rowHeight: 10
    });
$container.find('.item').each(makeEachDraggable);
    function makeEachDraggable(i, itemElem) {
        // make element draggable with Draggabilly
        var draggie = new Draggabilly(itemElem, {handle: ".handle"});
        // bind Draggabilly events to Packery
        $container.packery('bindDraggabillyEvents', draggie);
    }
   idChart = 1;
$("#add-chart-1").on("click", function(){
	drawChart('chart1');  
});
$("#add-chart-2").on("click", function(){
	drawChart('chart2');
});
$("#add-chart-3").on("click", function(){
	drawChart('chart3');
});
$("#add-chart-4").on("click", function(){
	drawChart('chart4');
});
$("#add-chart-5").on("click", function(){
	drawChart('chart5');
});
$("#add-chart-6").on("click", function(){
	drawChartVs('chart6');
});
$("#add-chart-7").on("click", function(){
	drawChart('chart7');
});

$(".pdfed").on("click", function(){
	$(".btn-apply").addClass("export-pdf");
	$(".btn-apply").removeClass("save-pdf");
});
$(".saved").on("click", function(){
	$(".btn-apply").addClass("save-pdf");
	$(".btn-apply").removeClass("export-pdf");
});
$(".btn-apply").on("click", function(){
	if($(this).hasClass('export-pdf'))
	{
		getAllChart();
	}else if($(this).hasClass('save-pdf'))
	{
		attr = $(this).attr('data-id');
		if(typeof attr !== typeof undefined && attr !== false)
		{
			getAllChartUpdateDatabase(attr);
		}else
		{
			getAllChartInserDatabase();
		}
	}
});
arrChartSVG = Array();
//Export chart
function getAllChart()
{
	nameDoc = $(".name-of-document").val();

	cd = false;
	for(k=0; k< nameDoc.length; k++)
	{
		if(nameDoc[k] == " ")
		{
			cd = false;
		}else
		{
			cd = true;
		}
	}
	if(cd == true)
	{
		arrChartSVG = [];
		$(".packery > .item").each(function(){
			str = $(this).find(".highcharts-container").html();
			arrChartSVG.push(str);
		});
		name = $(".name-of-document").val();
		title = $("#title-report").find("b").text();
		$('#myModal').modal('hide');
		$.ajax({
			"url" : urlCreatePdf,
			"type" : "post",
			"data" : {"name":name, "dataSvg":arrChartSVG, "title":title},
			"async" :true,
			"success" : function(data){
				console.log(data);
				if(data == "true")
				{
					window.open(
				  	urlCreatePdf,
				  '_blank' // <- This is what makes it open in a new window.
				);
				}
				
			}
		});
	}else
	{
		$(".name-of-document").addClass("error-input-title-report").css({"font-size":"20px"});
	}
}
//Save Chart
insertDataChart = [];
function getAllChartInserDatabase()
{
	nameDoc = $(".name-of-document").val();

	cd = false;
	for(k=0; k< nameDoc.length; k++)
	{
		if(nameDoc[k] == " ")
		{
			cd = false;
		}else
		{
			cd = true;
		}
	}
	if(cd == true)
	{

		insertDataChart = [];
		$(".packery > .item").each(function(){
			typeChart = $(this).attr("data-chart");
	 		dateChart = $(this).find('#reportrange span#show').html();
	 		dateChart = dateChart.split('-');
	 		dateFrom = dateChart[0];
	 		dateTo = dateChart[1];
	 		nextDay = new Date(dateTo);
	 		dnextDay = nextDay.getDate();
	 		mnextDay = nextDay.getMonth()+1;
	 		ynextDay = nextDay.getFullYear();
	 		nextDate = mnextDay + " " + dnextDay + " , " + ynextDay;
	 		dateTo = nextDate;
	 		var item = {};
	 		item.type = typeChart;
	 		item.dateFrom = dateFrom;
	 		item.dateTo = dateTo;
	 		if(typeChart == "chart6")
	 		{
	 			cate1 = $(this).find(".select-1").val();
 				cate2 = $(this).find(".select-2").val();
 				item.cate1 = cate1;
 				item.cate2 = cate2;
	 		}
	 		insertDataChart.push(item);
		});
		name = $(".name-of-document").val();
		title = $("#title-report").find("b").text();
		$('#myModal').modal('hide');
		$.ajax({
			"url" : urlInsertPdf,
			"type" : "post",
			"data" : {"name":name, "insertData":insertDataChart, "title":title},
			"async" :true,
			"success" : function(data){
				
				console.log(data);
				if(data == "true")
				{
					alert("Lưu tài liệu thành công");
				}else
				{
					alert(data.mess);
				}
				
				
			}
		});
	}else
	{
		$(".name-of-document").addClass("error-input-title-report").css({"font-size":"20px"});
	}
}

//
 var months = ["Jan", "Feb", "Mar", "Apr", "May",
 "Jun", "Jul", "Aug", "Sep", "Oct",
 "Nov", "Dec"]

function getAllChartUpdateDatabase(cid)
{
	nameDoc = $(".name-of-document").val();

	cd = false;
	for(k=0; k< nameDoc.length; k++)
	{
		if(nameDoc[k] == " ")
		{
			cd = false;
		}else
		{
			cd = true;
		}
	}
	if(cd == true)
	{

		insertDataChart = [];
		$(".packery > .item").each(function(){
			typeChart = $(this).attr("data-chart");
	 		dateChart = $(this).find('#reportrange span#show').html();
	 		dateChart = dateChart.split('-');
	 		dateFrom = dateChart[0];
	 		dateTo = dateChart[1];
	 		nextDay = new Date(dateTo);
	 		dnextDay = nextDay.getDate();
	 		mnextDay = parseInt(nextDay.getMonth());
	 		ynextDay = nextDay.getFullYear();
	 		nextDate = months[mnextDay] + " " + dnextDay + " , " + ynextDay;
	 		dateTo = nextDate;
	 		var item = {};
	 		item.type = typeChart;
	 		item.dateFrom = dateFrom;
	 		item.dateTo = dateTo;
	 		if(typeChart == "chart6")
	 		{
	 			cate1 = $(this).find(".select-1").val();
 				cate2 = $(this).find(".select-2").val();
 				item.cate1 = cate1;
 				item.cate2 = cate2;
	 		}
	 		insertDataChart.push(item);
		});
		name = $(".name-of-document").val();
		title = $("#title-report").find("b").text();
		$('#myModal').modal('hide');
		$.ajax({
			"url" : urlUpdatePdf,
			"type" : "post",
			"data" : {"name":name, "insertData":insertDataChart, "title":title, "id" : cid},
			"async" :true,
			"success" : function(data){
				
				if(data == "true")
				{
					alert("Cập nhật tài liệu thành công");

				}else
				{
					alert(data.mess);
				}
				
				
			}
		});
	}else
	{
		$(".name-of-document").addClass("error-input-title-report").css({"font-size":"20px"});
	}
}



