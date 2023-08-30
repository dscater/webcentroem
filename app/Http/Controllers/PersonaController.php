<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Consultas;
use App\Models\Persona;
use App\Models\Contrato;
use App\Models\Catalogos;
use App\Helpers\FuncionesComunes;
use Illuminate\Support\Facades\Validator;
use Storage;
class PersonaController extends Controller
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

    
    public function nuevo()
    {
        $tipo_doc_iden = Catalogos::getTipoDocIden();
        $departamento =  Catalogos::getDepartamento();
        $mes =  Catalogos::getMes();
        $catalogo_nacion =  Catalogos::getCatalogoNacion();
        $banco =  Catalogos::getBanco();
        $caja_salud =  Catalogos::getCajaSalud();
        return view('persona/nuevo')
                    ->with("tipo_doc_iden",$tipo_doc_iden)
                    ->with("departamento",$departamento)
                    ->with("mes",$mes)
                    ->with("catalogo_nacion",$catalogo_nacion)
                    ->with("banco",$banco)
                    ->with("caja_salud",$caja_salud);
    }
    public function registrarNuevo(Request $request){
        
        $validator = Validator::make($request->all(),[
            'dia_nac' => 'required', 'mes_nac' => 'required', 'anio_nac' => 'required',
            'id_tipo_doc_iden' => 'required', 'id_departamento' => 'required', 'numero_documento' => 'required|numeric',
            'nombre1' => 'required|alpha', 'genero' => 'required', 'estado_civil' => 'required',
            'direccion' => 'required','id_nacion_nac' => 'required', 'id_departamento_nac' => 'required',
            'libreta_militar' => 'required','jubilado' => 'required', 'aporta_afp' => 'required',
            'complemento' => 'nullable|alpha', 'nombre2' => 'nullable|alpha', 'paterno' => 'nullable|alpha', 'materno' => 'nullable|alpha',
            'telefono' => 'nullable|numeric', 'celular' => 'nullable|numeric','email'=>'nullable|email',
            'apellido_conyugue' => 'nullable|alpha', 'nombre_conyugue' => 'nullable|alpha','numero_afp'=>'nullable|numeric',
            'caja_salud_numero_asegurado'=>'nullable', 'banco_numero_cuenta'=>'nullable|numeric',
            'nit'=>'nullable|numeric',
        ]);
        
        if ($validator->fails()) {
            return redirect('persona-nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $fec_nac = FuncionesComunes::getFechaByDiaMesAnio($request->dia_nac, $request->mes_nac, $request->anio_nac);
        $fec_afi = FuncionesComunes::getFechaByDiaMesAnio($request->dia_afi, $request->mes_afi, $request->anio_afi);

        $persona = new Persona();
        
        $persona->nombre1 = $request->nombre1;
        $persona->nombre2 = $request->nombre2;
        $persona->paterno = $request->paterno;
        $persona->materno = $request->materno;
        $persona->estado_civil = $request->estado_civil;
        $persona->telefono = $request->telefono;
        $persona->celular = $request->celular;
        $persona->direccion = $request->direccion;
        $persona->apellido_conyugue = $request->apellido_conyugue;
        $persona->nombre_conyugue = $request->nombre_conyugue;
        

        $persona->id_tipo_doc_iden = $request->id_tipo_doc_iden;
        $persona->numero_documento = $request->numero_documento;
        $persona->complemento = $request->complemento;
        $persona->id_departamento = $request->id_departamento;
        
        $persona->id_nacion_nac = $request->id_nacion_nac;
        $persona->id_departamento_nac = $request->id_departamento_nac;
        $persona->fecha_nacimiento = $fec_nac;
        $persona->genero = $request->genero;
        $persona->libreta_militar = $request->libreta_militar;

        $persona->id_entidad_afp = $request->id_entidad_afp;
        $persona->numero_afp = $request->numero_afp;
        $persona->jubilado = $request->jubilado;
        $persona->aporta_afp = $request->aporta_afp;

        $persona->id_banco = $request->id_banco;
        $persona->banco_numero_cuenta = $request->banco_numero_cuenta;

        
        
        $persona->id_caja_salud = $request->id_caja_salud;
        $persona->caja_salud_numero_asegurado = $request->caja_salud_numero_asegurado;
        $persona->caja_salud_fecha_afiliacion = $fec_afi;;
        
        $persona->nit = $request->nit;
        $persona->saldo_favor_impuestos = (!empty($request->saldo_favor_impuestos))?$request->saldo_favor_impuestos:0;

        if(!empty($request->foto))
        {
        	//creacion de nombre para el archivo
            $nombre_imagen=time()."_".$request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;    
            //guardar el archivo
            Storage::disk("public_img")->put("fotoPersona/".$nombre_imagen,file_get_contents($request->foto->getRealPath()));  
            
        }

        $persona->state = true;
        $persona->save();
        
        return redirect("persona-modificar/".$persona->id);

    }

    public function modificar($id)
    {
        $tipo_doc_iden = Catalogos::getTipoDocIden();
        $departamento =  Catalogos::getDepartamento();
        $mes =  Catalogos::getMes();
        $catalogo_nacion =  Catalogos::getCatalogoNacion();
        $banco =  Catalogos::getBanco();
        $caja_salud =  Catalogos::getCajaSalud();
        $persona = Persona::find($id);
        if(!empty($persona->foto)){
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        return view('persona/modificar')
                    ->with("tipo_doc_iden",$tipo_doc_iden)
                    ->with("departamento",$departamento)
                    ->with("mes",$mes)
                    ->with("catalogo_nacion",$catalogo_nacion)
                    ->with("banco",$banco)
                    ->with("caja_salud",$caja_salud)
                    ->with("persona",$persona);
    }

    public function registrarModificacion(Request $request, $id){

        $validator = Validator::make($request->all(),[
            'dia_nac' => 'required', 'mes_nac' => 'required', 'anio_nac' => 'required',
            'id_tipo_doc_iden' => 'required', 'id_departamento' => 'required', 'numero_documento' => 'required|numeric',
            'nombre1' => 'required|alpha', 'genero' => 'required', 'estado_civil' => 'required',
            'direccion' => 'required','id_nacion_nac' => 'required', 'id_departamento_nac' => 'required',
            'libreta_militar' => 'required','jubilado' => 'required', 'aporta_afp' => 'required',
            'complemento' => 'nullable|alpha', 'nombre2' => 'nullable|alpha', 'paterno' => 'nullable|alpha', 'materno' => 'nullable|alpha',
            'telefono' => 'nullable|numeric', 'celular' => 'nullable|numeric','email'=>'nullable|email',
            'apellido_conyugue' => 'nullable|alpha', 'nombre_conyugue' => 'nullable|alpha','numero_afp'=>'nullable|numeric',
            'caja_salud_numero_asegurado'=>'nullable', 'banco_numero_cuenta'=>'nullable|numeric',
            'nit'=>'nullable|numeric',
        ]);
        
        if ($validator->fails()) {
            return redirect("persona-modificar/".$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $fec_nac = FuncionesComunes::getFechaByDiaMesAnio($request->dia_nac, $request->mes_nac, $request->anio_nac);
        $fec_afi = FuncionesComunes::getFechaByDiaMesAnio($request->dia_afi, $request->mes_afi, $request->anio_afi);

        $persona = Persona::find($id);
        
        $persona->nombre1 = $request->nombre1;
        $persona->nombre2 = $request->nombre2;
        $persona->paterno = $request->paterno;
        $persona->materno = $request->materno;
        $persona->estado_civil = $request->estado_civil;
        $persona->telefono = $request->telefono;
        $persona->celular = $request->celular;
        $persona->direccion = $request->direccion;
        $persona->apellido_conyugue = $request->apellido_conyugue;
        $persona->nombre_conyugue = $request->nombre_conyugue;
        

        $persona->id_tipo_doc_iden = $request->id_tipo_doc_iden;
        $persona->numero_documento = $request->numero_documento;
        $persona->complemento = $request->complemento;
        $persona->id_departamento = $request->id_departamento;
        
        $persona->id_nacion_nac = $request->id_nacion_nac;
        $persona->id_departamento_nac = $request->id_departamento_nac;
        $persona->fecha_nacimiento = $fec_nac;
        $persona->genero = $request->genero;
        $persona->libreta_militar = $request->libreta_militar;

        $persona->id_entidad_afp = $request->id_entidad_afp;
        $persona->numero_afp = $request->numero_afp;
        $persona->jubilado = $request->jubilado;
        $persona->aporta_afp = $request->aporta_afp;

        $persona->id_banco = $request->id_banco;
        $persona->banco_numero_cuenta = $request->banco_numero_cuenta;
        
        $persona->id_caja_salud = $request->id_caja_salud;
        $persona->caja_salud_numero_asegurado = $request->caja_salud_numero_asegurado;
        $persona->caja_salud_fecha_afiliacion = $fec_afi;;
        
        $persona->nit = $request->nit;
        $persona->saldo_favor_impuestos = $request->saldo_favor_impuestos;
        

        if($request->foto!=null&&$request->foto!="null") {
        	//creacion de nombre para el archivo
            $nombre_imagen=time()."_".$request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;    
            //guardar el archivo
            Storage::disk("public_img")->put("fotoPersona/".$nombre_imagen,file_get_contents($request->foto->getRealPath()));  
            
        }

        $persona->state = true;
        $persona->save();
        
        return redirect("persona-modificar/".$persona->id);

    }

    public function formularioBuscar(){
        return view("persona/form-buscar");
    }
    
    public function buscar(Request $request){
        
        $persona = Persona::personaByLikeCarnet($request->numero_documento);
        
        return view("persona/form-buscar")
                ->with("persona", $persona)
                ->with("numero_documento",$request->numero_documento);
    }
    
}
