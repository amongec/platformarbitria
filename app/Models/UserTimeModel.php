<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTimeModel extends Model
{
    use HasFactory;
        protected $table = 'user_time';

        static public function getDetail($weekid){
return self::where('week_id', '=', $weekid)->where('user_id', '=', Auth::user()->id)->first();
        }
}