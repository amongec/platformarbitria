<?php

namespace App\Models;

use App\Http\Controllers\ReservaControler;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;
        protected $fillable = [
        'start',
        'end',
        'comments',
        'user_id',
        'title',
    ];
    
}
