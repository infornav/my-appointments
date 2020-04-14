<?php

namespace App\Http\Controllers;

use App\Appointment;
use App\CancelledAppointment;
use App\Http\Requests\StoreAppointment;
use App\Interfaces\ScheduleServiceInterface;
use App\Services\ScheduleService;
use App\Specialty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class AppointmentController extends Controller
{
    public function index(){
        $role = auth()->user()->role;
        if($role == 'admin'){
            $pendingAppointments = Appointment::where('status','Reservada')
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status','Confirmada')
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
                ->paginate(10);
        }
        elseif($role == 'charts'){
            $pendingAppointments = Appointment::where('status','Reservada')
                ->where('doctor_id',auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status','Confirmada')
                ->where('doctor_id',auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
                ->where('doctor_id',auth()->id())
                ->paginate(10);
        }
        elseif($role == 'patient'){
            $pendingAppointments = Appointment::where('status','Reservada')
                ->where('patient_id',auth()->id())
                ->paginate(10);
            $confirmedAppointments = Appointment::where('status','Confirmada')
                ->where('patient_id',auth()->id())
                ->paginate(10);
            $oldAppointments = Appointment::whereIn('status',['Atendida','Cancelada'])
                ->where('patient_id',auth()->id())
                ->paginate(10);
        }
        //patient

        return view('appointments.index',
            compact('pendingAppointments','confirmedAppointments','oldAppointments','role'));
    }

    public function show(Appointment $appointment){
        $role = auth()->user()->role;
        return view('appointments.show',compact('appointment','role'));
    }

    public function create(ScheduleServiceInterface $scheduleService){
        $specialties = Specialty::all();

        $specialtyId = old('specialty_id');
        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }

        $scheduledDate = old('scheduled_date');
        $doctorId = old('doctor_id');
        if($scheduledDate && $doctorId){
            $intervals = $scheduleService->getAvailableIntervals($scheduledDate,$doctorId);
        }else{
                $intervals = null;
        }

        return view('appointments.create',compact('specialties','doctors','intervals'));
    }

    public function store(StoreAppointment $request){
        /*
         * SE HA MODIFICADO CON FORMREQUEST EQUIVALENTE EN STOREAPPOINTMENT.PHP DE REQUESTS
         * $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'scheduled_time' => 'required'
        ];

        $messages = [
            'scheduled_time.required' => 'Por favor seleccione una hora válida para su cita.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function($validator) use ($request, $scheduledService){
            $date = $request->input('date');
            $doctorId = $request->input('doctor_id');
            $scheduledTime = $request->input('scheduled_time');

            if(!$date || !$doctorId || !$scheduledTime)
                return;

            $start = new Carbon($scheduledTime);
            if(!$scheduledService->isAvailableInterval($date, $doctorId, $start)){
                $validator->errors()
                    ->add('available_time', 'La hora seleccionada  ya se encuentra reservada para otro paciente');
            }
        });

        if($validator->fails()){
            return back()
                    ->withErrors($validator)
                    ->withInput(); //es necesario para que old no puede mostrar directamente
        }*/
        $created = Appointment::createForPatient($request, auth()->id());

        if($created)
            $notification = 'La cita se ha registrado correctamente...';
        else
            $notification = 'Ocurrió un problema al registrar la cita médica...';

        return back()->with(compact('notification'));
        //return redirect('/appointments');
    }

    public function showCancelForm(Appointment $appointment){

        if($appointment->status == "Confirmada"){
            $role = auth()->user()->role;
            return view('appointments.cancel',compact('appointment','role'));
        }

        return redirect('appointments');
    }

    public function postCancel(Appointment $appointment, Request $request){
        if($request->has('justification')){
            $cancellation = new CancelledAppointment();
            $cancellation->justification = $request->input('justification');
            $cancellation->cancelled_by = auth()->id();

            $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'Cancelada';
        $saved= $appointment->save();

        if($saved)
            $appointment->patient->sendFCM('Su cita ha sido cancelada, disculpe las molestias!');

        $notification = 'La cita se ha cancelado correctamente...';
        return redirect('appointments')->with(compact('notification'));
    }

    public function postConfirm(Appointment $appointment, Request $request){
        $appointment->status = 'Confirmada';
        $saved = $appointment->save();

        if($saved)
            $appointment->patient->sendFCM('Su cita se ha confirmado!');

        $notification = 'La cita se ha confirmado correctamente...';
        return redirect('appointments')->with(compact('notification'));
    }
}
