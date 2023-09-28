<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravolt\Indonesia\Models\District;

class IndonesiaVillage extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $table = []
}
