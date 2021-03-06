<?php

namespace App\Repositories\Eloquents;

use App\Models\JobType;
use App\Repositories\Interfaces\JobTypeRepository;
use Cache;

class DbJobTypeRepository extends DbBaseRepository implements JobTypeRepository
{
    protected $model;

    /**
     * @param JobType $model
     *
     */
    function __construct(JobType $model)
    {
        $this->model = $model;
    }

    public function getAll($per)
    {
        return $this->basePaginateList($per);
    }

    public function get($key, $value)
    {
        return $this->baseFindBy($key, $value);
    }

    public function delete($key, $value)
    {
        return $this->baseDestroy($key, $value);
    }

    public function getAllWithOutPaginate()
    {
        $jobTypes  = Cache::rememberForever('getJobType', function () {
            return $this->model::pluck('name', 'id');
        });

        return $jobTypes;
    }

    public function getNameById($id)
    {
        $jobTypes = $this->getAllWithOutPaginate();

        return $jobTypes[$id];
    }

    public function create($param)
    {
        return $this->baseCreate($param);
    }

    public function update($data, $key, $value)
    {
        return $this->baseUpdate($data, $key, $value);
    }

    public function searchJobTypeByName($keyword)
    {
        $listJobType = [];
        $jobTypes = $this->model->where('name', 'like', '%' . $keyword .'%')->get(['id']);
        if ($jobTypes) {
            foreach ($jobTypes as $jobType) {
                $listJobType[] = $jobType->id;
            }
        }

        return $listJobType;
    }
}
