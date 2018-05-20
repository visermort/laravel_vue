<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';


    /**
     * @var array
     */
    protected $fillable = ['order_good_id', 'order_good_price', 'orderg_count',
        'order_summ', 'order_client_name', 'order_client_phone', 'order_client_address',];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payments()
    {
        return $this->hasMany('App\Payment', 'payment_order_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function good()
    {
        return $this->belongsTo('App\Good', 'order_good_id', 'id');
    }
}
