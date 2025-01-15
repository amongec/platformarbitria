<?php
namespace App\Models;


use App\Traits\HasSlug;
use App\Services\UploadService;
use App\Models\Post;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;

class Category extends Model
{
	use HasFactory; 
  use HasSlug;
	
	protected $fillable = ['name', 'slug', 'description'];

    public function getRouteKeyName()
    {
      return "slug";
    }
    
    public function posts(){
      return $this->hasMany(Post::class);
    }
    
    public function clusters()
      {
        return $this->hasMany(Cluster::class);
    }

    public function teapots(): HasMany{
      return $this->hasMany(related: Teapot::class);
    }

    public function imageUrl(): Attribute{
      return Attribute::make(
        get: fn () => UploadService::url($this->image),
      );
    }
}