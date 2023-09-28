<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\District;

class IndonesiaDistrict extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $table = []

    public function villages()
    {
        return $this->hasMany(IndonesiaVillage::class, 'district_code', 'code');
    }
}
