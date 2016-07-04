angular.module('app.controllers')

.controller('NoteController',['$scope','$routeParams','Note',function($scope,$routeParams,Note){

  $scope.note = Note.get({id: $routeParams.id, noteId: $routeParams.noteId});

}]);
