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

    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function districts()
    {
        return $this->belongsTo(District::class, 'districtId', 'id');
    }

    public function getDapilNameAttribute()
    {
        return $this->dapils->name;
    }

    public function getProvinceNameAttribute()
    {
        return $this->dapils->provinces->name;
    }
}
