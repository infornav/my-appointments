<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'id',
        'description',
        'specialty_id',
        'doctor_id',
        'patient_id',
        'scheduled_date',
        'scheduled_time',
        'type'
    ];

    protected $hidden = [
        'specialty_id',
        'doctor_id',
        'scheduled_time'
    ];

    protected $appends = [
      'scheduled_time_12'
    ];

    //este metodo nos permitira acceder desde un appointment a la especialidad asociada
    //N $appointment->specialty 1
    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

    //N $appointment->charts 1
    public function doctor(){
        return $this->belongsTo(User::class);
    }

    //N $appointment->patient 1
    public function patient(){
        return $this->belongsTo(User::class);
    }

    //1 $appointment->cancellation_appointment 1/0
    public function cancellation(){
        return $this->hasOne(CancelledAppointment::class);
    }

    //accessor
    //$appointment->scheduled_time_12
    public function getScheduledTime12Attribute(){
        return (new Carbon($this->scheduled_time))->format('g:i A');
    }
}
