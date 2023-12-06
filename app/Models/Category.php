<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'slug' // Acessar com uma url amigável.
    ];

    public function products(): HasMany
    {
        return $this->hasMany(products::class);
    }
}
