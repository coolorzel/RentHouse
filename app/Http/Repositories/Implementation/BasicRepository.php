<?php

namespace App\Http\Repositories\Implementation;

use App\Http\Repositories\BasicRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BasicRepository implements BasicRepositoryInterface
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function create($data) {
        return $this->model->create($data);
    }
}
