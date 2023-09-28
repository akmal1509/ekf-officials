<?php

namespace App\Models;

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

    public function dapils()
    {
        return $this->belongsTo(DapilCategory::class, 'dapilCategoryId', 'id');
    }

    public function districts()
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }

    public function goWil()
    {
        return $this->hasMany(DapilDistrictGo::class, 'dapilDistrictId', 'id');
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
