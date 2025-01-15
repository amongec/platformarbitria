<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductModel extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'price', 'description', 'created_at', 'updated_at'];

    protected $table = 'broduct';

}
