<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Sale;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email'
    ];

    public function sales(): HasMany {
        return $this->hasMany(Sale::class);
    }
}
