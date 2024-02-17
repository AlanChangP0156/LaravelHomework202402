<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'phone_number',
        'principal'
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function averageRating()
    {
        return $this->comments()->avg('rating');
    }

    public function countComment()
    {
        return $this->comments()->count('rating');
    }

    public function scopeName(Builder $query, string $name): Builder
    {
        return $query->where('name', 'LIKE', '%' . $name . '%');
    }


    public function scopeWithAvgRating(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        //return $this->comments()->avg('rating');
        return $query->withAvg('comments', 'rating');
    }

    //評論的平均分數最高的公司
    public function scopeHighestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvgRating()
            ->orderBy('comments_avg_rating', 'desc');
    }

    //評論的平均分數最低的公司
    public function scopeLowestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withAvgRating()
            ->orderBy('comments_avg_rating', 'asc');
    }


    public function scopeWithMaxUpdatedAt(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withMax('comments', 'updated_at');
    }

    public function scopeWithMinUpdatedAt(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withMin('comments', 'updated_at');
    }

    //評論的更新時間最新的公司
    public function scopeLatestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withMaxUpdatedAt()
            ->orderBy('comments_max_updated_at', 'desc');
    }

    //評論的更新時間最舊的公司
    public function scopeOldestRated(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->withMinUpdatedAt()
            ->orderBy('comments_min_updated_at', 'asc');
    }


    //公司名稱按照正序排列
    public function scopeAscendingName(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->orderBy('name', 'asc');
    }

    //公司名稱按照倒序排列
    public function scopeDescendingName(Builder $query, $from = null, $to = null): Builder|QueryBuilder
    {
        return $query->orderBy('name', 'desc');
    }


}
