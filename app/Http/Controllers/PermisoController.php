<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Consultas;
use App\Models\Contrato;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\RoleUser;
use App\Models\Roles;
use App\Models\Permisos;

use App\Models\Catalogos;
use App\Helpers\FuncionesComunes;
use Illuminate\Support\Facades\Validator;
use Storage;
class PermisoController extends Controller
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

    public function index(){
        $permisos = Catalogos::getCatalogo("permissions", "*","1=1");
        return view('usuario-admin/permisos')
                    ->with("permisos",$permisos);
    }

    public function nuevo()
    {   
        $permisos = Usuario::getPermiso();
        
        return view('usuario-admin/permiso-nuevo');
    }
    public function registrarNuevo(Request $request){
        
        /*if(Usuario::verificarPermiso("permiso.registrarPermiso")){

        }*/
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('permisos-nuevo/')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $existe = \DB::select("SELECT exists (SELECT 1 FROM permissions
                                    where slug='{$request->slug}') existe")[0]->existe;

        if($existe){
            $errors[] = "El slug ya existe, debe ingresar un slug unico.";
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return redirect('permisos-nuevo/')->withInput();
        }

        $permiso = new Permisos();
        $permiso->name = $request->name;
        $permiso->slug = $request->slug;
        $permiso->description = $request->description;
        $permiso->save();
        return redirect('permisos-nuevo/')->withInput();
        //return redirect("permisos-modificar/".$permiso->id);
    }

    public function modificar($id)
    {
        
        $permiso = Permisos::find($id);
        return view('usuario-admin/permiso-modificar')
                    ->with("permiso",$permiso);
    }

    public function registrarModificacion(Request $request, $id){
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('permisos-modificar/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        $existe = \DB::select("SELECT exists (SELECT 1 FROM permissions
                                    where slug='{$request->slug}' and id!=$id) existe")[0]->existe;

        if($existe){
            $errors[] = "El slug ya existe, debe ingresar un slug unico.";
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return redirect('permisos-modificar/'.$id)->withInput();
        }

        
        $permiso = Permisos::find($id);
        $permiso->name = $request->name;
        $permiso->slug = $request->slug;
        $permiso->description = $request->description;
        $permiso->save();
        
        return redirect("permisos-modificar/".$id);

    }

    public function formularioBuscar(){
        
        return view("usuario-admin/form-buscar");
    }
    
    public function buscarByCarnet(Request $request){
        
        $persona = Persona::personaByCarnet($request->numero_documento);
        $usuario = (object) array();
        $roles = (object) array();
        
        if(!empty($persona)){
            if($persona[0]->id_user!=null){
                $usuario = Usuario::find($persona[0]->id_user);
                $roles = Usuario::getRolesByUsuario($persona[0]->id_user);
            }
            
        }
        
        return view("usuario-admin/form-buscar")
                ->with("persona", $persona)
                ->with("usuario", $usuario)
                ->with("roles", $roles)
                ->with("numero_documento",$request->numero_documento);
    }
    
    
}
