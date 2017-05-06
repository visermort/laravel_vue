<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id';


    protected $fillable = ['order_good_id', 'order_good_price', 'orderg_count',
        'order_summ', 'order_client_name', 'order_client_phone', 'order_client_address',];
}
