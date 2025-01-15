<?php

namespace App\Repositories\Teapot;

use App\Models\Teapot;

interface TeapotRepositoryInterface
{
   public function model(?string $slug = null);
   public function paginate(array $counts = [], array $relationships = [], int $perPage = 10);
   public function create(array $data);
   public function update(array $data, Teapot $teapot);
   public function delete(Teapot $teapot);
}
