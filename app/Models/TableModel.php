<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\log;
use App\Models\Admin\users;


class TableModel extends Model
{

    public static function columnas_by_tabla($tabla)
    {
        $db = \DB::select("SELECT DATABASE() db")[0]->db;
    	return \DB::select("SELECT * 
    						FROM INFORMATION_SCHEMA.COLUMNS 
                            WHERE table_name = '$tabla'
                            and table_schema = '$db' ");
    }
    public static function registros_by_tabla($tabla,$where="")
    {
        //\DB::unprepared("SET SQL_BIG_SELECTS=1");
    	return \DB::select("SELECT * 
    						FROM $tabla
    						where 1=1 					     						
    						$where 
                            order by created_at desc");
    }
    public static function max_id_by_tabla($tabla)
    {
        $id= \DB::select("SELECT max(id) id
                            FROM $tabla")[0]->id;
        if($id)
        {
            return $id;
        }   
        else
        {
            return 0;
        }
    }
    public static function insertar($tabla,$datos)
    {
        $datos=(array) $datos;
        $campo="";
        $dato="";
        foreach ($datos as $key => $value) {       
            $campo .= $key . ",";
            if($value != null) {
                $dato .= (gettype($value)=="string") ? "'".str_replace("'", "''", strtoupper($value))."'," : $value.",";
            }
            else {
                $dato .= "null,";
            }
        }
        $campo = substr($campo, 0, strlen($campo)-1);
        $dato = substr($dato, 0, strlen($dato)-1);
        
        $query="INSERT into $tabla ($campo) values ($dato)";
        //echo $query;die;
        //TableModel::log("descripcion",$tabla,$query,"");
        return \DB::select($query);
    }
    public static function actualizar($tabla,$datos,$id='',$dato_id='',$condicional='')
    {
        $datos=(array) $datos;
        $tamanio=count($datos);     
        $i=1;
        $campo="";
        $dato="";
        foreach ($datos as $key => $value) {
            $campo.=$key."=";
            if($value!=null) {
                (gettype($value)=="string")?$campo.="'".str_replace("'", "''", strtoupper($value))."'," : $campo.=$value.",";
            }
            else
            {
                $campo.="null,";
            }
        }   

        $campo = substr($campo, 0, strlen($campo)-1);

        $query="UPDATE $tabla SET $campo where 1=1 ";
        if($id!=''&&$dato_id)
        {
            $query.=" and $id='$dato_id'";
        }
        if($condicional!=''){
            $query.=' and '.$condicional;   
        }
        //TableModel::log("descripcion",$tabla,$query,"");
        \DB::select($query);
    }

    public static function log($descripcion,$tabla,$consulta,$datos)
    {
        
        $usuario=users::me();
        $log=new log();
        $log->log=$descripcion;
        $log->tabla=$tabla;
        $log->consulta=$consulta;
        $log->datos=$datos;
        $log->id_usuario=$usuario->id;
        $log->id_persona=$usuario->id_persona;
        $log->save();
    }


}
