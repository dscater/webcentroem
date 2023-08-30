<?php

namespace App\Http\Controllers\ModuloPlanilla\GenerarPlanilla;

use App\Http\Controllers\ModuloPlanilla\GenerarPlanilla\GenerarPlanilla;
use App\Helpers\FuncionesComunes;
use App\Models\Planilla;
use App\Models\PlanillaDescuento;
use App\Models\PlanillaParametros;
use App\Models\PlanillaTrabajo;
use App\Models\PlanillaTributaria;

class GenerarPlanillaCaso2 extends GenerarPlanilla
{
    public function __construct($planilla_cabecera, $contrato, $planilla_parametros){
        $this->funcionesComunes = new FuncionesComunes();
        $this->planilla_cabecera = $planilla_cabecera;
        $this->gestion = $planilla_cabecera->gestion;
        $this->mes = $planilla_cabecera->mes;
        $this->contrato = $contrato;
        $this->planilla_parametros = $planilla_parametros;
    }
    
    private function setParametrosContrato(){
        $this->parametros_contrato = Planilla::getParametrosContratoCaso2($this->contrato->id, $this->gestion, $this->mes);
        $this->parametros_descuentos = PlanillaDescuento::getDescuentosByContrato($this->contrato->id);
        $this->fechaNacimiento = $this->parametros_contrato->fecha_nacimiento;
        $this->jubilado = $this->parametros_contrato->jubilado;
        $this->aportaAfp = $this->parametros_contrato->aporta_afp;
        $this->diasFalta = $this->parametros_contrato->dias_falta;
        $this->entidadAseguradora = $this->parametros_contrato->id_caja_salud;
        //parametros de planilla
        $this->porcentajeImpuesto = $this->planilla_parametros->iva;
        $this->porcentajeSeguroSocialObligatorio = $this->planilla_parametros->caja_salud;
        $this->porcentajeProVivienda = $this->planilla_parametros->provivienda;
        $this->porcentajeAportePatronalSolidario = $this->planilla_parametros->aporte_solidario;
        $this->porcentajeRiesgoProfesional = $this->planilla_parametros->riesgo_profesional;
        $this->porcentajeBeneficioSocialAguinaldo = $this->planilla_parametros->prevision_aguinaldo;
        $this->porcentajeBeneficioSocialIndeminizacion = $this->planilla_parametros->prevision_indeminizaciones;
        $this->ufvActual = 2.20982;
        $this->ufvAnterior = 2.20681;

    }

    public function validar(){
        // validar si esta aprobado
    }

    public function procesar(){
        $this->setParametrosContrato();
        $this->setFechaLastDayPlanilla();
        $this->calcularDiasTrabajados();
        $this->calcularHaberBasico($this->parametros_contrato->haber_basico);
        $this->calcularBonoAntiguedad($this->parametros_contrato->porcentaje_antiguedad);
        $this->calcularTotalGanado();
        $this->calcularParametrosAfp();
        $this->calcularTotalDescuentoLey();
        $this->calcularSueldoNeto();
        $this->calcularPlanillaPatronal();
        $this->calcularPlanillaTributaria();
        $this->calcularDescuentos();
        $this->calcularLiquidoPagable();
        /*echo "bono: ".$this->bonoAntiguedad."<br>";
        echo "contrato: ".$contrato->id."<br>";
        echo "%: ".round($this->parametros_contrato->porcentaje_antiguedad, 2)."<br>";
        echo "anio: ".$this->parametros_contrato->anio_antiguedad."<br>";
        echo "descuento de ley: ".$this->totalDescuentoDeLey."<br>";
        echo "sueldo neto: ".$this->sueldoNeto."<br>";
        echo "dias de falta: ".$this->parametros_contrato->dias_falta."<br>";*/
        $this->setPlanilla();
        $this->setPlanillaTrabajo();
        $this->setPlanillaTributaria();
        $this->updateSaldoFavor();
    }

    public function setPlanilla(){
        $planilla = new Planilla();
        $planilla->id_contrato_personal = $this->contrato->id;
        $planilla->id_planilla_cabecera = $this->planilla_cabecera->id;
        $planilla->id_persona = $this->contrato->id_persona;
        $planilla->laboral_haber_basico = $this->haberBasico;
        $planilla->laboral_dias_trabajado = $this->diasTrabajados;
        $planilla->laboral_dias_falta = $this->diasFalta;
        $planilla->laboral_anios_antiguedad = $this->parametros_contrato->anio_antiguedad;
        $planilla->laboral_bono_antiguedad = $this->bonoAntiguedad;
        $planilla->laboral_total_ganado = $this->totalGanado;

        $planilla->laboral_descuentos_de_ley = $this->totalDescuentoDeLey;
        $planilla->laboral_sueldo_neto = $this->sueldoNeto;

        $planilla->patronal_aporte_patronal_cns = $this->seguroSocialObligatorio;
        $planilla->patronal_id_entidad_aseguradora = $this->entidadAseguradora;
        $planilla->patronal_aporte_patronal_afp = $this->riesgoProfesional;
        $planilla->patronal_aporte_patronal_provivienda = $this->proVivienda;
        $planilla->patronal_aporte_patronal_solidario = $this->aportePatronalSolidario;
        $planilla->patronal_aporte_patronal_total = $this->totalAportesPatronales;
        $planilla->patronal_beneficio_social_aguinaldo = $this->beneficioSocialAguinaldo;
        $planilla->patronal_beneficio_social_indeminizacion = $this->beneficioSocialIndeminizacion;
        $planilla->patronal_beneficio_social_total = $this->totalBeneficioSocial;
        $planilla->patronal_total_carga_social = $this->totalCargaSocial;

        $planilla->afp_edad = $this->edad;
        $planilla->afp_porcentaje_descuento_de_ley = $this->afpPorcentajeDescuentoDeLey;
        $planilla->afp_comision = $this->afpComision;
        $planilla->afp_cotizacion_mensual = $this->afpCotizacionMensual;
        $planilla->afp_aporte_solidario = $this->afpAporteSolidario;
        $planilla->afp_riesgo_comun = $this->afpRiesgoComun;

        $planilla->id_banco = $this->parametros_contrato->id_banco;
        $planilla->numero_cuenta_bancaria = $this->parametros_contrato->banco_numero_cuenta;
        $planilla->id_caja_salud = $this->parametros_contrato->id_caja_salud;
        $planilla->caja_salud_numero_asegurado = $this->parametros_contrato->caja_salud_numero_asegurado;
        $planilla->id_entidad_afp = $this->parametros_contrato->id_entidad_afp;
        $planilla->afp_numero_nua = $this->parametros_contrato->numero_afp;

        $planilla->laboral_rc_iva = $this->impuestoPagar;
        $planilla->laboral_descuento_anticipos = $this->descuentoAnticipos;
        $planilla->laboral_descuento_varios = $this->descuentoVarios;
        $planilla->laboral_descuento_retencion_judicial = $this->descuentoRetencionJudicial;
        $planilla->laboral_descuento_sanciones = $this->descuentoSancion;        
        $planilla->laboral_descuento_total = $this->descuentoTotal;
        $planilla->laboral_liquido_pagable = $this->liquidoPagable;

        //dd($planilla);
        $planilla->save();
        //$planilla, $planilla_trabajo, $planilla_tributaria
    }

    private function setPlanillaTrabajo(){
        $planilla_trabajo = new PlanillaTrabajo();
        $planilla_trabajo->id_planilla_cabecera = $this->planilla_cabecera->id;
        $planilla_trabajo->id_contrato_personal = $this->parametros_contrato->id_contrato_personal;
        $planilla_trabajo->dias_trabajado = $this->diasTrabajados;
        $planilla_trabajo->dias_falta = $this->diasFalta;
        $planilla_trabajo->descuentos = $this->descuentoSancion;
        //dd($planilla_trabajo);
        $planilla_trabajo->save();
    }

    private function setPlanillaTributaria(){
        $planilla_tributaria = new PlanillaTributaria();
        $planilla_tributaria->id_planilla_cabecera = $this->planilla_cabecera->id;
        $planilla_tributaria->id_persona = $this->contrato->id_persona;
        $planilla_tributaria->tributaria_sueldo_neto = $this->tributariaSueldoNeto;
        $planilla_tributaria->minimo_no_imponible = $this->minimoNoImponible;
        $planilla_tributaria->diferencia_sujeto_a_impuesto = $this->diferenciaSujetoImpuesto;
        $planilla_tributaria->tributaria_impuesto = $this->impuesto;
        $planilla_tributaria->iva_declaracion_jurada = $this->formulario110;
        $planilla_tributaria->iva_dos_salarios_minimos = $this->impuestoMinimoNoImponible;
        $planilla_tributaria->saldo_favor_fisco = $this->fisco;
        $planilla_tributaria->saldo_favor_dependiente = $this->saldoFavorDependiente;
        $planilla_tributaria->saldo_favor_mes_anterior = $this->saldoMesAnterior;
        $planilla_tributaria->actualizacion_mes_anterior = $this->actualizacionMesAnterior;
        $planilla_tributaria->total_saldo_favor_mes_anterior = $this->saldoTotalMesAnterior;
        $planilla_tributaria->saldo_total_favor_dependiente = $this->saldoTotalFavorDependiente;
        $planilla_tributaria->saldo_utilizado = $this->saldoUtiliazado;
        $planilla_tributaria->impuesto_retenido_a_pagar = $this->impuestoPagar;
        $planilla_tributaria->saldo_dependiente_mes_siguiente = $this->saldoMesSiguiente;
        //dd($planilla_tributaria);
        $planilla_tributaria->save();
    }

    private function updateSaldoFavor(){
        \DB::select("UPDATE persona 
                set saldo_favor_impuestos={$this->saldoMesSiguiente}
                where id = {$this->contrato->id_persona}");
        \DB::select("UPDATE impuestos 
            set saldo_favor={$this->saldoMesSiguiente}
            where id = {$this->contrato->id_persona}
            and gestion={$this->planilla_cabecera->gestion}
            and mes={$this->planilla_cabecera->mes}");
            
    }
    
    
    

}
