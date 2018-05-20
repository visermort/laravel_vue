<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = 'id';

    public static $paymentStatuses = [
        0 => 'Not payed',
        1 => 'Payed for',
        2 => 'Return',
    ];

    protected $fillable = ['payment_order_id', 'payment_summ', 'payment_client_name', 'payment_client_phone',
        'payment_status'];

    /**
     * @return mixed
     */
    public function paymentStatus()
    {
        return $this->paymentStatuses[$this->payment_status];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo('App\Order', 'payment_order_id', 'id');
    }


}
