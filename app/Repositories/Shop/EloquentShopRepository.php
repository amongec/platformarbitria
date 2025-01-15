<?php

namespace App\Repositories\Shop;

use App\Models\Teapot;
use Illuminate\Pagination\LengthAwarePaginator;

class EloquentShopRepository implements ShopRepositoryInterface
{

    public function paginate(int $perPage = 15): LengthAwarePaginator{
      //  return Teapot::paginate($perPage);
        return Teapot::with('category')->paginate($perPage);
        //return Teapot::query()->ray()->paginate($perPage);
    }

    public function find(int $id): Teapot{
        return Teapot::findOrFail($id);
    }


}
