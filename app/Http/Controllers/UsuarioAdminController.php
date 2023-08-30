<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Consultas;
use App\Models\Contrato;
use App\Models\Persona;
use App\Models\Usuario;
use App\Models\RoleUser;

use App\Models\Catalogos;
use App\Helpers\FuncionesComunes;
use Illuminate\Support\Facades\Validator;
use Storage;
class UsuarioAdminController extends Controller
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

    
    public function nuevo($id_persona)
    {
        $tipo_doc_iden = Catalogos::getCatalogo("tipo_doc_iden", "id, tipo","state=true");
        $departamento = Catalogos::getCatalogo("departamento", "id, departamento, abrev1","state=true");
        $mes = Catalogos::getCatalogo("mes", "id, mes","state=true");
        $catalogo_nacion = Catalogos::getCatalogo("catalogo_nacion", "id, nacionalidad","state=true");
        
        $persona = Catalogos::getCatalogo("persona", "*","id=$id_persona")[0];
        if(!empty($persona->foto)){
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        
        return view('usuario/nuevo')
                    ->with("tipo_doc_iden",$tipo_doc_iden)
                    ->with("departamento",$departamento)
                    ->with("mes",$mes)
                    ->with("catalogo_nacion",$catalogo_nacion)
                    ->with("persona",$persona);
    }
    public function registrarNuevo(Request $request){

        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'password' => 'required',
        ]);
        
        if ($validator->fails()) {
            return redirect('usuario-nuevo/'.$request->id_persona)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        $persona = Persona::find($request->id_persona);

        if($persona->id_user!=null){
            $errors[] = "La persona ya tiene asignado un usuario.";
            \Session::flash('mensaje', $errors);
            \Session::flash('class-alert', "danger");
            return redirect('usuario-nuevo/'.$persona->id)->withInput();
        }

        $usuario = new usuario();
        $usuario->name = $persona->nombre1.$persona->numero_documento;
        $usuario->email = $request->email;
        $usuario->password = \Hash::make($request->password);
        $usuario->state = true;
        $usuario->save();

        $persona->id_user = $usuario->id;
        $persona->email = $usuario->email;
        $persona->save();
        
        return redirect("usuario-modificar/".$usuario->id);

    }

    public function modificar($id)
    {
        $tipo_doc_iden = Catalogos::getCatalogo("tipo_doc_iden", "id, tipo","state=true");
        $departamento = Catalogos::getCatalogo("departamento", "id, departamento, abrev1","state=true");
        $mes = Catalogos::getCatalogo("mes", "id, mes","state=true");
        $catalogo_nacion = Catalogos::getCatalogo("catalogo_nacion", "id, nacionalidad","state=true");
        $id_persona = Persona::getIdPersonaByIdUsuario($id);
        $persona = Persona::find($id_persona);
        if(!empty($persona->foto)){
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        $usuario = Usuario::find($id);
        return view('usuario/modificar')
                    ->with("tipo_doc_iden",$tipo_doc_iden)
                    ->with("departamento",$departamento)
                    ->with("mes",$mes)
                    ->with("catalogo_nacion",$catalogo_nacion)
                    ->with("persona",$persona)
                    ->with("usuario",$usuario);
    }

    public function registrarModificacion(Request $request, $id){
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return redirect('usuario-modificar/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $usuario = Usuario::find($request->id);
        $usuario->email = $request->email;
        if(!empty($request->password)){
            $usuario->password = \Hash::make($request->password);
        }
        $usuario->save();

        $persona = Persona::find($request->id_persona);
        $persona->email = $request->email;
        $persona->save();
        
        return redirect("usuario-modificar/".$id);

    }

    public function roles($id)
    {
        $tipo_doc_iden = Catalogos::getCatalogo("tipo_doc_iden", "id, tipo","state=true");
        $departamento = Catalogos::getCatalogo("departamento", "id, departamento, abrev1","state=true");
        $mes = Catalogos::getCatalogo("mes", "id, mes","state=true");
        $catalogo_nacion = Catalogos::getCatalogo("catalogo_nacion", "id, nacionalidad","state=true");
        $id_persona = Persona::getIdPersonaByIdUsuario($id);
        $persona = Persona::find($id_persona);
        if(!empty($persona->foto)){
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        $usuario = Usuario::find($id);
        $roles = Usuario::getRoles($id);
        return view('usuario/asignar-roles')
                    ->with("tipo_doc_iden",$tipo_doc_iden)
                    ->with("departamento",$departamento)
                    ->with("mes",$mes)
                    ->with("catalogo_nacion",$catalogo_nacion)
                    ->with("persona",$persona)
                    ->with("roles",$roles)
                    ->with("usuario",$usuario);
    }

    public function asignarRoles(Request $request, $id){
        
        $validator = Validator::make($request->all(),[
            'asignar' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect('usuario-asignar-roles/'.$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        if($request->asignar=="Si"){
            $existe = \DB::select("SELECT exists (SELECT 1 FROM role_user 
                                    where role_id={$request->role_id} and user_id={$id}) existe")[0]->existe;
            if(!$existe){
                $role_user = new RoleUser();
                $role_user->role_id = $request->role_id;
                $role_user->user_id = $id;
                $role_user->state = true;
                $role_user->save();
            }
            
        }
        else{
            if($request->id_role_user!=null){
                $role_user = RoleUser::find($request->id_role_user);
                if(!empty($role_user->id))
                    $role_user->delete();
            }
            
        }
        
        
        return redirect("usuario-asignar-roles/".$id);

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
        
        return view("usuario/form-buscar")
                ->with("persona", $persona)
                ->with("usuario", $usuario)
                ->with("roles", $roles)
                ->with("numero_documento",$request->numero_documento);
    }

    public function miPerfil(Request $request){
        $tipo_doc_iden = Catalogos::getCatalogo("tipo_doc_iden", "id, tipo","state=true");
        $departamento = Catalogos::getCatalogo("departamento", "id, departamento, abrev1","state=true");
        $mes = Catalogos::getCatalogo("mes", "id, mes","state=true");
        $catalogo_nacion = Catalogos::getCatalogo("catalogo_nacion", "id, nacionalidad","state=true");
        $id_persona = Persona::getIdPersonaByIdUsuario(auth()->user()->id);
        $persona = Persona::find($id_persona);
        if(!empty($persona->foto)){
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        $usuario = Usuario::find(auth()->user()->id);
        return view('usuario/perfil')
                    ->with("tipo_doc_iden",$tipo_doc_iden)
                    ->with("departamento",$departamento)
                    ->with("mes",$mes)
                    ->with("catalogo_nacion",$catalogo_nacion)
                    ->with("persona",$persona)
                    ->with("usuario",$usuario);
        
        
    }

    public function modificarMiPerfil(Request $request){
        
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'nullable|min:8'
        ]);

        if ($validator->fails()) {
            return redirect('/perfil-usuario')
                        ->withErrors($validator)
                        ->withInput();
        }

        $usuario = Usuario::find(auth()->user()->id);
        $usuario->email = $request->email;
        if(!empty($request->password)){
            $usuario->password = \Hash::make($request->password);
        }
        $usuario->save();

        $persona = Persona::find($request->id_persona);

        if($request->foto!=null&&$request->foto!="null") {
        	//creacion de nombre para el archivo
            $nombre_imagen=time()."_".$request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;    
            //guardar el archivo
            Storage::disk("public_img")->put("fotoPersona/".$nombre_imagen,file_get_contents($request->foto->getRealPath()));  
            
        }
        
        $persona->email = $request->email;
        $persona->save();
        
        return redirect("/perfil-usuario");

    }
}
