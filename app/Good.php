<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Good extends Model
{
    //
    protected $table = 'goods';
    protected $primaryKey = 'id';


    /**
     * @var array
     */
    protected $fillable = ['goods_name', 'goods_price'];
}
