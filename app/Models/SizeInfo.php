<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SizeInfo extends Model
{
    use HasFactory;

    protected $table = 'size_infos';
    public $timestamps = false;
    protected $guarded;

    public function sizeType(): BelongsTo
    {
        return $this->belongsTo(SizeType::class);
    }
}
