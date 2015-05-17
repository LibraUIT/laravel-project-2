'use strict';

/* App Module */

var configApp = angular.module('quannguyen', [
  'ui.router',
  'ngRoute',
  'configControllers'
]);

var configApiUrlPath = 'http://localhost/lar4/api';
var configReportUrlPath = 'http://localhost/lar4/chart';
var configApiUrlPathPdf = 'http://localhost/lar4/pdf';
var configBasePath = 'http://localhost/lar4/';
function isAdminLogin()
{
    var isAdminLogin = localStorage.getItem("isAdminLogin");
    isAdminLogin = (typeof isAdminLogin !== "undefined" && isAdminLogin !== null) ? isAdminLogin : false;
    return isAdminLogin;
}
configApp.config(['$routeProvider',
  function($routeProvider) {
    $routeProvider.
      when('/', {
        templateUrl: 'home.html',
        controller: 'BaseController'
      }).
      when('/sign', {
        templateUrl : 'templates/sign/main.html',
        controller : 'SignController'
      }).
      when('/category_list', {
        templateUrl : 'templates/category/main.html',
        controller : 'CategoryController'
      }).
      when('/category_create', {
        templateUrl : 'templates/category/create.html',
        controller : 'CategoryController'
      }).
      when('/category/:id',{
        templateUrl : 'templates/category/edit.html',
        controller : 'CategoryController'
      }).
      when('/report_list',{
        templateUrl : 'templates/report/main.html',
        controller : 'ReportController'
      }).
      when('/report_create',{
        templateUrl : 'templates/report/create.html',
        controller : 'ReportController'
      }).
      when('/report/:id',{
        templateUrl : 'templates/report/edit.html',
        controller : 'ReportController'
      }).
      otherwise({
          redirectTo: '/'
      });
  }]);
var configControllers = angular.module('configControllers', []);

configControllers.controller('BaseController', ['$scope', '$rootScope','$routeParams', '$location','$http', '$state', 'HeaderService', '$route',
  function($scope, $rootScope, $routeParams, $location, $http, $state, HeaderService, $route) {
    document.title = 'AdminLTE | Dashboard';
    if(isAdminLogin() === false)
    {
        $location.path('/sign');
    }
    HeaderService.server().success(function(res){
      $scope.hostname = res.hostname;
      $scope.disk_total = res.disk_total;
      $scope.disk_free = res.disk_free;
      $scope.timezone = res.timezone;
      $scope.category = res.category;
      $scope.report = res.report;
      $scope.users = res.users;
      $scope.questions = res.question;
      $scope.answers = res.answer;
    });
    settingLayout();
}]);
configApp.factory("LoginService", function($http) {
  return {
    login : function(sendData)
    {
      var urlConfig = [configApiUrlPath, 'login'].join('/');
      return $http({
        method: 'POST',
        url: urlConfig,
        data: $.param({ username: sendData.username, password : sendData.password }),
        headers: {'Content-Type': 'application/x-www-form-urlencoded'}
      });
    }
  }
});
configControllers.controller('SignController', ['$scope', '$rootScope','$routeParams', '$location','$http', '$state', 'LoginService', '$route', 'HeaderService',
  function($scope, $rootScope, $routeParams, $location, $http, $state, LoginService, $route, HeaderService) {
    if(isAdminLogin() === false)
    {
        document.title = 'AdminLTE | Sign in';
        $('.header-page').hide();
        $('.left-page').hide();
        $('.no-print').hide();
        $scope.Login = function()
        {
          if($scope.userID && $scope.userPass)
          {
            var sendData = {
              'username' : $scope.userID,
              'password' : $scope.userPass
            };
            LoginService.login(sendData).success(function(res){
                if(res.status == "error")
                {
                  $scope.mess_error = res.mess;
                }else
                {
                  if(res.data.permissions && res.data.permissions.admin == 1)
                  {
                      var userLogin = [res.data.id, res.data.username].join('_');
                      localStorage.setItem("isAdminLogin", userLogin );
                      //$location.path('/'); 
                      location.reload();     
                  }else
                  {
                    $scope.mess_error = 'User has not permissions .';
                  }
                }
            });
          }
        }
    }else
    {
        $location.path('/');

    }
    
    
}]);
function settingLayout()
{
    $("body").removeClass("skin-blue skin-black");
    var cls = (typeof localStorage.getItem("cls") !== "undefined" && localStorage.getItem("cls") !== null) ? localStorage.getItem("cls") : 'skin-blue';
    $("body").addClass(cls);
    $('.'+cls).attr('checked', 'checked');
}
