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

        $data = $this->repository->findWhere(['project_id' => $id]);

        if ($data->isEmpty()) {
          return msgResourceNotFound();
        } else {
          return $data;
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
        $data = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);

        if ($data->isEmpty()) {
          return msgResourceNotFound();
        } else {
          return $data;
        }
      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function destroy($id, $noteId)
    {
      try {

        if($data = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId])->first()){
          if($data->delete()){
            return msgDeleted();
          }else{
            return msgNotDeleted();
          }
        }else{
          return msgResourceNotFound();
        }

      } catch (Exception $e) {
        return msgException($e);
      }
    }

}
