<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConditionType extends Model
{
    use HasFactory;
    protected $table = 'condition_type';
    public $timestamps = false;
    protected $guarded;
}
