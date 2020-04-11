<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class AppointmentController extends Controller
{
/*"id": 84,
"specialty_id": 2,
"doctor_id": 56,
"patient_id": 2,
"description": "Reprehenderit tenetur tempora nesciunt eveniet sunt nisi.",
"scheduled_date": "2020-01-24",
"scheduled_time": "13:33:03",
"type": "Operación",
"created_at": "2020-04-05T04:08:56.000000Z",
"updated_at": "2020-04-05T04:08:56.000000Z",
"status": "Cancelada"*/
    public function index(){
        $user = auth('api')->user();
        $apppointments = $user->asPatientAppointments()
                            ->with([
                                'specialty' => function ($query) {
                                    $query->select('id','name');
                                },
                                'doctor' => function ($query) {
                                    $query->select('id','name');
                                }
                            ])
                            ->get([
                                "id",
                                "specialty_id",
                                "doctor_id",
                                "description",
                                "scheduled_date",
                                "scheduled_time",
                                "type",
                                "status",
                                "created_at"
                            ]);

        return $apppointments;
    }

    public function store(){

    }
}
