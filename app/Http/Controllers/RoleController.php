<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Consultas;
use App\Models\Contrato;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\RoleUser;
use App\Models\Roles;
use Caffeinated\Shinobi\Models\Role;

use App\Models\Catalogos;
use App\Helpers\FuncionesComunes;
use Illuminate\Support\Facades\Validator;
use Storage;
class RoleController extends Controller
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
        $roles = Catalogos::getCatalogo("roles", "*","1=1");
        return view('usuario-admin/roles')
                    ->with("roles",$roles);
    }

    public function nuevo()
    {   
        return view('usuario/role-nuevo');
    }
    public function registrarNuevo(Request $request){

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('roles-nuevo/')
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $existe = \DB::select("SELECT exists (SELECT 1 FROM roles
                                    where slug='{$request->slug}') existe")[0]->existe;

        if($existe){
            $errors[] = "El slug ya existe, debe ingresar un slug unico.";
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return redirect('roles-nuevo/')->withInput();
        }
        
        $role = new Roles();
        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->description = $request->description;
        $role->special = $request->special;
        $role->save();
        
        return redirect("roles-modificar/".$role->id);
    }

    public function modificar($id)
    {
        
        $role = Roles::find($id);
        return view('usuario-admin/role-modificar')
                    ->with("role",$role);
    }

    public function registrarModificacion(Request $request, $id){
        
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'slug' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('roles-modificar/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        $existe = \DB::select("SELECT exists (SELECT 1 FROM roles
                                    where slug='{$request->slug}' and id!=$id) existe")[0]->existe;

        if($existe){
            $errors[] = "El slug ya existe, debe ingresar un slug unico.";
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return redirect('roles-modificar/'.$id)->withInput();
        }

        $role = Roles::find($id);
        $role->name = $request->name;
        $role->slug = $request->slug;
        $role->description = $request->description;
        
        $role->special = $request->special;
        $role->save();
        
        return redirect("roles-modificar/".$id);

    }

    public function destroy(Request $request, $id)
    {
        //echo $id;die;
        \DB::select("DELETE FROM permission_role where role_id=$id");
        \DB::select("DELETE FROM roles where id=$id");
        
        return redirect('roles');
    }

    public function permisos($id)
    {
        
        $role = Roles::find($id);
        $permisos = Roles::getPermisos($id);
        return view('usuario-admin/role-asignar-permisos')
                    ->with("permisos",$permisos)
                    ->with("role",$role);
    }

    public function asignarPermisos(Request $request, $id){
        $role = Role::find($id);
        
        $role->permissions()->sync($request->asignar);
        return redirect("roles-asignar-permisos/".$id);
    }

    public function formularioBuscar(){
        
        return view("usuario/form-buscar");
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
