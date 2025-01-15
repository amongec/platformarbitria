<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Traits\CRUDOperations;
use Exception;

class EloquentCategoryRepository implements CategoryRepositoryInterface {

    use CRUDOperations;

    protected string $model = Category::class;

    protected function deleteChecks(Category $category): void{
        if ($category->teapots()->exists()){
            throw new Exception('The category cannot be deleted because it has teapots associated with it.');
        }
    }
}

