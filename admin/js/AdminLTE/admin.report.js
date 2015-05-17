'use strict';
var urlDrawChartQuestionByCate = [configReportUrlPath,'question','getchartbycate'].join('/');
var urlDrawChartQuestionByDate = [configReportUrlPath, 'question', 'getchartbydate'].join('/');
var urlDrawChartAnswerByCate = [configReportUrlPath, "answer", "getchartbycate"].join('/');
var urlDrawChartAnswerByDate = [configReportUrlPath, "answer", "getchartbydate"].join('/');
var urlDrawChartQuestionAndAns = [configReportUrlPath, "qanda"].join('/');
var urlDrawChartQuestionAndAnsVs = [configReportUrlPath, "vs"].join('/');
var urlDrawChartLastLoginByDate = [configReportUrlPath, "users", "getchartlastloginbydate"].join('/');
var urlCreatePdf = [configApiUrlPathPdf,"create"].join('/');
var urlInsertPdf = [configApiUrlPathPdf,"insert"].join('/');
var urlUpdatePdf = [configApiUrlPathPdf,"update"].join('/');
var months = ["Jan", "Feb", "Mar", "Apr", "May",
		 "Jun", "Jul", "Aug", "Sep", "Oct",
		 "Nov", "Dec"];
var getToday = new Date();
var getD = getToday.getDate();
var getM = getToday.getMonth();
var getY = getToday.getFullYear();
var sdateTo =  months[getM] + ' ' + getD + ' , ' + getY;
var getFrom = new Date(getToday);
getFrom.setDate(getToday.getDate() - 15);
var getFromD = getFrom.getDate();
var getFromM = getFrom.getMonth();
var getFromY = getFrom.getFullYear();
var sdateFrom = months[getFromM] + ' ' + getFromD + ' , ' + getFromY;
var idChart = 1;
configApp.factory("ReportService", function($http) {
  return {
	    list : function()
	    {
	    	var urlConfig = [configApiUrlPath, 'report_list'].join('/'); 
	    	return $http.get(urlConfig);
	    },
	    delete :  function(sendData)
	    {
	    	var urlConfig = [configApiUrlPath, 'report_delete'].join('/');
	    	return $http({
			    method: 'POST',
			    url: urlConfig,
			    data: $.param({data:sendData }),
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}); 
	    },
	    listCate : function()
	    {
	    	var urlConfig = [configApiUrlPath, 'categorie_list'].join('/'); 
	    	return $http.get(urlConfig);
	    },
	    editTitle : function(sendData)
	    {
	    	var urlConfig = [configApiUrlPath, 'report_edit_title'].join('/'); 
	    	return $http({
			    method: 'POST',
			    url: urlConfig,
			    data: $.param({data:sendData }),
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}); 
	    },
	    editData : function(sendData)
	    {
	    	var urlConfig = [configApiUrlPath, 'report_edit_data'].join('/'); 
	    	return $http({
			    method: 'POST',
			    url: urlConfig,
			    data: $.param({data:sendData }),
			    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
			}); 
	    }
	}
});
configControllers.controller('ReportController', ['$scope', '$rootScope', '$route','$routeParams', '$location','$http', '$state', 'ReportService', '$window',
  function($scope, $rootScope, $route ,$routeParams, $location, $http, $state, ReportService, $window) {
    	document.title = 'AdminLTE | Report Management';
	    if(isAdminLogin() === false)
	    {
	      	$location.path('/sign');
	    }
    	var reportId = $routeParams.id;
    	if(typeof reportId != "undefined")
    	{
    		ReportService.editTitle(reportId).success(function(response){
    			$scope.form_title = response;
    		});
    	}

}]);
configControllers.directive('editReport', function(ReportService, $routeParams, $route) {
  return {
    restrict: 'A',
    link : function(scope, elem, attrs)
    {
    	var reportId = $routeParams.id;
    	var pckry;
		var $container = $('.packery');
		var container = document.querySelector('.packery');
		var pckry = new Packery(container);
		$container.packery({
		        columnWidth: 1015,
		        rowHeight: 10
		    });
		$container.find('.item').each(makeEachDraggable);
		function makeEachDraggable(i, itemElem) {
		        // make element draggable with Draggabilly
		        var draggie = new Draggabilly(itemElem, {handle: ".handle"});
		        // bind Draggabilly events to Packery
		        $container.packery('bindDraggabillyEvents', draggie);
		}

		var chartItem = '<div class="item w1 h1">'+
		  				'<div class="chart-view" id="show-chart"></div>'+
				  		'<div class="option-chart">'+
				  		'<div id="reportrange" class="pull-right reportrange" style="cursor: pointer; padding: 5px 10px; position: absolute; left:15px">'+
					    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>'+
					    '<span id="show">'+sdateFrom+' - '+sdateTo+' </span><b class="caret"></b>'+
					    '</div>'+
					    '<div class="remove-edit-chart">'+
					    '<span class="glyphicon glyphicon-ok-circle apply" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-cog edit" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>'+
					    '</div>'+
						'</div>'+
				  		'</div>';
		var select = '';
		var chartItemVs = '';
		ReportService.listCate().success(function(response) {
			for(var i = 0; i < response.length; i++)
			{
				select += '<option value="'+response[i].id+'">'+response[i].title+'</option>';
			}
			chartItemVs = '<div class="item w1 h1">'+
  					'<div class="chart-view" id="show-chart"></div>'+
					'<div class="option-chart">'+
						'<div id="reportrange" class="pull-right reportrange" style="cursor: pointer; padding: 5px 10px; position: absolute; left:15px">'+
						    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>'+
						    '<span id="show">'+sdateFrom+' - '+sdateTo+'</span><b class="caret"></b>'+
						'</div>'+
						'<div id="select-cate">'+
						'<select  class="select-1">'+
					      select+
					  	'</select>'+
					  	'<select  class="select-2">'+
					      select+
					  	'</select>'+
					  	'</div>'+
					  	'<div class="remove-edit-chart">'+
					    '<span class="glyphicon glyphicon-ok-circle apply" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-cog edit" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>'+
					    '</div>'+
					'</div>'+
				'</div>';
			//
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
					    console.log($items.attr("id"));
					    idChart++;
					    removeChart();
					    applyLayout();
				}
				function getAllChartUpdateDatabase(cid)
				{
					var nameDoc = scope.form_title;

					var cd = false;
					for(var k=0; k< nameDoc.length; k++)
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

						var insertDataChart = [];
						$(".packery > .item").each(function(){
							var typeChart = $(this).attr("data-chart");
					 		var dateChart = $(this).find('#reportrange span#show').html();
					 		var dateChart = dateChart.split('-');
					 		var dateFrom = dateChart[0];
					 		var dateTo = dateChart[1];
					 		var nextDay = new Date(dateTo);
					 		var dnextDay = nextDay.getDate();
					 		var mnextDay = parseInt(nextDay.getMonth());
					 		var ynextDay = nextDay.getFullYear();
					 		var nextDate = months[mnextDay] + " " + dnextDay + " , " + ynextDay;
					 		var dateTo = nextDate;
					 		var item = {};
					 		item.type = typeChart;
					 		item.dateFrom = dateFrom;
					 		item.dateTo = dateTo;
					 		if(typeChart == "chart6")
					 		{
					 			var cate1 = $(this).find(".select-1").val();
				 				var cate2 = $(this).find(".select-2").val();
				 				item.cate1 = cate1;
				 				item.cate2 = cate2;
					 		}
					 		insertDataChart.push(item);
						});
						var name = scope.form_title;
						var title = scope.form_title;
						$('#myModal').modal('hide');
						$.ajax({
							"url" : urlUpdatePdf,
							"type" : "post",
							"data" : {"name":name, "insertData":insertDataChart, "title":title, "id" : cid},
							"async" :true,
							"success" : function(data){
								
								if(data == "true")
								{
									//alert("Cập nhật tài liệu thành công");

								}else
								{
									//alert(data.mess);
								}
								
								
							}
						});
					}else
					{
						$(".name-of-document").addClass("error-input-title-report").css({"font-size":"20px"});
					}
				}
		    	if(typeof reportId != "undefined")
		    	{
			    	ReportService.editData(reportId).success(function(response){
			    		var sqlChart = response;
						for(var s = 0; s < sqlChart.length; s++)
						{
							var chart_type = sqlChart[s].type;
							var get_date_from = sqlChart[s].dateFrom;
							var nextDay = new Date(sqlChart[s].dateTo);
							var dnextDay = nextDay.getDate();
							var mnextDay = parseInt(nextDay.getMonth());
							var ynextDay = nextDay.getFullYear();
							var nextDate = months[mnextDay] + " " + dnextDay + " , " + ynextDay;
							var get_date_to = nextDate;
							if(chart_type == "chart6")
							{
								var crId = idChart;
								var get_cate1 = sqlChart[s].cate1;
								var get_cate2 = sqlChart[s].cate2;
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
								var crId = idChart;
								drawChart(chart_type);
								$("#chart-"+crId).find("#show").html(get_date_from+ "-"+ get_date_to);
								$("#chart-"+crId).find("span.apply").trigger('click');
							}
						}
						//
						scope.update = function()
						{
							getAllChartUpdateDatabase(reportId);
							$route.reload();
						}
			    	});
			    }	
			//				
		});
					  		

    }
  };
});
configControllers.directive('datatableReport', function(ReportService) {
  return {
    restrict: 'A',
    link : function(scope, elem, attrs)
    {
    	ReportService.list().success(function(response) {
    		scope.ReportList = response;
    	});
    	$('.alert-delete').hide();
	    $('.alert-create').hide();
	    $('.alert-create-erorr').hide();
        setTimeout(function(){ 
        	$(function() {
               dataTable = $('#'+attrs.id).dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bSort": false,
                    "bInfo": true,
                    "bAutoWidth": false
                });
                /*$('input[type="checkbox"]').iCheck({
                    checkboxClass: 'icheckbox_minimal-blue',
                    radioClass: 'iradio_minimal-blue'
                });*/
        	});
        }, 1000);
    }
  };
});
configControllers.directive('selectAllReport', function(ReportService, $state, $route, $location, $window) {
  return {
    restrict: 'A',
    link : function(scope, elem, attrs)
    {
    	setTimeout(function(){ 
    		var issetAll = false;
	    	var $selectAll = $('#'+attrs.id);
	    	var $selectItem = $('.select-item');
	    	var deleteArr = [];
	    	var length = $selectItem.length;
	    	$selectAll.on('click', function(){
	    		if($selectAll.is(':checked'))
	    		{
	    			$selectItem.prop('checked', true);
	    			issetAll = true;
	    			$selectItem.each(function(index){
	    				var id = $(this).attr('value');
	    				deleteArr.push(id);
	    			});
	    		}else
	    		{
	    			$selectItem.prop('checked', false);
	    			issetAll = false;
	    			deleteArr = [];
	    		}
	    	});
	    	$selectItem.on('click', function(){
	    		var id = $(this).attr('value');
	    		if($(this).is(':checked'))
	    		{			
	    			if(jQuery.inArray(id,deleteArr) == -1){
					    deleteArr.push(id);
					};
	    			if(deleteArr.length == length)
	    			{
	    				$selectAll.prop('checked', true);
	    			}
	    		}else
	    		{
	    			$selectAll.prop('checked', false);
	    			deleteArr = jQuery.grep(deleteArr, function(value) {
					  return value != id;
					});
	    		}
	    	});
	    	
	    	scope.btnDeleteReport =  function()
		    {
		    	if(deleteArr.length < 1)
		    	{
		    		$('.alert-delete').show();
		    	}
		    	else{
					$('.alert-delete').hide();
		    		$('#myModal').modal('show') ;	
		    	}
		    	
		    }
		    scope.deleteReportSelected = function()
		    {
		    	ReportService.delete(deleteArr.join()).success(function(response) {
						
						$('#myModal').modal('hide') ;
						$('.modal-backdrop').remove();
						//$window.location.href = '#/report_list';
						$route.reload();
		    	});
		    }
	    }, 1000);

    }
  };
});
configControllers.directive('packery', function(ReportService, $route, $location) {
  return {
    restrict: 'A',
    link : function(scope, elem, attrs)
    {
    	var pckry;
		var $container = $('.packery');
		var container = document.querySelector('.packery');
		var pckry = new Packery(container);
		$container.packery({
		        columnWidth: 1015,
		        rowHeight: 10
		    });
		$container.find('.item').each(makeEachDraggable);
		function makeEachDraggable(i, itemElem) {
		        // make element draggable with Draggabilly
		        var draggie = new Draggabilly(itemElem, {handle: ".handle"});
		        // bind Draggabilly events to Packery
		        $container.packery('bindDraggabillyEvents', draggie);
		}

		var chartItem = '<div class="item w1 h1">'+
		  				'<div class="chart-view" id="show-chart"></div>'+
				  		'<div class="option-chart">'+
				  		'<div id="reportrange" class="pull-right reportrange" style="cursor: pointer; padding: 5px 10px; position: absolute; left:15px">'+
					    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>'+
					    '<span id="show">'+sdateFrom+' - '+sdateTo+' </span><b class="caret"></b>'+
					    '</div>'+
					    '<div class="remove-edit-chart">'+
					    '<span class="glyphicon glyphicon-ok-circle apply" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-cog edit" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>'+
					    '</div>'+
						'</div>'+
				  		'</div>';
		var select = '';
		var chartItemVs = '';
		ReportService.listCate().success(function(response) {
			for(var i = 0; i < response.length; i++)
			{
				select += '<option value="'+response[i].id+'">'+response[i].title+'</option>';
			}
			chartItemVs = '<div class="item w1 h1">'+
  					'<div class="chart-view" id="show-chart"></div>'+
					'<div class="option-chart">'+
						'<div id="reportrange" class="pull-right reportrange" style="cursor: pointer; padding: 5px 10px; position: absolute; left:15px">'+
						    '<span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>'+
						    '<span id="show">'+sdateFrom+' - '+sdateTo+'</span><b class="caret"></b>'+
						'</div>'+
						'<div id="select-cate">'+
						'<select  class="select-1">'+
					      select+
					  	'</select>'+
					  	'<select  class="select-2">'+
					      select+
					  	'</select>'+
					  	'</div>'+
					  	'<div class="remove-edit-chart">'+
					    '<span class="glyphicon glyphicon-ok-circle apply" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-cog edit" aria-hidden="true"></span>'+
					    '<span class="glyphicon glyphicon-remove-sign remove" aria-hidden="true"></span>'+
					    '</div>'+
					'</div>'+
				'</div>';			
		});
					  		
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
		
		scope.insertChart =  function(type)
		{
			drawChart(type);
		}
		scope.insertChartVs =  function(type)
		{
			drawChartVs(type);
		}
		var arrChartSVG = Array();
			//Export chart
		function getAllChart()
			{
				var nameDoc = scope.form_title;

				var cd = false;
				for(var k=0; k< nameDoc.length; k++)
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
					var arrChartSVG = [];
					$(".packery > .item").each(function(){
						var str = $(this).find(".highcharts-container").html();
						arrChartSVG.push(str);
					});
					var name = scope.form_title;
					var title = scope.form_title;
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
			var insertDataChart = [];
			function getAllChartInserDatabase()
			{
				var nameDoc = scope.form_title;

				var cd = false;
				for(var k=0; k< nameDoc.length; k++)
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

					var insertDataChart = [];
					$(".packery > .item").each(function(){
						var typeChart = $(this).attr("data-chart");
				 		var dateChart = $(this).find('#reportrange span#show').html();
				 		var dateChart = dateChart.split('-');
				 		var dateFrom = dateChart[0];
				 		var dateTo = dateChart[1];
				 		var nextDay = new Date(dateTo);
				 		var dnextDay = nextDay.getDate();
				 		var mnextDay = nextDay.getMonth()+1;
				 		var ynextDay = nextDay.getFullYear();
				 		var nextDate = mnextDay + " " + dnextDay + " , " + ynextDay;
				 		var dateTo = nextDate;
				 		var item = {};
				 		item.type = typeChart;
				 		item.dateFrom = dateFrom;
				 		item.dateTo = dateTo;
				 		if(typeChart == "chart6")
				 		{
				 			var cate1 = $(this).find(".select-1").val();
			 				var cate2 = $(this).find(".select-2").val();
			 				item.cate1 = cate1;
			 				item.cate2 = cate2;
				 		}
				 		insertDataChart.push(item);
					});
					var name = scope.form_title;
					var title = scope.form_title;
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
								//alert("Lưu tài liệu thành công");
								
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
		scope.download = function()
		{
			//getAllChart();
			if(!scope.form_title)
			{
				$('#myModal').modal('show');
			}else
			{
				getAllChart();
			}
		}
		scope.save = function()
		{
			if(!scope.form_title)
			{
				$('#myModal').modal('show');
			}else
			{
				getAllChartInserDatabase();
				$location.path("/report_list");
			}
		}	
		
    }
  };
});
		// Draw chart
		function applyChart(chart)
		{
		 		$("#"+chart).find("span.apply").on("click", function(){
		 		var typeChart = $("#"+chart).attr("data-chart");
		 		var dateChart = $("#"+chart).find('#reportrange span#show').html();
		 		var dateChart = dateChart.split('-');
		 		var dateFrom = dateChart[0];
		 		var dateTo = dateChart[1];
		 		var nextDay = new Date(dateTo);
		 		var dnextDay = nextDay.getDate()+1;
		 		var mnextDay = nextDay.getMonth()+1;
		 		if(dnextDay > 31)
		 		{
		 			dnextDay = 1;
		 			mnextDay = mnextDay+1;
		 		}
		 		var ynextDay = nextDay.getFullYear();
		 		var nextDate = mnextDay + " " + dnextDay + " , " + ynextDay;
		 		var dateTo = nextDate;
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
					var currentChart = $(this).parent().parent().parent().attr("id");
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
		function removeChart()
		{
			$(".remove").on("click", function(event){
					var currentChart = $(this).parent().parent().parent().attr("id");
					$("#"+currentChart).remove();
					applyLayout();
			});
		}
		function applyLayout()
		{
			var container = document.querySelector('.packery');
		  	var pckry = new Packery(container);
			pckry.layout();
			// Scroll bottom when add chart
			$(document).scrollTop($(document).height());
		}
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
