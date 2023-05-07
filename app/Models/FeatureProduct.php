<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeatureProduct extends Model
{
    protected $table = 'feature_products';
    protected $guarded;
    public $timestamps = false;

    public function featureName(): BelongsTo
    {
        return $this->belongsTo(FeatureName::class, 'feature_id','id');
    }

    /*public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'product_id','id');
    }*/


}
