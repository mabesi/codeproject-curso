<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
      $this->repository = $repository;
      $this->service = $service;
    }

    public function index($id)
    {
      try {

        $group = $this->repository->findWhere(['project_id' => $id]);

        if ($group->isEmpty()) {
          return msgResourceNotFound();
        } else {
          return $group;
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function store(Request $request)
    {
      return $this->service->create($request->all());
    }

    public function update(Request $request, $id, $taskId)
    {
      return $this->service->update($request->all(),$taskId);
    }

    public function show($id, $taskId)
    {
      try {

        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);

        if($group->isEmpty()){
          return msgResourceNotFound();
        }else {
          return $group;
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function destroy($id, $taskId)
    {
      try {

        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
        if($group->isEmpty()){
          return msgResourceNotFound();
        }else{
          $object = $group->first();
          $object->delete();
          return msgDeleted();
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

}//End of class
