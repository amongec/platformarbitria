<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'role',
        'phone_number',
        'country_code'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }



    //public function scopeActive($query): void
      //{
      //    $query->where('is_active', 1);
      //} 

    public function posts(){
        return $this->hasMany(Post::class);
    }

    public function followings() {
        return $this->belongsToMany(Cluster::class, 'follower_user', 'user_id', 'cluster_id')->withTimestamps();
    }

    public function followers() {
         return $this->belongsToMany(Cluster::class, 'follower_user', 'user_id', 'cluster_id')->withTimestamps();
    }

    public function follows(Cluster $cluster) {
         return $this->followings()->where('cluster_id', $cluster->id)->exists();
    }

    public function likes() {
        return $this->belongsToMany(Cluster::class, 'cluster_like')->withTimestamps();
    }

    public function likesCluster(Cluster $cluster) {
        return $this->likes()->where('cluster_id', $cluster->id)->exists();
    }

    public function videos(){
        return $this->hasMany(Video::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function image(){
        return $this->morphOne(Image::class, 'imageable');
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    //public function types(){
     //    return $this->belongsToMany(Type::class)->withTimestamps();
     //}

     //public function nets(){
      //   return $this->belongsToMany(Net::class)->withTimestamps();
     //}

    public function clusters(){
        return $this->belongsToMany(Cluster::class)->withTimestamps();
    }

    //public function scopeGamers($query){
    //    return $query->where('role', 'gamer');
    //}

    //public function scopeNets($query){
    //    return $query->where('role', 'net');
    //}

   //  public function password():Attribute {
   //      return Attribute::set(
   //          fn($value) => bcrypt($value)
    //     );
    //    }

    // public function fullName(): Attribute
    // {
    //  return new Attribute(
    //    get: fn($value, $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
    //    set: function ($value){
    //      [$first, $last] = explode('', $value);
      //    return[
     //         'first_name' => $first,
     //         'last_name' => $last
     //     ];
     //   }
     // );
   //  }
    
}
