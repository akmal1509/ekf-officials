<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravolt\Indonesia\Models\District;


class DapilDistrictGo extends Model
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
}
