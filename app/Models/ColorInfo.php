<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ColorInfo extends Model
{
    use HasFactory;

    protected $table = 'color_infos';
    public $timestamps = false;
    protected $guarded;

    public function colorImage(): HasMany
    {
        return $this->hasMany(ColorImage::class, 'color_id', 'id');
    }
}
