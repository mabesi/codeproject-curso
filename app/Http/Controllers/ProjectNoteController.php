<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;

class ProjectNoteController extends Controller
{
    private $repository;
    private $projectRepository;
    private $service;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectRepository $projectRepository)
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

    public function update(Request $request, $id, $noteId)
    {
      if (!$this->projectRepository->checkProjectPermissions($id)){
        return msgAccessDenied();
      }
      return $this->service->update($request->all(),$noteId);
    }

    public function show($id, $noteId)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);

        if (count($group['data'])==0) {
          return msgResourceNotFound();
        } else {
          return $group['data'];
        }
      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function destroy($id, $noteId)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $noteId]);

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

}
