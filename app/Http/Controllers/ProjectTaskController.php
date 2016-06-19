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

        $data = $this->repository->findWhere(['project_id' => $id]);

        if (count($data) == 0) {
          return response()->json([
            'error' => true,
            'message' => 'Registro não encontrado.'
          ]);
        } else {
          return $data;
        }

      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Nenhuma tarefa foi encontrada!'
        ]);
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
        return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'A tarefa não foi encontrada!'
        ]);
      }
    }

    public function destroy($id, $taskId)
    {
      try {

        try {
          $this->repository->find($id);
        } catch (ModelNotFoundException $e){
          return [
            'error' => true,
            'message' => 'Registro não encontrado.'
          ];
        }

        $this->repository->delete($taskId);
        return response()->json([
          'error' => false,
          'message' => 'A tarefa foi deletada com sucesso!'
        ]);

      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Ocorreu um erro ao deletar a tarefa!'
        ]);
      }

    }

}
