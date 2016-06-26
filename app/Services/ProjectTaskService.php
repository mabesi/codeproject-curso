<?php

namespace CodeProject\Services;
use Exception;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Validators\ProjectTaskValidator;

class ProjectTaskService
{

  /**
   * @var ProjectTaskRepository
   */
  protected $repository;

  /**
   * @var ProjectTaskValidator
   */
  protected $validator;

  public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
  {
    $this->repository = $repository;
    $this->validator = $validator;
  }

  public function create(array $data)
  {

    try {

      $this->validator->with($data)->passesOrFail();
      $group = $this->repository->create($data);

      return $group['data'];

    } catch (Exception $e) {
      return msgException($e,true);
    }

  }

  public function update(array $data, $id)
  {
    try {

      $this->repository->skipPresenter()->find($id);
      $this->validator->with($data)->passesOrFail();
      $this->repository->update($data, $id);
      $group = $this->repository->find($id);

      return $group['data'];

    } catch (Exception $e) {
      return msgException($e,true);
    }
  }

}//End of class
