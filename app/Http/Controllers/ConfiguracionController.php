<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Configuracion;

use Illuminate\Support\Facades\Validator;
use Storage;
class ConfiguracionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    

    public function modificar() {
        
        $configuracion = Configuracion::find(1);
        if(!empty($configuracion->logo)){
            $configuracion->logo = url("img/".$configuracion->logo);
        }
        else{
            $configuracion->logo = url("img/img-avatar.jpg");
        }
        
        return view('configuracion/modificar')
                    ->with("configuracion",$configuracion);
    }

    public function registrarModificacion(Request $request){
  

        $configuracion = Configuracion::find(1);
        
        $configuracion->razon_social = $request->razon_social;
        $configuracion->alias = $request->alias;
        $configuracion->ciudad = $request->ciudad;
        $configuracion->direccion = $request->direccion;
        $configuracion->nit = $request->nit;
        $configuracion->numero_autorizacion = $request->numero_autorizacion;
        $configuracion->fecha_limite_emision = $request->fecha_limite_emision;
        
        $configuracion->telefono = $request->telefono;
        $configuracion->casilla = $request->casilla;
        
        $configuracion->email = $request->email;
        $configuracion->web = $request->web;
        $configuracion->actividad_economica = $request->actividad_economica;
        $configuracion->leyenda_factura = $request->leyenda_factura;
        
        
        

        if($request->logo!=null&&$request->logo1!="null") {
        	//creacion de nombre para el archivo
            $nombre_imagen=time()."_".$request->logo->getClientOriginalName();
            //asignacion del nombre
            $configuracion->logo = $nombre_imagen;    
            //guardar el archivo
            Storage::disk("public_img")->put("img/".$nombre_imagen,file_get_contents($request->logo->getRealPath()));  
            
        }
        
        $configuracion->save();
        
        return redirect("configuracion");

    }
    
}
