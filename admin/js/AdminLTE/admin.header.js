'use strict';
configApp.factory("HeaderService", function($http) {
  return {
    user : function(sendData)
    {
      var urlConfig = [configApiUrlPath, 'user'].join('/');
      return $http({
        method: 'POST',
        url: urlConfig,
        data: $.param({ id : sendData}),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      });
    },
    server : function()
    {
      var urlConfig = [configApiUrlPath, 'server'].join('/');
      return $http.get(urlConfig);
    }
  }
});
configControllers.controller('headerController', ['$scope', '$rootScope','$routeParams', '$location','$http', '$state', 'HeaderService', '$timeout',
  function($scope, $rootScope, $routeParams, $location, $http, $state, HeaderService, $timeout) {
  	if(isAdminLogin() !== false)
    {
	  	 var loginInfo = isAdminLogin().split('_');
	  	 var loginInfoID = parseInt(loginInfo[0]);
	  	 var loginInfoUser = loginInfo[1];
	  	 HeaderService.user(loginInfoID).success(function(res){
	  	 	$scope.userLoginName = res.first_name + ' ' + res.last_name;
	  	 	$scope.userLoginAvatar = [configBasePath, res.avatar].join('/');
	  	 	var created_at = new Date(res.created_at);
	  	 	var d_created_at = created_at.getDate();
	  	 	var months = ["Jan", "Feb", "Mar", "Apr", "May",
			 "Jun", "Jul", "Aug", "Sep", "Oct",
			 "Nov", "Dec"];
			var m_created_at = months[created_at.getMonth()];
			var y_created_at = created_at.getFullYear();
			$scope.userLoginCreatedAt =  m_created_at+' . ' + y_created_at;
			$scope.userLoginStatus = res.status;
	  	 });
	     $scope.SignOut = function()
	     {
	     	localStorage.removeItem("isAdminLogin");
            $location.path('/sign');	
	     }
 	}
}]);