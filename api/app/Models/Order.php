<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id_client',
        'id_city',
        'id_user',
        'boarding_date',
        'return_date',
        'status',
    ];

    public function scopeForLoggedUser($query)
    {
        return $query->where('id_user', auth()->id());
    }

    protected static function booted()
    {
        static::updated(function ($order) {
            if ($order->isDirty('status')) {
                $user = $order->user;
                $user->notify(new \App\Notifications\OrderStatusUpdated($order));
            }
        });
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'id_client');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'id_city');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
