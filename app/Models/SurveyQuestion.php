<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveyQuestion extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function jawaban()
    {
        return $this->hasMany(SurveyAnswer::class, 'questionId', 'id');
    }
}
