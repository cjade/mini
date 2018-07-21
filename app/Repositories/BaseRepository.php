<?php
/**
 * Created by PhpStorm.
 * User: haibao
 * Date: 2018/7/20
 * Time: 下午3:46
 */

namespace App\Repositories;


use Illuminate\Database\Eloquent\Model;

class BaseRepository
{
    protected $model;

    public function __construct (Model $model)
    {
        $this->model = $model;
    }

    public function getById ($id, array $columns = ['*'])
    {
        return $this->model->find($id, $columns);
    }

    public function queryByAttributes (array $attributes = null, $sortBy = null)
    {
        $query = $this->model->when($attributes, function ($query) use ($attributes) {
            return $query->where($attributes);
        })->when($sortBy, function ($query) use ($sortBy) {
            return $query->orderBy($sortBy[0], $sortBy[1]);
        }, function ($query) {
            return $query->orderBy('created_at', 'DESC');
        })->get();
        return $query;
    }

}
