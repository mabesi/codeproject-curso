<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    private $repository;
    private $projectRepository;
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service, ProjectRepository $projectRepository)
    {
      $this->repository = $repository;
      $this->projectRepository = $projectRepository;
      $this->service = $service;
    }

    public function index($id)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->findWhere(['project_id' => $id]);

        if (count($group['data'])==0) {
          return msgResourceNotFound();
        } else {
          return $group['data'];
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function store(Request $request)
    {
      $id = $request->project_id;
      if (!$this->projectRepository->checkProjectPermissions($id)){
        return msgAccessDenied();
      }

      return $this->service->create($request->all());
    }

    public function update(Request $request, $id, $taskId)
    {
      if (!$this->projectRepository->checkProjectPermissions($id)){
        return msgAccessDenied();
      }

      return $this->service->update($request->all(),$taskId);
    }

    public function show($id, $taskId)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);

        if(count($group['data'])==0){
          return msgResourceNotFound();
        }else {
          return $group['data'];
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function destroy($id, $taskId)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $taskId]);
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
