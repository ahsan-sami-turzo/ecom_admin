<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PurchaseReturn extends Model
{
    use HasFactory;
    protected $table = 'inv_purchase_return';
    protected $guarded;
    public $timestamps = false;

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(Purchase::class, 'purchase_id','id');
    }
}
