<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
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

    public function store(Request $request, $id)
    {
      $data['project_id'] = $id;
      $data['file'] = $request->file('file');
      $data['extension'] = $data['file']->getClientOriginalExtension();
      $data['name'] = $request->name;
      $data['description'] = $request->description;

      return $this->service->create($data);
    }

    public function update(Request $request, $id, $fileId)
    {
      return $this->service->update($request->all(),$fileId);
    }

    public function show($id, $fileId)
    {
      try {
        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $fileId]);

        if ($group->isEmpty()) {
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

        $group = $this->repository->findWhere(['project_id' => $id, 'id' => $fileId]);

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
