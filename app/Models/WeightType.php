<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeightType extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'weight_type';
    protected $guarded;
}
