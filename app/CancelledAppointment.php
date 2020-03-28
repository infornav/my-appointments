<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    //Cancelled N - 1  User
    public function cancelled_by(){
        return $this->belongsTo(User::class);
    }
}
