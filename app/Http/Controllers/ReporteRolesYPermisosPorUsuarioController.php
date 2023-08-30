<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reportes\ReporteRolesYPermisosPorUsuario;

use Hashids;
use Carbon\Carbon;

class ReporteRolesYPermisosPorUsuarioController extends Controller{
    
    

    public function reporte($id_usuario){
        $data = (Object) array();
        $data->usuario = 
                \DB::select("SELECT p.id id_persona,p.paterno, p.materno, p.nombre1, p.nombre2, p.numero_documento,p.fecha_nacimiento,
                     u.id id_usuario, u.email,u.state u_estado  from users u
                    inner join persona p on u.id=p.id_user
                    where  u.id=$id_usuario")[0];        

        $data->roles = 
                \DB::select("SELECT  r.*
                        from role_user ru 
                        inner join roles r on ru.role_id=r.id
                        where ru.user_id=$id_usuario
                        order by r.id");

        $data->roles_permisos = 
                \DB::select("SELECT  r.name rol, p.*
                        from role_user ru 
                        inner join roles r on ru.role_id=r.id
                        inner join permission_role pr on r.id=pr.role_id
                        inner join permissions p on pr.permission_id=p.id
                        where ru.user_id=$id_usuario
                        order by r.id,p.id");

        
        
        $reporte  = new ReporteRolesYPermisosPorUsuario();
        $reporte->reporte($data);        


        
        //$nombre_file = $reporte->reporte($data);      

        /*$url = $this->generateUrl($nombre_file);
        return response()->json(["url" => $url]);*/
        
    }

    
}
