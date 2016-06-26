<?php

namespace CodeProject\Http\Controllers;

use Exception;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
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

        $group = $this->repository->all();
        if(count($group['data'])==0){
          return msgResourceNotFound();
        }
        return $group['data'];

      } catch (Exception $e) {
        return msgResourceNotFound();
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
        $group = $this->repository->find($id);
        if(count($group['data'])==0){
          return msgResourceNotFound();
        }
        return $group['data'];
      } catch (Exception $e) {
        return msgResourceNotFound();
      }
    }

    public function destroy($id)
    {
      try {

        $object = $this->repository->skipPresenter()->find($id);
        $object->delete();
        return msgDeleted();

      } catch (Exception $e) {
        return msgException($e);
      }

    }

}
