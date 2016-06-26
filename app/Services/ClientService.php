<?php

namespace CodeProject\Services;
use Exception;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ClientValidator;

class ClientService
{

  /**
   * @var ClientRepository
   */
  protected $repository;

  /**
   * @var ClientValidator
   */
  protected $validator;

  public function __construct(ClientRepository $repository, ClientValidator $validator)
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

}
