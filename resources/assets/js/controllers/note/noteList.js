angular.module('app.controllers')

.controller('NoteListController',['$scope','$routeParams','Note',function($scope,$routeParams,Note){

  $scope.project = $routeParams.id;
  $scope.notes = Note.query({id: $routeParams.id});

}]);
