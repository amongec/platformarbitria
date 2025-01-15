<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Net extends Model
{
    use HasFactory;

    protected $guarded = ["id", "created_at", "updated_at"];
    //protected $with = ['category', 'author'];
    //protected $with = ['likes'];

    public function scopeFilter($query, array $filters)
    {
        $query->when(
            $filters["search"] ?? false,
            fn($query, $search) => $query->where(
                fn($query) => $query
                    ->where("name", "LIKE", "%" . $this->search . "%")
                    ->where("phone", "LIKE", "%" . $this->search . "%")
                    ->where("zipcode", "LIKE", "%" . $this->search . "%")
                    ->where("city", "LIKE", "%" . $this->search . "%")
                    ->where("country", "LIKE", "%" . $this->search . "%")
                    ->where("status", "LIKE", "%" . $this->search . "%")
            )
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function comments()
    // {
    //     return $this->hasMany(Comment::class);
    // }

}