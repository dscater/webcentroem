<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Reportes\ReportePermisosPorRol;

use Hashids;
use Carbon\Carbon;

class ReportePermisosPorRolController extends Controller{
    
    

    public function reporte($id_rol){
        $data = (Object) array();
        

        $data->roles = 
                \DB::select("SELECT  r.* from  roles r where id=$id_rol order by r.id");

        $data->roles_permisos = 
                \DB::select("SELECT  r.name rol, p.*
                        from roles r
                        inner join permission_role pr on r.id=pr.role_id
                        inner join permissions p on pr.permission_id=p.id
                        where r.id=$id_rol
                        order by r.id,p.id");

        




        
        $reporte  = new ReportePermisosPorRol();
        $reporte->reporte($data);        


        
        //$nombre_file = $reporte->reporte($data);      

        /*$url = $this->generateUrl($nombre_file);
        return response()->json(["url" => $url]);*/
        
    }

    
}
