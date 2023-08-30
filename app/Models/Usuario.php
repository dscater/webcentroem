<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    protected $table = "users";
    
    public static function getRolesByUsuario($id_usuario){
        return \DB::select("SELECT *
                from roles r
                inner join role_user ru on r.id=ru.role_id
                where ru.user_id=$id_usuario");
    }

    public static function getRoles($id_usuario){
        return \DB::select("SELECT r.id,r.name,r.slug, 
                case when (SELECT  ru.id
                            from role_user ru where ru.role_id=r.id and ru.user_id=$id_usuario) 
                        is not null then 'si' else 'no' end  asignado,
                (SELECT ru.id
                from role_user ru where ru.role_id=r.id and ru.user_id=$id_usuario) id_role_user
                from roles r");
    }

    public static function verificarPermiso($slug){
        $id_usuario = auth()->id();

        $noAccess = \DB::select("SELECT 1
                        from role_user ru
                        inner join roles r  on ru.role_id=r.id
                        where ru.user_id=$id_usuario and r.special='no-access'");

        if(!empty($noAccess)){
            return false;
        }

        $allAccess = \DB::select("SELECT 1
                        from role_user ru
                        inner join roles r  on ru.role_id=r.id
                        where ru.user_id=$id_usuario and r.special='all-access'");

        if(!empty($allAccess)){
            return true;
        }

        return \DB::select("SELECT exists (SELECT 1
                    from
                    (SELECT r.slug
                    from role_user ru
                    inner join roles r  on ru.role_id=r.id
                    where ru.user_id=$id_usuario and r.slug='$slug'
                    union
                    SELECT p.slug
                    from role_user ru
                    inner join roles r  on ru.role_id=r.id
                    inner join permission_role pr  on r.id=pr.role_id
                    inner join permissions p  on pr.permission_id=p.id
                    where ru.user_id=$id_usuario and p.slug='$slug') tabla
                    where slug='$slug') existe")[0]->existe; //retorna true or false
    }

    public static function getPermiso(){
        $id_usuario = auth()->id();

        $noAccess = \DB::select("SELECT 1
                        from role_user ru
                        inner join roles r  on ru.role_id=r.id
                        where ru.user_id=$id_usuario and r.special='no-access'");

        if(!empty($noAccess)){
            return array();
        }

        $allAccess = \DB::select("SELECT 1
                        from role_user ru
                        inner join roles r  on ru.role_id=r.id
                        where ru.user_id=$id_usuario and r.special='all-access'");

        if(!empty($allAccess)){
            //retornar todos los roles y permisos
            return \DB::select("SELECT DISTINCT slug 
                    from (SELECT r.slug
                    from role_user ru
                    inner join roles r  on ru.role_id=r.id
                    union
                    SELECT p.slug
                    from role_user ru
                    inner join roles r  on ru.role_id=r.id
                    inner join permission_role pr  on r.id=pr.role_id
                    inner join permissions p  on pr.permission_id=p.id) tabla");
        }
        //retornar los roles y permisos del usuario
        return \DB::select("SELECT DISTINCT slug
                    from (SELECT r.slug
                    from role_user ru
                    inner join roles r  on ru.role_id=r.id
                    where ru.user_id=$id_usuario
                    union
                    SELECT p.slug
                    from role_user ru
                    inner join roles r  on ru.role_id=r.id
                    inner join permission_role pr  on r.id=pr.role_id
                    inner join permissions p  on pr.permission_id=p.id
                    where ru.user_id=$id_usuario) tabla");
    }
    
}
