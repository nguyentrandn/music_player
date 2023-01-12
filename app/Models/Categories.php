<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'color',
    ];

    /**
     * Get the Songs for the category.
     */
    public function songs()
    {
        return $this->hasMany(Songs::class);
    }
}
