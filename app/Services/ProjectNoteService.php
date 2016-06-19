<?php

namespace CodeProject\Services;
use Exception;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Validators\ProjectNoteValidator;

class ProjectNoteService
{

  /**
   * @var ProjectNoteRepository
   */
  protected $repository;

  /**
   * @var ProjectNoteValidator
   */
  protected $validator;

  public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
  {
    $this->repository = $repository;
    $this->validator = $validator;
  }

  public function create(array $data)
  {

    try {

      $this->validator->with($data)->passesOrFail();
      return $this->repository->create($data);

    } catch (Exception $e) {
      return msgException($e,true);
    }

  }

  public function update(array $data, $id)
  {
    try {

      $this->repository->find($id);
      $this->validator->with($data)->passesOrFail();
      $this->repository->update($data, $id);
      return $this->repository->find($id);

    } catch (Exception $e) {
      return msgException($e,true);
    }
  }

}//End of class
