<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ClientRepository;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    private $repository;

    public function __construct(ClientRepository $repository)
    {
      $this->repository = $repository;
    }

    public function index()
    {
      return $this->repository->all();
    }

    public function store(Request $request)
    {
      return $this->repository->create($request->all());
    }

    public function update(Request $request, $id)
    {
      Client::find($id)->update($request->all());
    }

    public function show($id)
    {
      return Client::find($id);
    }

    public function delete($id)
    {
      Client::find($id)->delete();
    }

}
