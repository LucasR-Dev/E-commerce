<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Products extends Model
{
    use HasFactory;
    protected $table = "products";
    protected $fillable = [
        'id',
        'name',
        'price',
        'description',
        'user_id',
        'category_id',
        'image',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);

    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
