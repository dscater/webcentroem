<?php

namespace App\Http\Controllers\ModuloPlanilla\GenerarPlanilla;

use App\Models\PlanillaParametros;
use App\Models\PlanillaDescuento;
use App\Models\Impuestos;
use App\Http\Controllers\ModuloPlanilla\SaveRowPlanilla\SavePlanillaCase1;

class GenerarPlanilla
{
    private $errors = array();
    public function __construct($planilla_cabecera){
        $this->planilla_cabecera = $planilla_cabecera;
    }
    public function validar(){
        if($this->planilla_cabecera->estado_planilla=="APROBADO"){
            $this->errors[] =  "La planilla esta APROBADA. No se puede volver a generar la planilla.";
        }
        return $this->errors;
    }

    public function procesar(){
        
        $planilla_parametros = PlanillaParametros::find($this->planilla_cabecera->id_planilla_parametros);
        PlanillaDescuento::createTemporalDescuento($this->planilla_cabecera->gestion, $this->planilla_cabecera->mes);
        \DB::select("UPDATE persona set id_entidad_afp=0 where id_entidad_afp is null"); 
        
        \DB::select("DELETE FROM planilla 
                    where id_planilla_cabecera={$this->planilla_cabecera->id}");
        \DB::select("DELETE FROM planilla_tributaria
                        where id_planilla_cabecera={$this->planilla_cabecera->id}");
        \DB::select("DELETE FROM planilla_trabajo
                        where id_planilla_cabecera={$this->planilla_cabecera->id}");
                        
        $this->registrarImpuestos($planilla_parametros);
        $contratos = \DB::select("SELECT * FROM contrato_personal 
                                    where estado_contrato='VIGENTE'");
        if(!empty($contratos)){
            foreach($contratos as $key=>$value){
                $id_tipo_contrato = $value->id_tipo_contrato;
                $sp = new SavePlanillaCase1($this->planilla_cabecera, $value, $planilla_parametros);
                $sp->procesar();
            }
        }
    }

    private function registrarImpuestos($planilla_parametros){
        $persona = \DB::select("SELECT p.id, p.saldo_favor_impuestos
                        FROM contrato_personal cp
                        inner join persona p on cp.id_persona=p.id
                        left join impuestos i on p.id=i.id_persona
                        where cp.estado_contrato='VIGENTE'
                        and i.id is null");
        if(!empty($persona)){
            foreach($persona as $key=>$value){
                $impuesto = new Impuestos();
                $impuesto->gestion = $this->planilla_cabecera->gestion;
                $impuesto->mes = $this->planilla_cabecera->mes;
                $impuesto->id_persona = $value->id;
                $impuesto->monto = 0;
                $impuesto->saldo_favor = 0;
                $impuesto->saldo_favor_mes_anterior = !empty($value->saldo_favor_impuestos)?$value->saldo_favor_impuestos:0;
                $impuesto->save();
            }
        }
    }

}
