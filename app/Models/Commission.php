<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Commission extends Model
{
    use HasFactory;

    protected $guarded;
    public $timestamps = false;

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'vendor_id');
    }

    public function vendorNumbers(): int
    {
        return $this->users()->count('id');
    }
/////
    public function groupCategories(): HasMany
    {
        return $this->hasMany(Category::class,'id','category_id')->distinct();
    }
    public function manyUsers(): HasMany
    {
        return $this->hasMany(User::class, 'id', 'vendor_id');
    }

    public function scopeIsAllVendor($query)
    {
        return $query->where('is_all_vendor', '=' ,'true');
    }
    public function scopeFalseAllVendor($query)
    {
        return $query->where('is_all_vendor', '=' ,'false');
    }

}
