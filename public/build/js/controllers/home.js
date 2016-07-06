angular.module('app.controllers')

.controller('HomeController',
['$scope','$cookies',
function($scope,$cookies){

  $scope.user = $cookies.getObject('user');
  
}]);
