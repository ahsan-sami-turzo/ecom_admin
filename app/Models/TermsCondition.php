<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TermsCondition extends Model
{
    use HasFactory;
    protected $table = 'terms_conditions';
    public $timestamps = false;
    protected $guarded;

    public function condition(): BelongsTo
    {
        return $this->belongsTo(ConditionType::class, 'condition_type_id','id');
    }
}
