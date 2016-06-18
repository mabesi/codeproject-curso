<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $repository;
    private $service;

    public function __construct(ClientRepository $repository, ClientService $service)
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
          'message' => 'Nenhum cliente foi encontrado!'
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
          'message' => 'O cliente não foi encontrado!'
        ]);
      }
    }

    public function destroy($id)
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

        $this->repository->delete($id);
        return response()->json([
          'error' => false,
          'message' => 'O cliente foi deletado com sucesso!']);
      } catch (Exception $e) {
        return response()->json([
          'error' => true,
          'message' => 'Ocorreu um erro ao deletar o cliente!'
        ]);
      }

    }

}
