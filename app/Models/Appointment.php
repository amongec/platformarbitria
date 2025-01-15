<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;
        protected $fillable = [
            'zipcode',
            'address_select_service',
            'city_select_service',
            'country_select_service',
            'scheduled_date',
            'scheduled_time',
            'type_id'
    ];
    //public function types(){
     //   return $this->belongsTo(Types::class);
    //}
    
}
