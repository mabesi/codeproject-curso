angular.module('app.controllers')

.controller('NoteRemoveController',
['$scope','$location','$routeParams','Note',
function($scope,$location,$routeParams,Note){

  $scope.note = Note.get({id: $routeParams.id, noteId: $routeParams.noteId});

  $scope.remove = function(){

    $scope.note.$delete({id: $routeParams.id, noteId: $routeParams.noteId}).then(function(){
      $location.path('/project/'+$routeParams.id+'/notes');
    });

  }

}]);
