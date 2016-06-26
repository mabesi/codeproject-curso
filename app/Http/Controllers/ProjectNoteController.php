<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;
use Illuminate\Http\Request;

class ProjectNoteController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
      $this->repository = $repository;
      $this->service = $service;
    }

    public function index($id)
    {
      try {

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
      return $this->service->create($request->all());
    }

    public function update(Request $request, $id, $noteId)
    {
      return $this->service->update($request->all(),$noteId);
    }

    public function show($id, $noteId)
    {
      try {
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
