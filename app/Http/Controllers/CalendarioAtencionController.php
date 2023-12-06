<?php

namespace App\Http\Controllers;

use App\CalendarioAtencion;
use App\Models\Usuario;
use Illuminate\Http\Request;

class CalendarioAtencionController extends Controller
{
    public function show(Usuario $usuario)
    {
        $calendario_atencions = CalendarioAtencion::where("user_id", $usuario->id)->orderBy("id", "desc")->paginate(10);
        return view("calendario_atencions.show", compact("usuario", "calendario_atencions"));
    }
    public function store(Usuario $usuario, Request $request)
    {
        $request->validate([
            "fecha_ini" => "required|date",
            "fecha_fin" => "required|date",
        ]);
        CalendarioAtencion::create([
            "user_id" => $usuario->id,
            "fecha_ini" => $request->fecha_ini,
            "fecha_fin" => $request->fecha_fin,
        ]);
        return redirect()->route("calendario_atencions.show", $usuario->id)->with("bien", "Calendario registrado éxitosamente");
    }
    public function destroy(CalendarioAtencion $calendario_atencion)
    {
        $usuario = $calendario_atencion->user;
        $calendario_atencion->delete();
        return redirect()->route("calendario_atencions.show", $usuario->id)->with("bien", "Registro eliminado éxitosamente");
    }
}
