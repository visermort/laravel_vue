<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    //
    protected $table = 'goods';
    protected $primaryKey = 'goods_id';


    protected $fillable = ['goods_name', 'goods_price'];
}
