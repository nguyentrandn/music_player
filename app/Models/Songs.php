<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Songs extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'category_id', 'image'
    ];

    /**
     * Get the categoty that owns the song.
     */
    public function categoty()
    {
        return $this->belongsTo(Categories::class);
    }
}
