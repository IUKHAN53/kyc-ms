<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    protected $fillable = [
        'name',
        'image',
        'conversion_value',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function getImageUrlAttribute()
    {
        return $this->image
            ? asset('storage/'.$this->image)
            : asset('assets/img/Logo-Bet.jpg'); // fallback image
    }
}
