<?php

namespace App\Models;

use App\Http\Controller\ClusterLikeController;
use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cluster extends Model
{
    use HasFactory;

      protected $guarded = ['id', 'created_at', 'updated_at'];
    //protected $with = ['category', 'author'];
    //protected $with = ['likes'];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, fn($query, $search) =>
            $query->where(fn($query) =>
                $query->where('title', 'like', '%' . $search . '%')
                    ->orWhere('excerpt', 'like', '%' . $search . '%')
            )
        );

        $query->when($filters['category'] ?? false, fn($query, $category) =>
            $query->whereHas('category', fn ($query) =>
                $query->where('slug', $category)
            )
        );

        $query->when($filters['author'] ?? false, fn($query, $author) =>
            $query->whereHas('author', fn ($query) =>
                $query->where('username', $author)
            )
        );
    }

    public function user(){
        return $this->belongsTo(User::class);
   }

    public function likes() {
        return $this->belongsToMany(User::class, 'cluster_like')->withTimestamps();
    }

   // public function comments()
   // {
   //     return $this->hasMany(Comment::class);
   // }

    public function image(){
     return $this->morphOne(Image::class, 'imageable');
   }

    public function imageUrl():Atribute{
      return Attribute::make(
        get: fn() => UploadService::url($this->image),
      );
   }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'cluster_id');
    }

}
