<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{
    private $repository;
    private $projectRepository;
    private $service;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service, ProjectRepository $projectRepository)
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
          return $group;
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function store(Request $request, $id)
    {
      if (!$this->projectRepository->checkProjectPermissions($id)){
        return msgAccessDenied();
      }

      $data['project_id'] = $id;
      $data['file'] = $request->file('file');
      $data['name'] = $request->name;
      $data['description'] = $request->description;

      return $this->service->create($data);
    }

    public function update(Request $request, $id, $fileId)
    {
      if (!$this->projectRepository->checkProjectPermissions($id)){
        return msgAccessDenied();
      }

      return $this->service->update($request->all(),$fileId);
    }

    public function show($id, $fileId)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $fileId]);

        if (count($group['data'])==0) {
          return msgResourceNotFound();
        } else {
          return $group;
        }
      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function destroy($id, $fileId)
    {
      try {

        if (!$this->projectRepository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $fileId]);

        if($group->isEmpty()){
          return msgResourceNotFound();
        }else{
          $object = $group->first();
          if ($this->service->deleteFile($object->id.'.'.$object->extension)){
            $object->delete();
            return msgDeleted();
          } else {
            return msgNotDeleted();
          }
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

}
