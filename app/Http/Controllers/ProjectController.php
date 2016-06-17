<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
      $this->repository = $repository;
      $this->service = $service;
    }

    public function index()
    {
      try {
        return $this->repository->all();
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Nenhum projeto foi encontrado!'
        ]);
      }
    }

    public function store(Request $request)
    {
      return $this->service->create($request->all());
    }

    public function update(Request $request, $id)
    {
      return $this->service->update($request->all(),$id);
    }

    public function show($id)
    {
      try {
        return $this->repository->find($id);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'O projeto não foi encontrado!'
        ]);
      }
    }

    public function delete($id)
    {
      try {
        $this->repository->delete($id);
        return response()->json([
          'error' => false,
          'message' => 'O projeto foi deletado com sucesso!']);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Ocorreu um erro ao deletar o projeto!'
        ]);
      }

    }

}
