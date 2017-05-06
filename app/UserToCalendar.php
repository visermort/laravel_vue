<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserToCalendar extends Model
{
    protected $table = 'user_to_calendar';
    protected $primaryKey = 'id';


    protected $fillable = ['user_id', 'calendar_id', 'role'];

    const ROLE_PASSENGER = 1;
    const ROLE_STUARD = 2;
    const ROLE_COACH = 3;
}
