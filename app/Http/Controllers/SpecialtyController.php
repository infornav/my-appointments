<?php

namespace App\Http\Controllers;

use App\Specialty;
use Illuminate\Http\Request;

class SpecialtyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        $specialties = Specialty::all();
        return view('specialties.index',compact('specialties'));
    }

    public function create(){
        return view('specialties.create');
    }

    private function performValidation(Request $request){
        $rules = [
            'name' => 'required|min:5'
        ];

        $messages = [
            'name.required' => 'Es necesario ingresar un nombre',
            'name.min' => 'Es necesario ingresar un nombre de mínimo 5 caracteres'
        ];

        $this->validate($request, $rules, $messages);
    }

    public function store(Request $request){
        //dd($request->all());
        $this->performValidation($request);

        $specialty = new Specialty();
        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();

        $notification = 'La especialidad se ha registado correctamente...';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function edit(Specialty $specialty){
        return view('specialties.edit',compact('specialty', $specialty));
    }

    public function update(Request $request,Specialty $specialty){
        //dd($request->all());
        $this->performValidation($request);

        $specialty->name = $request->input('name');
        $specialty->description = $request->input('description');
        $specialty->save();

        $notification = 'La especialidad se ha actualizado correctamente...';
        return redirect('/specialties')->with(compact('notification'));
    }

    public function destroy(Specialty $specialty){
        $deletedSpecialty = $specialty->name;
        $specialty->delete();

        $notification = 'La especialidad '.$deletedSpecialty.' se ha eliminado correctamente...';
        return redirect('/specialties')->with(compact('notification'));
    }
}
