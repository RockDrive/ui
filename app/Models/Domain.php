<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Domain extends Model
{
    use HasFactory, AsSource;

    protected $guarded = [];

    /**
     * @param Builder $query
     *
     * @return Builder
     */
    public function scopeSpare(Builder $query)
    {
        return $query->where("project_id", NULL);
    }
}
