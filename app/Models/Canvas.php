<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Canvas extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];
    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            return $query->orderBy($sort['column'], $sort['dir']);
        });
    }

    public function childs()
    {
        return $this->hasMany(Canvas::class, 'parentId', 'id');
    }

    public function parents()
    {
        return $this->belongsTo(Canvas::class, 'parentId', 'id');
    }
}
