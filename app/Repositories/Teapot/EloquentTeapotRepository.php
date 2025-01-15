<?php

namespace App\Repositories\Teapot;

use App\Models\Teapot;
use App\Traits\CRUDOperations;

class EloquentTeapotRepository implements TeapotRepositoryInterface{

    use CRUDOperations;

    protected string $model = Teapot::class;
    
}