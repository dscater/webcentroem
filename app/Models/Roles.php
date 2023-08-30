<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = "roles";


    public static function getPermisos($id_role){
        return \DB::select("SELECT p.id,p.name,p.slug,p.description,
                case when (SELECT pr.id
                            from permission_role pr where pr.permission_id=p.id and pr.role_id=$id_role) 
                        is not null then 'si' else 'no' end  asignado,
                (SELECT pr.id
                from permission_role pr where pr.permission_id=p.id and pr.role_id=$id_role) id_permission_role
                from permissions p");
    }
    
}
