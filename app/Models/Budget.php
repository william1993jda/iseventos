<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'last_user_id',
        'status_id',
        'customer_id',
        'customer_contact_id',
        'agency_id',
        'place_id',
        'budget_number',
        'budget_version',
        'name',
        'request_date',
        'budget_days',
        'mount_date',
        'unmount_date',
        'start_time',
        'end_time',
        'public',
        'observation',
        'discount',
        'discount_type',
        'fee',
        'fee_type',
        'commercial_conditions',
        'payment_conditions',
    ];

    protected $casts = [
        'request_date' => 'date',
        'mount_date' => 'date',
        'unmount_date' => 'date'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $model->user_id = auth()->user()->id;
            $model->last_user_id = auth()->user()->id;
            $model->budget_number = (int) Budget::withTrashed()->max('budget_number') + 1;
            $model->budget_version = 1;
            $model->saveQuietly();
        });

        static::updated(function ($model) {
            $model->last_user_id = auth()->user()->id;
            $model->saveQuietly();
        });
    }

    public function setRequestDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['request_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }

    public function setMountDateAttribute($value)
    {

        if (!empty($value)) {
            $this->attributes['mount_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }

    public function setUnmountDateAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['unmount_date'] = date('Y-m-d', strtotime(str_replace('/', '-', $value)));
        }
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function customerContact()
    {
        return $this->belongsTo(CustomerContact::class);
    }

    public function agency()
    {
        return $this->belongsTo(Agency::class);
    }

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    public function expenses()
    {
        return $this->hasMany(BudgetExpense::class);
    }

    public function documents()
    {
        return $this->hasMany(BudgetDocument::class);
    }

    public function orderService()
    {
        return $this->hasOne(OrderService::class);
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
