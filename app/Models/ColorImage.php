<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ColorImage extends Model
{
    use HasFactory;
    protected $table = 'color_images';
    public $timestamps = false;
    protected $guarded;
}
