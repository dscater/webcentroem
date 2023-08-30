<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Persona;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;
use Session;

class UsuarioController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = \DB::select("SELECT p.*,r.name rol, u.*, p.email,e.especialidad
                        from users u
                        join persona p on p.id_user=u.id
                        join roles r on p.id_role = r.id
                        left join especialidad e on p.id_especialidad=e.id
                        where u.state=1 and r.id != 4
                        order by u.id desc");
        return view('usuario.listar')->with('users',$users);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = \DB::select("SELECT * FROM roles where id != 4");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");

        return view('usuario.crear')
                    ->with("roles", $roles)
                    ->with("especialidad", $especialidad);
    }
    
    public function store(Request $request)
    {   

        $validaciones = [
            'nombre' => 'required',
            'direccion' => 'required', 
            'ci' => 'required|numeric|digits_between:1, 10', 
            'celular' => 'required|numeric|digits_between:1, 10',
            'telefono' => 'required|numeric|digits_between:1, 10',
            'email' => 'nullable|email',
            'foto' => 'required',
        ];

        if($request->id_role==3){
            $validaciones["id_especialidad"] = "required"; 
        }

        $validator = \Validator::make($request->all(),$validaciones);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de registrar.');
            \Session::flash('class-alert','danger');
            return redirect('usuario-nuevo')
                        ->withErrors($validator)
                        ->withInput();
        }

        

        if($request->id_role==1){
            $name_user = \DB::select("SELECT case when max(codigo) is null then 10001 else max(codigo)+1 end codigo from codigo_usuario where id_role=1")[0]->codigo;
        }
        else if($request->id_role==2){
            $name_user = \DB::select("SELECT case when max(codigo) is null then 20001 else max(codigo)+1 end codigo from codigo_usuario where id_role=2")[0]->codigo;
        }
        else if($request->id_role==3){
            $name_user = \DB::select("SELECT case when max(codigo) is null then 30001 else max(codigo)+1 end codigo from codigo_usuario where id_role=3")[0]->codigo;
        }
        
        \DB::select("INSERT into codigo_usuario values (null,$name_user, $request->id_role)");

        $persona = new Persona();
        
        $persona->nombre = strtoupper(trim($request->nombre));
        $persona->paterno = strtoupper(trim($request->paterno));
        $persona->materno = strtoupper(trim($request->materno));
        $persona->ci = strtoupper(trim($request->ci));
        $persona->telefono = strtoupper($request->telefono);
        $persona->celular = strtoupper($request->celular);
        $persona->direccion = strtoupper(trim($request->direccion));
        $persona->email = trim($request->email);
        $persona->id_role = $request->id_role;
        if($request->id_role==3){
            $persona->id_especialidad = $request->id_especialidad; 
        }

        if(!empty($request->foto))
        {
        	//creacion de nombre para el archivo
            $nombre_imagen=time()."_".$request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;    
            //guardar el archivo
            \Storage::disk("public_img")->put("fotoPersona/".$nombre_imagen,file_get_contents($request->foto->getRealPath()));  
            
        }

        $persona->state = 1;
        $persona->save();

        $persona = Persona::find($persona->id);

        $string = $persona->ci;
        $ci_int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);  

        $user = new Usuario();
        $user->name = $name_user;
        $user->email = $name_user.'@sis.net';
        $user->password = \Hash::make($ci_int);
        $user->state = 1;
        $user->save();

        $persona->id_user = $user->id;
        $persona->save();

        
        $rolUser = new RoleUser();
        
        $rolUser->role_id = $request->id_role;
        $rolUser->user_id = $user->id;
        $rolUser->state = 1;
        $rolUser->save();

        \Session::flash('mensaje','Se registro correctamente el usuario.');
        \Session::flash('class-alert','success');
        return redirect('usuario-modificar/'.$user->id);
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = Usuario::find($id);
        $roles = \DB::select("SELECT * FROM roles where id != 4");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");
        $persona = \DB::select("SELECT p.* FROM persona p
                                where p.id_user=$id")[0];
        if(!empty($persona->foto)) {
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        return view('usuario.editar')
                    ->with("persona", $persona)
                    ->with("roles", $roles)
                    ->with("especialidad", $especialidad)
                    ->with("user", $user);
    }

    public function update(Request $request, $id)
    {   
        $validaciones = [
            'nombre' => 'required',
            'ci' => 'required', 
            'direccion' => 'required', 
            'celular' => 'required|numeric',
            'email' => 'nullable|email',
            'telefono' => 'required',
        ];

        if($request->id_role==3){
            $validaciones["id_especialidad"] = "required"; 
        }
        $validator = \Validator::make($request->all(),$validaciones);
        
        if ($validator->fails()) {
            \Session::flash('mensaje','No se realizo la acción de actualización.');
            \Session::flash('class-alert','danger');
            return redirect("usuario-modificar/".$id)
                        ->withErrors($validator)
                        ->withInput();
        }
        
        

        $id_persona = \DB::select("SELECT id from persona where id_user=$id")[0]->id;

        $persona = Persona::find($id_persona);
        
        $persona->nombre = strtoupper(trim($request->nombre));
        $persona->paterno = strtoupper(trim($request->paterno));
        $persona->materno = strtoupper(trim($request->materno));
        $persona->ci = strtoupper(trim($request->ci));
        $persona->telefono = strtoupper($request->telefono);
        $persona->celular = strtoupper($request->celular);
        $persona->direccion = strtoupper(trim($request->direccion));
        $persona->email = trim($request->email);
        $persona->id_role = $request->id_role;
        if($request->id_role==3){
            $persona->id_especialidad = $request->id_especialidad; 
        }
        else{
            $persona->id_especialidad = null; 
        }

        if(!empty($request->foto))
        {
        	//creacion de nombre para el archivo
            $nombre_imagen=time()."_".$request->foto->getClientOriginalName();
            //asignacion del nombre
            $persona->foto = $nombre_imagen;    
            //guardar el archivo
            \Storage::disk("public_img")->put("fotoPersona/".$nombre_imagen,file_get_contents($request->foto->getRealPath()));  
            
        }

        //$persona->estado = 'ACTIVO';
        $persona->save();

        
        $user = Usuario::find($id);
        
        if(!empty($request->password)){
            $user->password = \Hash::make($request->password);
        }
        
        
        $user->save();    
        
        
        \DB::select("UPDATE role_user set role_id={$request->id_role} where user_id=$id");
        \Session::flash('mensaje','Se actualizo correctamente los datos del Usuario.');
        \Session::flash('class-alert','success');

        return redirect('usuario-modificar/'.$id);    
    }

    public function show($id)
    {
        $user = Usuario::find($id);
        $roles = \DB::select("SELECT * FROM roles where id != 4");
        $especialidad = \DB::select("SELECT * FROM especialidad where state=1");
        $persona = \DB::select("SELECT p.* FROM persona p
                                where p.id_user=$id")[0];
        if(!empty($persona->foto)) {
            $persona->foto = url("fotoPersona/".$persona->foto);
        }
        else{
            $persona->foto = url("img/user-avatar.png");
        }
        return view('usuario.ver')
                    ->with("persona", $persona)
                    ->with("roles", $roles)
                    ->with("especialidad", $especialidad)
                    ->with("user", $user);
        
    }

    public function delete($id)
    {
        \DB::select("UPDATE users set state = 0 where id=$id");
        \Session::flash('mensaje','Se elimino correctamente el registro.');
        \Session::flash('class-alert','success');

        return redirect('usuario-form-buscar');
    }

    public function miPerfil(Request $request){
        
        $usuario = Usuario::find(auth()->user()->id);
        return view('usuario/perfil')
                    ->with("usuario",$usuario);
        
        
    }

    public function modificarMiPerfil(Request $request){
        

        $validator = \Validator::make($request->all(),[
            'password' => 'required|min:8',
            'password_old' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect('/perfil-usuario')
                        ->withErrors($validator)
                        ->withInput();
        }

        $usuario = Usuario::find(auth()->user()->id);

        if (!\Hash::check($request->password_old, $usuario->password)) {
            \Session::flash('mensaje','La clave actual no es correcta.');
            \Session::flash('class-alert','warning');
            return redirect("/perfil-usuario");
        }

        
        \Session::flash('mensaje','Se actualizo correctamente la clave del usuario.');
        \Session::flash('class-alert','success');
        $usuario->password = \Hash::make($request->password);

        $usuario->save();
        
        return redirect("/perfil-usuario");

    }
}
