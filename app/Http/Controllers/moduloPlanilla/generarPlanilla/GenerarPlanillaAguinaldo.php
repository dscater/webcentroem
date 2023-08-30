<?php

namespace App\Http\Controllers\ModuloPlanilla\GenerarPlanilla;

use App\Models\PlanillaParametros;
use App\Models\Planilla;
use App\Models\Persona;


class GenerarPlanillaAguinaldo
{
    private $errors = array();
    public function __construct($planilla_cabecera){
        $this->planilla_cabecera = $planilla_cabecera;
    }
    public function validar(){
        if($this->planilla_cabecera->estado_planilla=="APROBADO"){
            $this->errors[] =  "La planilla de aguinaldo esta APROBADA. No se puede volver a generar la planilla.";
        }
        return $this->errors;
    }

    public function procesar(){
        //echo "procesando";die;
        \DB::select("DELETE FROM planilla 
                    where id_planilla_cabecera={$this->planilla_cabecera->id}");
                        
        $gestion = $this->planilla_cabecera->gestion;
        $personas = \DB::select("SELECT id_persona from
                                (select p.id_persona,
                                    exists(select 1 from planilla pp
                                            join planilla_cabecera ppc on pp.id_planilla_cabecera = ppc.id
                                            where ppc.gestion=$gestion and ppc.mes=10 and ppc.estado_planilla ='APROBADO' and ppc.id_tipo_planilla=1 and pp.id_persona = p.id_persona) oct,
                                    exists(select 1 from planilla pp
                                            join planilla_cabecera ppc on pp.id_planilla_cabecera = ppc.id
                                            where ppc.gestion=$gestion and ppc.mes=11 and ppc.estado_planilla ='APROBADO' and ppc.id_tipo_planilla=1 and pp.id_persona = p.id_persona) nov,
                                    1 dic
                                from planilla p 
                                join planilla_cabecera pc on p.id_planilla_cabecera = pc.id
                                where pc.gestion=$gestion and pc.mes=12 and pc.estado_planilla ='APROBADO' and pc.id_tipo_planilla=1
                                group by id_persona) as tabla
                                where oct=1 and nov=1 and dic=1
                                order by id_persona");
           
        if(!empty($personas)){
            foreach($personas as $key=>$value){
                $id_persona = $value->id_persona;
                $this->persona = Persona::find($id_persona);
                $this->setSumTotalGanadoMensual($id_persona, $gestion);
                $this->setSumTotalDiasTrabajado($id_persona, $gestion);
                $this->savePlanilla($id_persona);
            }
        }
    }

    private function setSumTotalGanadoMensual($id_persona, $gestion){
        $this->sumTotalByMes = \DB::select("SELECT 
                        (select sum(laboral_total_ganado) from planilla p
                            join planilla_cabecera pc on p.id_planilla_cabecera = pc.id
                            where pc.gestion=$gestion and pc.mes=10 and pc.estado_planilla ='APROBADO' and pc.id_tipo_planilla=1 and p.id_persona = $id_persona) oct,
                        (select sum(laboral_total_ganado) from planilla p
                            join planilla_cabecera pc on p.id_planilla_cabecera = pc.id
                            where pc.gestion=$gestion and pc.mes=11 and pc.estado_planilla ='APROBADO' and pc.id_tipo_planilla=1 and p.id_persona = $id_persona) nov,
                            (select sum(laboral_total_ganado) from planilla p
                            join planilla_cabecera pc on p.id_planilla_cabecera = pc.id
                            where pc.gestion=$gestion and pc.mes=11 and pc.estado_planilla ='APROBADO' and pc.id_tipo_planilla=1 and p.id_persona = $id_persona) dic")[0];
        $this->aguinaldoPromedio = ($this->sumTotalByMes->oct + $this->sumTotalByMes->nov + $this->sumTotalByMes->dic)/3;
        
    }

    private function setSumTotalDiasTrabajado($id_persona, $gestion){
        $this->sumTotalDiasTrabajado = \DB::select("SELECT sum(p.laboral_dias_trabajado) dias
                                                    from planilla p 
                                                    inner join planilla_cabecera pc on p.id_planilla_cabecera = pc.id
                                                    where pc.gestion=$gestion
                                                    and pc.estado_planilla='APROBADO' 
                                                    and pc.id_tipo_planilla=1 and p.id_persona=$id_persona")[0]->dias;
        
    }

    private function savePlanilla($id_persona){
        $gestion = $this->planilla_cabecera->gestion;
        $planilla = new Planilla();
        $planilla->id_contrato_personal = 0;
        $planilla->id_planilla_cabecera = $this->planilla_cabecera->id;
        $planilla->id_persona = $id_persona;
        $planilla->laboral_haber_basico = 0;
        $planilla->laboral_dias_trabajado = 0;
        $planilla->laboral_dias_falta = 0;
        $planilla->laboral_anios_antiguedad = 0;
        $planilla->laboral_bono_antiguedad = 0;
        $planilla->laboral_porcentaje_antiguedad = 0;
        $planilla->laboral_horas_extra = 0;
        $planilla->laboral_monto_horas_extra = 0;
        $planilla->laboral_total_ganado = 0;

        $planilla->laboral_descuentos_de_ley = 0;
        $planilla->laboral_sueldo_neto = 0;

        $planilla->patronal_aporte_patronal_cns = 0;
        $planilla->patronal_id_entidad_aseguradora = 0;
        $planilla->patronal_aporte_patronal_afp = 0;
        $planilla->patronal_aporte_patronal_provivienda = 0;
        $planilla->patronal_aporte_patronal_solidario = 0;
        $planilla->patronal_aporte_patronal_total = 0;
        $planilla->patronal_beneficio_social_aguinaldo = 0;
        $planilla->patronal_beneficio_social_indeminizacion = 0;
        $planilla->patronal_beneficio_social_total = 0;
        $planilla->patronal_total_carga_social = 0;

        $planilla->afp_edad = 0;
        $planilla->afp_porcentaje_descuento_de_ley = 0;
        $planilla->afp_comision = 0;
        $planilla->afp_cotizacion_mensual = 0;
        $planilla->afp_aporte_solidario = 0;
        $planilla->afp_riesgo_comun = 0;

        $planilla->id_banco = $this->persona->id_banco;
        $planilla->numero_cuenta_bancaria = $this->persona->banco_numero_cuenta;
        $planilla->id_caja_salud = $this->persona->id_caja_salud;
        $planilla->caja_salud_numero_asegurado = $this->persona->caja_salud_numero_asegurado;
        $planilla->id_entidad_afp = $this->persona->id_entidad_afp;
        $planilla->afp_numero_nua = $this->persona->numero_afp;

        $planilla->laboral_rc_iva = 0;
        $planilla->laboral_descuento_anticipos = 0;
        $planilla->laboral_descuento_varios = 0;
        $planilla->laboral_descuento_retencion_judicial = 0;
        $planilla->laboral_descuento_sanciones = 0;        
        $planilla->laboral_descuento_total = 0;
        $planilla->laboral_liquido_pagable = $this->aguinaldoPromedio / 360 * $this->sumTotalDiasTrabajado;
        $planilla->aguinaldo_meses_calculados = "10-$gestion|11-$gestion|12-$gestion";
        $planilla->aguinaldo_primer_mes = $this->sumTotalByMes->oct;
        $planilla->aguinaldo_segundo_mes = $this->sumTotalByMes->nov;
        $planilla->aguinaldo_tercer_mes = $this->sumTotalByMes->dic;
        $planilla->aguinaldo_promedio = $this->aguinaldoPromedio;
        $planilla->aguinaldo_dias_trabajado = $this->sumTotalDiasTrabajado;
        $planilla->save();
    }

    

}
