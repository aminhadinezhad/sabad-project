<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

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

    /**
     * The order's pre-invoice. Signed: order numbers run in sequence, so without the signature
     * anyone could change the number and read another customer's name, phone and address.
     */
    public function invoiceUrl(): string
    {
        return URL::signedRoute('orders.invoice', $this);
    }

    /** The page the customer lands on after ordering; signed for the same reason. */
    public function successUrl(): string
    {
        return URL::signedRoute('orders.success', ['trackingCode' => $this->tracking_code]);
    }
}
