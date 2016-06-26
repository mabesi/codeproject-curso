<?php

namespace CodeProject\Services;

use Exception;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectFileService
{

  /**
   * @var ProjectFileRepository
   */
  protected $repository;

  /**
   * @var ProjectFileValidator
   */
  protected $validator;

  /**
   * @var Filesystem
   */
  protected $filesystem;

  /**
   * @var Storage
   */
  protected $storage;


  public function __construct(ProjectFileRepository $repository, ProjectFileValidator $validator, Filesystem $filesystem, Storage $storage)
  {
    $this->repository = $repository;
    $this->validator = $validator;
    $this->filesystem = $filesystem;
    $this->storage = $storage;
  }

  public function create(array $data)
  {
    try {

      $this->validator->with($data)->passesOrFail();
      $projectFile = $this->repository->skipPresenter()->create($data);
      $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));

      $group = $this->repository->skipPresenter(false)->find($projectFile->id);

      return $group['data'];

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
      $group = $this->repository->find($id);

      return $group['data'];

    } catch (Exception $e) {
      return msgException($e,true);
    }
  }

  public function deleteFile($file)
  {
    return $this->storage->delete($file);
  }

}//End of class
