<?php namespace App\Services;

use App\Appointment;
use App\Interfaces\ScheduleServiceInterface;
use App\WorkDay;
use Carbon\Carbon;

class ScheduleService implements ScheduleServiceInterface {
    public function getDayFromDate($date){
        $dateCarbon = new Carbon($date);
        //dayOfWeek
        //Carbon_: 0 = sunday, 6 = saturday
        //WorkDay: 0 = lunes, 6 = domingo
        $i = $dateCarbon->dayOfWeek;
        $day = ($i == 0 ? 6 : $i-1);

        return $day;
    }

    public function isAvailableInterval($date, $doctorId, Carbon $start){
        $exists = Appointment::where('scheduled_date', $date)
            ->where('doctor_id',$doctorId)
            ->where('scheduled_time', $start->format('H:i:s'))
            ->exists();

        return !$exists; //estara disponible si no existe
    }

    public function getAvailableIntervals($date, $doctorId){
        $workDay = WorkDay::where('active',true)
            ->where('day', $this->getDayFromDate($date))
            ->where('user_id', $doctorId)
            ->first([
                'morning_start','morning_end',
                'afternoon_start','afternoon_end'
            ]);

        if($workDay){
            $morningIntervals = $this->getIntervals($workDay->morning_start, $workDay->morning_end,$date, $doctorId);
            $afternoonIntervals = $this->getIntervals($workDay->afternoon_start, $workDay->afternoon_end,$date, $doctorId);
        } else {
            $morningIntervals = [];
            $afternoonIntervals = [];
        }

        $data = [];
        $data['morning'] = $morningIntervals;
        $data['afternoon'] = $afternoonIntervals;

        return $data;
    }

    private function getIntervals($start, $end,$date, $doctorId){
        $start = new Carbon($start);
        $end = new Carbon($end);

        $intervals = [];
        while($start < $end){
            $interval = [];

            $interval['start'] = $start->format('g:i A');
            $available = $this->isAvailableInterval($date, $doctorId, $start);

            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');

            if($available)
                $intervals [] = $interval;
        }

        return $intervals;
    }
}
