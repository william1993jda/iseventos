<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'os_status_id',
        'budget_id',
        'os_number',
        'os_version',
        'observation',
    ];


    public function osStatus()
    {
        return $this->belongsTo(OsStatus::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }
}
