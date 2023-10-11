<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\District;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            return $query->orderBy($sort['column'], $sort['dir']);
        });
        $query->when($filters['search']['name'] ?? false, function ($query, $sort) {
            return $query->where(function ($query) use ($sort) {
                $query->whereHas('users', function ($query) use ($sort) {
                    $query->where('name', 'LIKE', '%' . $sort . '%');
                });
            })->orWhere(function ($query) use ($sort) {
                return $query->where(function ($query) use ($sort) {
                    $query->whereHas('districts', function ($query) use ($sort) {
                        $query->where('name', 'LIKE', '%' . $sort . '%');
                    });
                });
            });
        });
    }

    public function dapils()
    {
        return $this->belongsTo(DapilDistrict::class, 'dapilDistrictId', 'id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }
    public function goWil()
    {
        return $this->hasMany(DapilDistrictGo::class, 'dapilDistrictId', 'dapilDistrictId');
    }

    public function getDapilNameAttribute()
    {
        return 'Dapil ' . $this->dapils->dapilCategoryId . ' ' . $this->dapils->cities->name;
    }

    public function getProvinceNameAttribute()
    {
        return $this->dapils->provinces->name;
    }
}
