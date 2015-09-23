'use strict';
 var dataTable;
configApp.factory("CategoryService", function($http) {
  return {
    list : function()
    {
    	var urlConfig = [configApiUrlPath, 'categorie_list'].join('/'); 
    	return $http.get(urlConfig);
    },
    delete :  function(sendData)
    {
    	var urlConfig = [configApiUrlPath, 'categorie_delete'].join('/');
    	return $http({
		    method: 'POST',
		    url: urlConfig,
		    data: $.param({data:sendData }),
		    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		}); 
    },
    create : function(sendData)
    {
    	var urlConfig = [configApiUrlPath, 'categorie_create'].join('/');
    	return $http({
		    method: 'POST',
		    url: urlConfig,
		    data: $.param({data: sendData }),
		    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
    },
    loadEdit :  function(sendData)
    {
    	var urlConfig = [configApiUrlPath, 'categorie_edit'].join('/');
    	return $http({
		    method: 'POST',
		    url: urlConfig,
		    data: $.param({data: sendData }),
		    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
    },
    actEdit :  function(sendData)
    {
    	var urlConfig = [configApiUrlPath, 'categorie_act_edit'].join('/');
    	return $http({
		    method: 'POST',
		    url: urlConfig,
		    data: $.param({data: sendData }),
		    headers: {'Content-Type': 'application/x-www-form-urlencoded'}
		});
    }
  };
});
configControllers.controller('CategoryController', ['$scope', '$rootScope', '$route','$routeParams', '$location','$http', '$state', 'CategoryService',
  function($scope, $rootScope, $route ,$routeParams, $location, $http, $state, CategoryService) {
    document.title = 'AdminLTE | Category Management';
    if(isAdminLogin() === false)
    {
      	$location.path('/sign');
    }
    $('.alert-delete').hide();
    $('.alert-create').hide();
    $('.alert-create-erorr').hide();
    $scope.btnCancle = function()
	{
	   	$location.path("/category_list");
	}
    $scope.btnCreateCategory = function()
		    {
		    	if($scope.form_title)
		    	{
					$('.alert-create').hide();
					CategoryService.create($scope.form_title).success(function(response) {
						if(response.status == "success")
						{
							$('.alert-create-erorr').hide();
							$location.path("/category_list");	
						}else
						{
							$('.alert-create-erorr').show();	
						}
					});
		    	}else
		    	{
		    		$('.alert-create').show();	
		    	}
		    }
}]);
configControllers.directive('datatableCategory', function(CategoryService) {
  return {
    restrict: 'A',
    link : function(scope, elem, attrs)
    {
    	CategoryService.list().success(function(response) {
    		scope.CategoryList = response;
    	});
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
configControllers.directive('selectAll', function(CategoryService, $state, $route, $location) {
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
	    	scope.btnDeleteCate =  function()
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
		    scope.deleteSelected = function()
		    {
		    	CategoryService.delete(deleteArr.join()).success(function(response) {
						$('.modal-backdrop').remove();
						$('#myModal').modal('hide') ;
						$route.reload();
		    	});
		    }
	    }, 1000);

    }
  };
});
configControllers.directive('editCategory', function(CategoryService, $routeParams, $route, $location) {
  return {
    	restrict: 'A',
	    link : function(scope, elem, attrs)
	    {
	    	var cateId = $routeParams.id;
	    	CategoryService.loadEdit(cateId).success(function(response) {
	    		if(response && response.id == cateId)
	    		{
	    			scope.form_title = response.title;
	    		}
	    	});
	    	$('.alert-update').hide();
	    	$('.alert-update-erorr').hide();
	    	scope.btnUpdateCategory =  function()
	    	{
	    		if(scope.form_title)
	    		{
	    			$('.alert-update').hide();
	    			var sendData =  [ cateId ,scope.form_title].join('_');
	    			CategoryService.actEdit(sendData).success(function(response){
	    				if(response.status == "success")
	    				{
	    					$('.alert-update-erorr').hide();
	    					$route.reload();
	    				}else
	    				{
	    					$('.alert-update-erorr').show();
	    				}
	    			});
	    		}else
	    		{
	    			$('.alert-update').show();
	    		}
	    	}
	    	
	    }
    }
});


