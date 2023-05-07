<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnityOfMeasurement extends Model
{
    use HasFactory;
    protected $table = 'unit_of_measurement';
    protected $guarded;
    public $timestamps = false;
}
