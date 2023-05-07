<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetails extends Model
{
    use HasFactory;

    protected $table = 'inv_purchase_return_details';
    protected $guarded;
    public $timestamps = false;
}
