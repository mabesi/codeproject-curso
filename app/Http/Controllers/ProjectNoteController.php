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
        return $this->repository->findWhere(['project_id' => $id]);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Nenhuma nota foi encontrada!'
        ]);
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
        return $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'A nota não foi encontrada!'
        ]);
      }
    }

    public function delete($id, $noteId)
    {
      try {
        $this->repository->delete($noteId);
        return response()->json([
          'error' => false,
          'message' => 'A nota foi deletada com sucesso!']);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Ocorreu um erro ao deletar a nota!'
        ]);
      }

    }

}
