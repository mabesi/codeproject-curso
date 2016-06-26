<?php

namespace CodeProject\Repositories;

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

}
