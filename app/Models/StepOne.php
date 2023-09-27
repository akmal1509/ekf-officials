<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Laravolt\Indonesia\Models\Village;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\District;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StepOne extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = ['id'];

    public function users()
    {
        return $this->belongsTo(User::class, 'userId', 'id');
    }
    public function schools()
    {
        return $this->belongsTo(Schools::class, 'schoolId', 'id');
    }

    public function scopeFilter(Builder $query, array $filters)
    {
        $query->when($filters['sort'] ?? false, function ($query, $sort) {
            return $query->orderBy($sort['column'], $sort['dir']);
        });
        $query->when($filters['guest'] ?? false, function ($query, $filter) {
            return $query->where('userId', auth()->user()->id);
        });
        $query->when($filters['search']['name'] ?? false, function ($query, $filter) {
            return $query->whereHas('schools', function ($query) use ($filter) {
                $query->where('name', 'LIKE', '%' . $filter . '%');
            });
        });
    }

    public function assignments()
    {
        return Assignment::where('userId', Auth::user()->id)->get();
    }
    public function villages()
    {
        return $this->belongsTo(Village::class, 'villageId', 'id');
    }

    public function setHeadmasterAttribute($value)
    {
        $this->attributes['headmaster'] = strtoupper($value);
    }
    public function setSchoolOperatorAttribute($value)
    {
        $this->attributes['schoolOperator'] = strtoupper($value);
    }
    public function setChairmanAttribute($value)
    {
        $this->attributes['chairman'] = strtoupper($value);
    }
}
