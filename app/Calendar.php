<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';
    protected $primaryKey = 'id';


    protected $fillable = ['boat_id', 'name', 'description', 'status', 'event_date', 'length'];

    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    public function boat()
    {
        return $this->belongsTo('App\Boat', 'boat_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'user_to_calendar', 'calendar_id', 'user_id')->withPivot('role');
    }


}
