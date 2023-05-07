<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vendor extends Model
{
    use HasFactory;

    protected $table = 'vendor_details';
    protected $guarded;
    public $timestamps = false;
    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'updated_date';
    protected $casts = [
        'product_category' => 'array'
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class,'vendor_id','vendor_id');
    }


}
