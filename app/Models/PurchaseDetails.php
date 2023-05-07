<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PurchaseDetails extends Model
{
    use HasFactory;
    protected $table = 'inv_purchase_details';
    protected $guarded;
    public $timestamps = false;

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'productId','id')->where('isApprove','authorize');
    }

    public function color(): BelongsTo
    {
        return $this->belongsTo(ColorInfo::class, 'colorId','id');
    }
    public function size(): BelongsTo
    {
        return $this->belongsTo(SizeType::class, 'sizeId','id');
    }
    public function weight(): BelongsTo
    {
        return $this->belongsTo(WeightType::class, 'weight_id','id');
    }
}
