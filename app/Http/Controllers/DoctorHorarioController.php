<?php

namespace App\Http\Controllers;

use App\DoctorHorario;
use App\IntervaloHorario;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DoctorHorarioController extends Controller
{
    public function index()
    {
        return view("doctor_horarios.index");
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
    }
    public function edit(DoctorHorario $doctor_horario)
    {
    }
    public function update(Usuario $usuario, Request $request)
    {
        $id = $request->id;
        $estado = $request->estado;
        $tm_hora_ini = $request->tm_hora_ini;
        $tm_hora_fin = $request->tm_hora_fin;
        $tt_hora_ini = $request->tt_hora_ini;
        $tt_hora_fin = $request->tt_hora_fin;
        $intervalo = $request->intervalo;

        $ih = IntervaloHorario::where("user_id", $usuario->id)->get()->first();
        $ih->intervalo = $intervalo;
        $ih->save();

        for ($i = 0; $i < count($id); $i++) {
            $doctor_horario = DoctorHorario::find($id[$i]);
            $doctor_horario->update([
                "estado" => $estado[$i],
                "tm_hora_ini" => $tm_hora_ini[$i],
                "tm_hora_fin" => $tm_hora_fin[$i],
                "tt_hora_ini" => $tt_hora_ini[$i],
                "tt_hora_fin" => $tt_hora_fin[$i],
            ]);
        }

        return redirect()->route("doctor_horarios.show", $usuario->id)->with("bien", "Horario actualizado éxitosamente");
    }
    public function show(Usuario $usuario)
    {
        DoctorHorario::verificaHorarios($usuario);
        $ih = DoctorHorario::verificaIntervaloHorario($usuario);
        $doctor_horarios = DoctorHorario::where("user_id", $usuario->id)->get();
        return view("doctor_horarios.show", compact("usuario", "doctor_horarios", "ih"));
    }
    public function destroy(DoctorHorario $doctor_horario)
    {
    }
}
