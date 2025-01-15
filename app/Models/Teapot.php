<?php

namespace App\Models;

use App\Traits\WithCurrencyFormatter;
use App\Traits\HasSlug;
use App\Services\UploadService;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
//use NumberFormatter;

class Teapot extends Model
{
    use HasFactory;
    use HasSlug;
    use WithCurrencyFormatter;

    protected $fillable = [
        'name',
        'slug',
        'price',
        'description',
        'category_id',
        'stock',
    ];

    protected function casts(): array {
        return [
            'price' => 'decimal:2',
            'stock' => 'integer'
        ];
    }
 

    public function getRouteKeyName()
    {
      return "slug";
    }

    public function category(): BelongsTo{
        return $this->belongsTo(Category::class);
    }

   // public function imageUrl(): Attribute {
   //   return Attribute::make(
   //     get: fn() => UploadService::url($this->image),
   //   );
   //}

   public function formattedPrice(): Attribute{
    //$formatter = new NumberFormatter('es_ES', NumberFormatter::CURRENCY);
      return Attribute::make(
        get: fn () => $this->formatCurrency($this->price),
    );
   }
}