<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FreelancerDependent extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_id',
        'name',
        'birthday',
        'identification',
        'social_security',
    ];

    public function setBirthdayAttribute($value)
    {
        $this->attributes['birthday'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
    }

    public function getBirthdayAttribute($value)
    {
        if ($value) {
            return date('d/m/Y', strtotime($value));
        }
    }

    public function employee()
    {
        return $this->belongsTo(Freelancer::class);
    }
}
