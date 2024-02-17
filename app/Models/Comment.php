<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'rating',
        'comment',
        'user_id',
        'company_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comapany(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }


    // public function scopeName(Builder $query, string $name): Builder
    // {
    //     return $query->where('name', 'LIKE', '%' . $name . '%');
    // }
}
