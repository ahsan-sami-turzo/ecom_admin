<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $guarded;
    public $timestamps = false;

    public function color(): HasMany
    {
        return $this->hasMany(ColorInfo::class,'product_id','id')->where('softDel',0);
    }
    public function weight(): HasMany
    {
        return $this->hasMany(WeightType::class,'product_id','id');
    }

    public function size(): HasMany
    {
        return $this->hasMany(SizeType::class,'product_id','id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class,'vendor_id','id');

    }

    public function getColor(): BelongsTo
    {
        return $this->belongsTo(ColorInfo::class,'product_id','id');
    }
    public function getWeight(): BelongsTo
    {
        return $this->belongsTo(WeightType::class,'product_id','id');
    }

    public function getSize(): BelongsTo
    {
        return $this->belongsTo(SizeType::class,'product_id','id');
    }

    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'productId', 'id');
    }

    public function productStockSum()
    {
        return $this->stocks()->sum('quantity');
    }

}
