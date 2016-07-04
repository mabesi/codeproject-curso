angular.module('app.services')

.service('Note',
['$resource','appConfig',
function($resource,appConfig){

  return $resource(appConfig.baseUrl + '/project/:id/note/:noteId',
      {
        id: '@id',
        noteId: '@noteId'
      },
      {
        update: {
          method: 'PUT'
        }
      }
    );

}]);
