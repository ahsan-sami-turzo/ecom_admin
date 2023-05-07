<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryTopNavbar extends Model
{
    use HasFactory;
    protected $table = 'category_top_navbar';
    public $timestamps = false;
    protected $guarded;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
