<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $table = 'category';
    protected $guarded;
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    public $timestamps = false;

    public function parentCategory(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_category_id', 'id');
    }
    public function scopeParentIdZero($query)
    {
        $query->where('parent_category_id', 0);
    }
    public function scopeStatus($query)
    {
        $query->where('status', 'active');
    }

    public function productSpecificationDetails(): HasMany
    {
        return $this->hasMany(ProductSpecificationDetails::class,'category_id','id');
    }

    public function commissions()
    {
        return $this->hasMany(Commission::class,'category_id','id');
    }
    public function vendorNumbers(): int
    {
        return $this->commissions()->count('vendor_id');
    }
    public function cateName(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_category_id', 'id');
    }
    public function commissionVendor(): BelongsTo
    {
        return $this->belongsTo(Commission::class,'id','category_id');
    }

}
