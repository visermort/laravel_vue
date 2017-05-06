<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Boat extends Model
{
    protected $table = 'boats';
    protected $primaryKey = 'id';


    protected $fillable = ['boat_name'];

    public function calendar()
    {
        return $this->hasMany('App\Calendar', 'boat_id', 'id');
    }
}
