<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeBank extends Model
{
    use HasFactory, SoftDeletes;

    const TYPES = [
        '' => 'Selecione...',
        'checking' => 'Conta Corrente',
        'saving' => 'Poupança'
    ];

    protected $fillable = [
        'employee_id',
        'name',
        'number',
        'agency',
        'account',
        'type',
        'holder',
        'document_number',
        'observation',
    ];
}
