<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Services\UploadService;
use Illuminate\Support\Facades\URL;

class Post extends Model
{
  protected $table = 'posts';
  protected $guarded = ['id', 'created_at', 'updated_at'];

  public function setNameAttribute($name){
    $this->attributes['name'] = $name;

    $this->slug = $this->makeSlug();
  }
    
  public function makeSlug(): string {

    $slug = Str::slug($this->name);

        $index = 2;

    while (Post::whereSlug($slug)->exists()){
      $slug = Str::slug($this->name.'-'.$index++);
    
    }
    return $slug;
  }

  public function user(){
    return $this->belongsTo(User::class);
   }
   
  public function category(){
     return $this->belongsTo(Category::class);
   }

  public function image(){
     return $this->morphOne(Image::class, 'imageable');
   }

 // public function imageUrl():Attribute{
   //   return Attribute::make(
   //     get: fn() => UploadService::url($this->image),
   //   );
   //}

  public function comments()
  {
      return $this->hasMany(Comment::class);
  }

  public function author()
  {
    return $this->belongsTo(User::class, 'post_id');
  }

  public function casts():array{
    return[
      'published_at' => 'datatime',
    ];
  }
}