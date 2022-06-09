<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository
{
    /**
     * @var Model
     */
    protected Model $model;

    /**
    * AbstractRepository constructor.
     *
    * @param Model $model
    */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return Model
     */
    protected function getModel(): Model
    {
        return $this->model;
    }

    public function findBy(array $conditions, array $fields = ['*'])
    {
        $model = $this->getModel();

        foreach ($conditions as $field => $value) {
            $model = $model->where($field, '=', $value);
        }

        return $model->get($fields);
    }
}
