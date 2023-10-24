<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Category;
use App\Models\Sale;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'reference',
        'price',
        'weight',
        'stock',
        'category_id'
    ];

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }

    public function sale(): BelongsTo {
        return $this->belongsTo(Sale::class);
    }
}
