<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    use HasFactory;
    protected $table = 'inv_purchase';
    protected $guarded;
    public $timestamps = false;

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'supplierId', 'id');
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetails::class,'purchaseId','id')->orderBy('id','desc');
    }




}
