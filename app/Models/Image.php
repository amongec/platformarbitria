<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    //protected $fillable = ['url'];
    //protected $guarded = [];
    //protected $with = ['files', 'images'];
    
    
    
    
    
    //protected $table = 'images';

   //protected $fillable = [
    //   'url',
    //   'imageable_id'
   //];

    public function imageable(){
        return $this->morphTo();
    }
   // public function image()
   // {
    //    return $this->belongsTo('App\Models\Image', 'url');
   //}
}
