<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class JobType extends Model
{
    protected $table = 'job_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
    ];

    public function jobTypeJobs()
    {
        return $this->hasMany('\App\Models\Job', 'job_type_id', 'id');
    }
}
