<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    protected $table = 'banner';
    public $timestamps = false;
    protected $guarded;
    protected $casts = [
        'effective_from' => 'datetime:d-m-Y',
        'effective_to' => 'datetime:d-m-Y',
    ];
}
