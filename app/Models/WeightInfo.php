<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WeightInfo extends Model
{
    use HasFactory;

    protected $table = 'weight_infos';
    public $timestamps = false;
    protected $guarded;

    public function weightType(): BelongsTo
    {
        return $this->belongsTo(WeightType::class);
    }
}
