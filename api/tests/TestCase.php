<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected $model;

    public function dataFaker($type, $model, int $amoutOfFaker = null, array $attributes = [])
    {
        $this->model = $this->resolveModel($model);
        if ($type == 'create') {
            return $this->model->factory($amoutOfFaker)->create($attributes);
        }else{
            return $this->model->factory($amoutOfFaker)->make($attributes);
        }
    }

    protected function resolveModel($model)
    {
        return app($model);
    }
}
