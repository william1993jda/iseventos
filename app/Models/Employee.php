<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    const ROLES = [
        '' => 'Selecione...',
        'financeiro_human_resources' => 'Financeiro e Recursos Humanos',
        'commercial_administrative' => 'Comercial e Administrativo',
        'stock' => 'Estoque',
    ];

    protected $fillable = [
        'user_id',
        'admission_date',
        'birthday',
        'phone',
        'cellphone',
        'identification',
        'social_security',
        'emergency_name',
        'emergency_phone',
        'occupation_area',
        'ein',
        'corporate_name',
        'fantasy_name',
        'cnai',
        'photo',
        'tshirt',
        'trousers',
        'shoe',
        'observation',
        'work_card',
        'reservist',
        'voter_registration',
        'spouse_name',
        'spouse_identification',
        'spouse_social_security',
        'spouse_birth_date',
        'contract',
    ];

    protected $casts = [
        'admission_date' => 'date',
        'birthday' => 'date',
        'spouse_birth_date' => 'date',
    ];

    public function setIdentificationAttribute($value)
    {
        $this->attributes['identification'] = preg_replace('/\D/', '', $value);
    }

    public function setSocialSecurityAttribute($value)
    {
        $this->attributes['social_security'] = preg_replace('/\D/', '', $value);
    }

    public function setEinAttribute($value)
    {
        $this->attributes['ein'] = preg_replace('/\D/', '', $value);
    }

    public function setEmergencyPhoneAttribute($value)
    {
        $this->attributes['emergency_phone'] = preg_replace('/\D/', '', $value);
    }

    public function setSpouseNameAttribute($value)
    {
        $this->attributes['spouse_name'] = Str::title($value);
    }

    public function setCorporateNameAttribute($value)
    {
        $this->attributes['corporate_name'] = Str::upper($value);
    }

    public function setFantasyNameAttribute($value)
    {
        $this->attributes['fantasy_name'] = Str::upper($value);
    }

    public function setAdmissionDateAttribute($value)
    {
        if (!empty($value)) {
            $date = explode('/', $value);
            $this->attributes['admission_date'] = $date[2] . '-' . $date[1] . '-' . $date[0];
        }
    }

    public function setBirthdayAttribute($value)
    {
        if (!empty($value)) {
            $date = explode('/', $value);
            $this->attributes['birthday'] = $date[2] . '-' . $date[1] . '-' . $date[0];
        }
    }

    public function setSpouseBirthDateAttribute($value)
    {
        if (!empty($value)) {
            $date = explode('/', $value);
            $this->attributes['spouse_birth_date'] = $date[2] . '-' . $date[1] . '-' . $date[0];
        }
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function contacts()
    {
        return $this->hasMany(EmployeeContact::class);
    }

    public function addresses()
    {
        return $this->hasMany(EmployeeAddress::class);
    }

    public function banks()
    {
        return $this->hasMany(EmployeeBank::class);
    }

    public function dependents()
    {
        return $this->hasMany(EmployeeDependent::class);
    }

    public function documents()
    {
        return $this->hasMany(EmployeeDocument::class);
    }
}
