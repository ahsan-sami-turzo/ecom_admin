<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VendorDiscountCampaign extends Model
{
    use HasFactory;
    protected $table = 'vendor_discount_campaign';
    protected $guarded;
    public $timestamps = false;

    public function discountCampaign(): BelongsTo
    {
        return $this->belongsTo(DiscountCampaign::class, 'campaign_id', 'id');
    }

    public function ven()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'vendor_id');
    }
}
