<?php

namespace App\Http\Controllers;

use App\Concepto;
use App\Especialidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConceptoController extends Controller
{
    public function index()
    {
        $conceptos = Concepto::all();
        return view("conceptos.index", compact("conceptos"));
    }

    public function por_especialidad(Request $request)
    {
        $id = $request->id;
        $conceptos = Concepto::where("id_especialidad", $id)->get();
        $html = '<option value="">SIN REGISTROS</option>';
        if (count($conceptos) > 0)
            $html = '<option value="">- SELECCIONE -</option>';
        foreach ($conceptos as $c) {
            $html .= '<option value="' . $c->id . '"> ' . $c->nombre . ' </option>';
        }
        return response()->JSON([
            "conceptos" => $conceptos,
            "html" => $html,
        ]);
    }

    public function get_concepto(Request $request)
    {
        $id = $request->id;
        $concepto = Concepto::find($id);
        return response()->JSON([
            "concepto" => $concepto
        ]);
    }

    public function create()
    {
        $especialidades = Especialidad::where("state", 1)->get();
        return view("conceptos.create", compact("especialidades"));
    }
    public function store(Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "costo" => "required|numeric|min:1",
            "id_especialidad" => "required"
        ], [
            "nombre.required" => "Debes ingresar un nombre",
            "costo.required" => "Debes ingresar un costo",
            "costo.numeric" => "Debes ingresar valor númerico",
            "costo.min" => "Debes ingresar como minímo :min",
            "id_especialidad.required" => "Debes seleccionar una especialidad",
        ]);

        DB::beginTransaction();
        try {
            Concepto::create([
                "nombre" => mb_strtoupper($request->nombre),
                "costo" => $request->costo,
                "id_especialidad" => $request->id_especialidad,
            ]);
            DB::commit();
            return redirect()->route("conceptos.index")->with("mensaje", "Registro correcto")->with("class-alert", "success");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function edit(Concepto $concepto)
    {
        $especialidades = Especialidad::where("state", 1)->get();
        return view("conceptos.edit", compact("concepto", "especialidades"));
    }
    public function update(Concepto $concepto, Request $request)
    {
        $request->validate([
            "nombre" => "required",
            "costo" => "required|numeric|min:1",
            "id_especialidad" => "required"
        ], [
            "nombre.required" => "Debes ingresar un nombre",
            "costo.required" => "Debes ingresar un costo",
            "costo.numeric" => "Debes ingresar valor númerico",
            "costo.min" => "Debes ingresar como minímo :min",
            "id_especialidad.required" => "Debes seleccionar una especialidad",
        ]);

        DB::beginTransaction();
        try {
            $concepto->update([
                "nombre" => mb_strtoupper($request->nombre),
                "costo" => $request->costo,
                "id_especialidad" => $request->id_especialidad,
            ]);
            DB::commit();
            return redirect()->route("conceptos.index")->with("mensaje", "Registro actualizado")->with("class-alert", "success");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error", $e->getMessage());
        }
    }
    public function show(Concepto $concepto)
    {
    }
    public function destroy(Concepto $concepto)
    {
        return $concepto;
    }
}
