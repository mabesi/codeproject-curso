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

        $group = $this->repository->myProjectList();
        if (count($group['data'])==0) {
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
      if (!$this->repository->checkProjectPermissions($id)){
        return msgAccessDenied();
      }

      return $this->service->update($request->all(),$id);
    }

    public function show($id)
    {
      try {

        if (!$this->repository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $group = $this->repository->with(['owner','client','members'])->skipPresenter(false)->find($id);

        if (count($group['data'])==0) {
          return msgResourceNotFound();
        }
        return $group['data'];

      } catch (Exception $e) {
        return msgResourceNotFound();
      }
    }

    public function showMembers($id)
    {
      try {

        if (!$this->repository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $data = $this->repository->skipPresenter()->find($id);

        if($data->members->isEmpty()){
          return msgResourceNotFound();
        }
        return $data->members;

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function showMember($id,$memberId)
    {
      try {

        if (!$this->repository->checkProjectPermissions($id)){
          return msgAccessDenied();
        }

        $data = $this->repository->skipPresenter()->find($id);

        foreach ($data->members as $member) {
          if ($member->id == $memberId){
            return $member;
          }
        }
        return msgResourceNotFound();

      } catch (Exception $e) {
        return msgException($e);
      }
    }

    public function addMember($id,$memberId)
    {
      if (!$this->repository->checkProjectOwner($id)){
        return msgAccessDenied();
      }

      return $this->service->addMember($id,$memberId);
    }

    public function removeMember($id,$memberId)
    {
      if (!$this->repository->checkProjectOwner($id)){
        return msgAccessDenied();
      }

      return $this->service->removeMember($id,$memberId);
    }

    public function destroy($id)
    {
      try {

        if (!$this->repository->checkProjectOwner($id)){
          return msgAccessDenied();
        }

        $object = $this->repository->skipPresenter()->find($id);
        $object->delete();
        return msgDeleted();

      } catch (Exception $e) {
        return msgException($e);
      }

    }

} // End of class
