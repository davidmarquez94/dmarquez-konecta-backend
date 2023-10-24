<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Employee;
use App\Models\Product;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'employee_id',
        'product_id',
        'quantity'
    ];

    public function employee(): BelongsTo {
        return $this->belongsTo(Employee::class);
    }

    public function product(): HasOne {
        return $this->hasOne(Product::class);
    }
}
