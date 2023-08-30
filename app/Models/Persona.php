<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = "persona";

    public static function personaByCarnet($numero_documento){
        return \DB::select("SELECT p.*, d.abrev1 expedido
            from persona p
            inner join departamento d on p.id_departamento=d.id
            where numero_documento='{$numero_documento}'");
    }
    public static function personaByLikeCarnet($numero_documento){
        return \DB::select("SELECT p.*, d.abrev1 expedido
            from persona p
            inner join departamento d on p.id_departamento=d.id
            where numero_documento like '%{$numero_documento}%'");
    }
    

    public static function personaCompletoById($id){
        return \DB::select("SELECT p.*,
                    tdi.tipo tipo_doc_iden,
                    d.abrev1 expedido,
                    cn.nacionalidad,
                    dn.departamento departamento_nac,
                    b.banco,
                    cs.caja_salud,
                    ea.descripcion entidad_afp,
                    case when ab.anio is null then 0 else ab.anio end anio_antiguedad,
                    case when ab.porcentaje is null then 0 else ab.porcentaje end porcentaje_antiguedad
                    FROM persona p
                    left join tipo_doc_iden tdi on p.id_tipo_doc_iden=tdi.id
                    left join departamento d on p.id_departamento=d.id
                    left join catalogo_nacion cn on p.id_nacion_nac=cn.id
                    left join departamento dn on p.id_departamento_nac=dn.id
                    left join banco b on p.id_banco=b.id
                    left join caja_salud cs on p.id_caja_salud=cs.id
                    left join entidad_afp ea on p.id_entidad_afp=ea.id
                    left join antiguedad_bono_persona abp on p.id=abp.id_persona
                    left join antiguedad_bono ab on abp.id_antiguedad_bono = ab.id
                    where p.id=$id")[0];
    }

    public static function getIdPersonaByIdUsuario($id_usuario){
        $r = \DB::select("SELECT id from persona where id_user=$id_usuario");
        if(!empty($r)){
            return $r[0]->id;
        }
        return null;
    }
    
}
