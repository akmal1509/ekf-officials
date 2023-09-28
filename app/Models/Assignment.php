<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\District;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function dapils()
    {
        return $this->belongsTo(DapilDistrict::class, 'dapilDistrictId', 'id');
    }

    // public function dapilCategories()
    // {
    //     return $this->
    // }

    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }
    // publ

    public function getDapilNameAttribute()
    {
        return 'Dapil ' . $this->dapils->dapilCategoryId . ' ' . $this->dapils->cities->name;
    }

    public function getProvinceNameAttribute()
    {
        return $this->dapils->provinces->name;
    }
}
