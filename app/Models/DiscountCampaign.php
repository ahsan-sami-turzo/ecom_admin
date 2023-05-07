<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCampaign extends Model
{
    use HasFactory;
    protected $table = 'discount_campaigns';
    protected $guarded;
    public $timestamps = false;
}
