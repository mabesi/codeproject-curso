<?php

namespace CodeProject\Services;

use Exception;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;

class ProjectService
{

  /**
   * @var ProjectRepository
   */
  protected $repository;

  /**
   * @var ProjectValidator
   */
  protected $validator;

  public function __construct(ProjectRepository $repository, ProjectValidator $validator)
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
      return msgException($e);
    }

  }

  public function update(array $data, $id)
  {
    try {

      $this->repository->find($id);
      $this->validator->with($data)->passesOrFail();
      $this->repository->update($data, $id);
      return $this->repository->find($id);

    }catch(Exception $e){
      return msgException($e);
    }
  }

  public function addMember($id,$memberId)
  {
    try{

      if (!($object = $this->repository->findWhere(['id'=>$id])->first())){
        return errorJson('O projeto não foi encontrado!');
      }elseif($this->isMember($id,$memberId)){
        return errorJson('O membro já faz parte do projeto!');
      }else{
        $object->members()->attach($memberId);
        if($this->isMember($id,$memberId)){
          return successJson('O membro foi adicionado ao projeto!');
        }else{
          return msgError();
        }
      }

    }catch(Exception $e){
      return msgException($e);
    }
  }

  public function removeMember($id,$memberId)
  {
    try{

      if (!($object = $this->repository->findWhere(['id'=>$id])->first())){
        return errorJson('O projeto não foi encontrado!');
      }elseif(!$this->isMember($id,$memberId)){
        return errorJson('O membro não faz parte do projeto!');
      }else{
        $object->members()->detach($memberId);
        if(!$this->isMember($id,$memberId)){
          return successJson('O membro foi removido do projeto!');
        }else{
          return msgError();
        }
      }

    }catch(Exception $e){
      return msgException($e);
    }
  }

  public function isMember($id,$memberId)
  {
    try {

      $object = $this->repository->find($id);

      foreach($object->members as $member){
        if($member->id == $memberId){
          return true;
        }
      }
      return false;

    } catch (Exception $e) {
      return false;
    }
  }

}// End of class
