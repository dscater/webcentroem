<?php

namespace App\Models;

class Catalogos
{
    
    public static function getCatalogo($tabla, $campos, $where=1){
        return \DB::select("SELECT $campos from $tabla where $where");
    }

    public static function getTipoDocIden(){
        return \DB::select("SELECT id, tipo 
                            from tipo_doc_iden where state=true");
    }
    public static function getDepartamento(){
        return \DB::select("SELECT id, departamento, abrev1 
                            from departamento where state=true");
    }
    public static function getMes(){
        return \DB::select("SELECT id, mes 
                            from mes where state=true");
    }
    public static function getCatalogoNacion(){
        return \DB::select("SELECT id, nacionalidad 
                            from catalogo_nacion where state=true");
    }
    public static function getBanco(){
        return \DB::select("SELECT id, banco 
                            from banco where state=true");
    }
    public static function getCajaSalud(){
        return \DB::select("SELECT id, caja_salud 
                            from caja_salud where state=true");
    }
    
}
