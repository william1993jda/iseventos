<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderService extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'last_user_id',
        'os_status_id',
        'budget_id',
        'os_number',
        'os_version',
        'budget_version',
        'observation',
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->user_id = auth()->user()->id;
            $model->last_user_id = auth()->user()->id;
            $model->saveQuietly();
        });

        static::updated(function ($model) {
            $model->last_user_id = auth()->user()->id;
            $model->saveQuietly();
        });
    }

    public function osStatus()
    {
        return $this->belongsTo(OsStatus::class);
    }

    public function budget()
    {
        return $this->belongsTo(Budget::class);
    }

    public function expenses()
    {
        return $this->hasMany(OrderServiceExpense::class);
    }

    public function documents()
    {
        return $this->hasMany(OrderServiceDocument::class);
    }

    public function products()
    {
        return $this->hasMany(OrderServiceRoomProduct::class);
    }

    public function groups()
    {
        return $this->hasMany(OrderServiceRoomGroup::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lastUser()
    {
        return $this->belongsTo(User::class, 'last_user_id');
    }
}
