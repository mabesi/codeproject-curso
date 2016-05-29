<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;

use CodeProject\Entities\Client;

class ClientController extends Controller
{
    public function index()
    {
      return Client::all();
    }

    public function store(Request $request)
    {
      return Client::create($request->all());
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
