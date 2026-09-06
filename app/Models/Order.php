<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;

    protected $fillable = ['customer_id', 'tracking_code', 'total_price', 'status', 'is_finalized', 'referred_to_user_id', 'admin_notes'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function referredTo()
    {
        return $this->belongsTo(User::class, 'referred_to_user_id');
    }
}
