angular.module('app.controllers')

.controller('NoteEditController',
['$scope','$location','$routeParams','Note',
function($scope,$location,$routeParams,Note){

  $scope.note = Note.get({id: $routeParams.id, noteId: $routeParams.noteId});

  $scope.save = function(){

    if($scope.form.$valid){
      Note.update({id: $scope.note.id, noteId: $scope.note.project_id},$scope.note,function(){
        $location.path('/project/'+$routeParams.id+'/notes');
      });
    }

  }

}]);
