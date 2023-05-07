<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeatureName extends Model
{
    use HasFactory;
    protected $table = 'feature_name';
    protected $guarded;
    public $timestamps = false;
}
