<?php

namespace CodeProject\Repositories;

use Exception;
use CodeProject\Presenters\ProjectPresenter;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Entities\Project;

/**
 * Class ProjectRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Project::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
      return ProjectPresenter::class;
    }

    public function myProjectList()
    {
        $userId = userId();

        $data = $this->scopeQuery(function ($query) use ($userId) {
                    return $query->select('projects.*')
                        ->leftJoin('project_members', 'project_members.project_id', '=', 'projects.id')
                        ->where('project_members.user_id', '=', $userId)
                        ->union($this->model->query()->getQuery()->where('owner_id', '=', $userId));
                })->all();

        return $data;
    }

    public function isMember($id,$memberId)
    {
      try {

        $object = $this->skipPresenter()->find($id);

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

    public function isOwner($id,$ownerId)
    {
      try {

        $object = $this->skipPresenter()->find($id);
        $owner = $object->owner;

        if($owner->id == $ownerId){
          return true;
        }

        return false;

      } catch (Exception $e) {
        return false;
      }
    }

    public function checkProjectMember($id)
    {
      $memberId = userId();
      return $this->isMember($id,$memberId);
    }

    public function checkProjectOwner($id)
    {
      $ownerId = userId();
      return $this->isOwner($id,$ownerId);
    }

    public function checkProjectPermissions($id)
    {
      return $this->checkProjectOwner($id) || $this->checkProjectMember($id);
    }

}
