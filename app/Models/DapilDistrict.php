<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\Village;

use Illuminate\Database\Eloquent\SoftDeletes;

class DapilDistrict extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            return $query->orderBy($sort['column'], $sort['dir']);
        });
        $query->when($filters['search']['name'] ?? false, function ($query, $sort) {
            return $query->whereHas('goWil.districts', function ($query) use ($sort) {
                $query->where('name', 'LIKE', '%' . $sort . '%');
            });
        });
    }

    public function dapils()
    {
        return $this->belongsTo(DapilCategory::class, 'dapilCategoryId', 'id');
    }

    public function districts()
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }

    public function test()
    {
        return $this->belongsToMany(
            District::class,
            'dapil_district_gos',
            'dapilDistrictId',
            'districtId',
            'id',
            'id'
        );
    }

    public function goWil()
    {
        return $this->hasMany(DapilDistrictGo::class, 'dapilDistrictId', 'id');
    }

    public function getDapilNameAttribute()
    {
        return 'Dapil ' . $this->dapilCategoryId . ' ' . $this->cities->name;
    }

    public function cities()
    {
        return $this->belongsTo(City::class, 'cityId', 'id');
    }
    public function provinces()
    {
        return $this->belongsTo(Province::class, 'provinceId', 'id');
    }
    // public function villages()
    // {
    //     return $this->belongsTo(Village::class, 'villageId', 'id');
    // }
}
