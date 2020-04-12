<?php

namespace App\Http\Requests;

use App\Interfaces\ScheduleServiceInterface;
use App\Services\ScheduleService;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreAppointment extends FormRequest
{
    private $scheduledService;

    public function __construct(ScheduleServiceInterface $scheduledService){
        $this->scheduledService = $scheduledService;
    }

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required'
        ];
    }

    public function  messages()
    {
        return [
            'scheduled_time.required' => 'Por favor seleccione una hora válida para su cita.'
        ];
    }

    public function withValidator($validator){
        $validator->after(function($validator) {
            $date = $this->input('date');
            $doctorId = $this->input('doctor_id');
            $scheduledTime = $this->input('scheduled_time');

            if(!$date || !$doctorId || !$scheduledTime)
                return;

            $start = new Carbon($scheduledTime);
            if(!$this->scheduledService->isAvailableInterval($date, $doctorId, $start)){
                $validator->errors()
                    ->add('available_time', 'La hora seleccionada  ya se encuentra reservada para otro paciente');
            }
        });
    }
}
