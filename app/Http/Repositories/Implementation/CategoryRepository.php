<?php

namespace App\Http\Repositories\Implementation;

use App\Http\Repositories\CategoryRepositoryInterface;
use App\Models\Category;

class CategoryRepository extends BasicRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function getBySomething($id) {
        return $this->model->where("id", $id)->get();
    }
}
