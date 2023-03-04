<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Place extends Model
{
    use HasFactory, SoftDeletes;

    const STATES = [
        '' => 'Selecione...',
        'AC' => 'Acre',
        'AL' => 'Alagoas',
        'AP' => 'Amapá',
        'AM' => 'Amazonas',
        'BA' => 'Bahia',
        'CE' => 'Ceará',
        'DF' => 'Distrito Federal',
        'ES' => 'Espírito Santo',
        'GO' => 'Goiás',
        'MA' => 'Maranhão',
        'MT' => 'Mato Grosso',
        'MS' => 'Mato Grosso do Sul',
        'MG' => 'Minas Gerais',
        'PA' => 'Pará',
        'PB' => 'Paraíba',
        'PR' => 'Paraná',
        'PE' => 'Pernambuco',
        'PI' => 'Piauí',
        'RJ' => 'Rio de Janeiro',
        'RN' => 'Rio Grande do Norte',
        'RS' => 'Rio Grande do Sul',
        'RO' => 'Rondônia',
        'RR' => 'Roraima',
        'SC' => 'Santa Catarina',
        'SP' => 'São Paulo',
        'SE' => 'Sergipe',
        'TO' => 'Tocantins',
    ];

    protected $fillable = [
        'name',
        'street',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'zipcode',
        'active',
    ];

    public function getfullAddress()
    {
        return "{$this->street}, {$this->number} {$this->complement} - {$this->district} - {$this->city} - {$this->state} - {$this->zipcode}";
    }

    public function documents()
    {
        return $this->hasMany(PlaceDocument::class);
    }

    public function rooms()
    {
        return $this->hasMany(PlaceRoom::class);
    }
}
