<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Net;
use App\Models\Type;

class TypeController extends Controller
{

    public function nets(Type $type){
        return $type->users()->get([
            'users.id',
            'users.name'
        ]);
    }
}