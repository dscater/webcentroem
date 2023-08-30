<?php

namespace App\Http\Controllers\ModuloPlanilla\GenerarPlanilla;

use App\Http\Controllers\ModuloPlanilla\GenerarPlanilla\GenerarPlanilla;
use App\Helpers\FuncionesComunes;
use App\Models\Planilla;
use App\Models\PlanillaTrabajo;
use App\Models\PlanillaTributaria;

class GenerarPlanillaCaso1 extends GenerarPlanilla
{
    public $ci = "";
    public $datos = array();
    public $diasPorMes = '30';
    public $mesGestionPlanilla = "";
    public $fechaUltimoDiaPlanilla = "";
    public $fechaNacimiento = "";
    public $haberBasico = "";
    public $bonoAntiguedad = 0;
    public $aniosAntiguedad = 0;
    public $porcentajeAntiguedad = 0;
    public $salarioMinimoNacional = 0;
    public $numeroAsignaciones = 0;
    public $totalGanado = 0;
    private $arrayPorcentajeBonoAntiguedad = array();
    /* Variables para planilla LABORAL */
    public $reintegro = 0;
    public $reintegroBonoAntiguedad = 0;
    public $horasAsignadas = "";
    public $horasTrabajadas = "";
    public $horasFalta = "";
    public $diasTrabajadas = '30';
    public $jubilado = "";
    public $jubiladoNoAportaAfp = "";
    public $edad = 0;
    public $afpPorcentajeDescuentoDeLey = 0;
    public $cumple;
    public $afpCotizacionMensual = 0;
    public $afpComision = 0;
    public $afpAporteSolidario = 0;
    public $afpRiesgoComun = 0;
    public $totalDescuentoDeLey = 0;
    public $haberBasicoNivelDocente = 0;
    public $liquidoPagableDocente = 0;
    public $liquidoPagableAdministrativo = 0;
    public $sueldoNeto = 0;
    //control de datos 
    public $arrayTotalGanadoPersona = array();
    public $arrayHorasAsignadasObservados = array();
    public $arrayDiasTrabajadasPorAdministrativo = array();
    public $arrayBonoAntiguedadPorPersona = array();
    /* Variables para planilla LABORAL Y TRIBUTARIA */
    public $datosUpdateTablaTemporal = "";
    /* Variables para planilla TRIBUTARIA */
    public $tributariaSueldoNeto = 0;
    public $porcentajeImpuesto = 0; // valor de impuesto 13 %
    public $formulario110 = 0;
    public $saldoMesAnterior = 0;
    public $minimoNoImponible = 0;
    public $impuestoMinimoNoImponible = 0;
    public $ufvActual = 2.20982; 
    public $ufvAnterior = 2.20681;
    public $fisco = 0;

    public $saldoUtiliazado = 0;
    public $saldoUtilizado = 0;
    public $impuestoPagar = 0;
    public $saldoMesSiguiente = 0;
    public $diferenciaSujetoImpuesto = 0;
    public $impuesto = 0;
    public $saldoTotalFavorDependiente = 0;
    public $saldoFavorDependiente = 0;
    public $actualizacionMesAnterior = 0;
    public $saldoTotalMesAnterior = 0;

    /* Variables Planilla APORTES PATRONALES */
    public $seguroSocialObligatorio = 0;
    public $entidadAseguradora = 0;
    public $riesgoProfesional = 0;
    public $proVivienda = 0;
    public $aportePatronalSolidario = 0;
    public $totalAportesPatronales = 0;
    //aportes beneficios sociales
    public $beneficioSocialAguinaldo = 0;
    public $beneficioSocialIndeminizacion = 0;
    public $totalBeneficioSocial = 0;
    //Total planilla patronal
    public $totalCargaSocial = 0;
    
    //parametros para calculo de la planilla Patronal    
    public $porcentajeSeguroSocialObligatorio = 0; //caja salud
    public $porcentajeRiesgoProfesional = 1.71;
    public $porcentajeProVivienda = 2;
    public $porcentajeAportePatronalSolidario = 0.03;
    public $porcentajeBeneficioSocialAguinaldo = 8.33;
    public $porcentajeBeneficioSocialIndeminizacion = 8.33;
    
    /* variables descuento Docente y Administrativo */
    public $descuentoRetencionJudicial = 0;
    public $descuentoVarios = 0;
    public $descuentoTotalAdministrativo = 0;
    public $descuentoSancionAdministrativo = 0;
    public $planilla_registrado_persona = "";
    public $tipoPlanilla = "";
    
    // aplicado apartir de enero
    private $arrayMaximaRemuneracion = array(
        '761' => 360
    );

    public function __construct($planilla_cabecera){
        $this->planilla_cabecera = $planilla_cabecera;
        $this->antiguedadBono = $this->setPorcentajeAntiguedadBono();
        $this->gestion = $planilla_cabecera->gestion;
        $this->mes = $planilla_cabecera->mes;
        $this->id_tipo_planilla = $planilla_cabecera->id_tipo_planilla;

        if($this->id_tipo_planilla==1){
            $this->tipoPlanilla="REGULAR";
        }

        $this->fecha_limite_contrato = $planilla_cabecera->fecha_limite_contrato;

        $this->id_planilla = $planilla_cabecera->id;
        $this->planilla_parametros = \DB::select("SELECT * FROM planilla_parametros where state=1")[0];
        $this->funcionesComunes = new FuncionesComunes();
    }

    public function validar(){
        
        if ($this->planilla_cabecera->estado_planilla != 'PENDIENTE') {
            echo 'NO SE ACTUALIZARON LOS DATOS : ', 'No se puede actualizar los items de la planilla puesto que el estado de la planilla es APROBADO, comuniquese con el administrador del sistema';
        }
    }

    public function procesar(){
        // vaciar datos de planilla
        \DB::select("DELETE FROM planilla where id_planilla_cabecera={$this->id_planilla}");
        \DB::select("DELETE FROM planilla_tributaria where id_planilla_cabecera={$this->id_planilla}");
        \DB::select("DELETE FROM planilla_trabajo where id_planilla_cabecera={$this->id_planilla}");
        
        $this->set_planillas_laboral_patronal_tributaria_regular();
        
    }

    /*
     * Calculos para la planilla laboral
     */

    
    function set_planillas_laboral_patronal_tributaria_regular() {        
        $rowPlanilla = $this->planilla_cabecera;
        $rowParametrosPlanilla = $this->planilla_parametros;

        $this->datosUpdateTablaTemporal = array();
        $this->arrayHorasAsignadasObservados = array();
        $this->datos = array();
        $this->setPersonalRegular();
        
        // ivan aqui me quede
        $contratos = $this->getContratoPersonal();

        if (!empty($contratos)) {
            $datosSiacopPlanillaItemAdministrativo = array();
            $datosPlanillaLaboralPatronalAdministrativo = array();
            foreach ($contratos as $key=>$row) {
                
                //$idPlanillaItem = $idPlanilla . '-' . $row->id_asignacion_administrativo . '-A';
                $this->set_planilla_laboral($row, 'administrativo');
                $registro = new Planilla();
                $registro->id_contrato_personal = $row->id_contrato_personal;
                $registro->id_planilla_cabecera = $this->id_planilla;
                $registro->id_persona = $row->id_persona;
                $registro->laboral_haber_basico = $this->haberBasico;
                //$registro->laboral_reintegro = $this->reintegro;
                $registro->laboral_anios_antiguedad = $this->aniosAntiguedad;
                $registro->laboral_bono_antiguedad = $this->bonoAntiguedad;
                $$registro->laboral_porcentaje_antiguedad = $this->porcentajeAntiguedad;
                $registro->laboral_total_ganado = $this->totalGanado;
                $registro->laboral_descuentos_de_ley = $this->totalDescuentoDeLey;
                $registro->laboral_sueldo_neto = $this->sueldoNeto;
                

                $registro->patronal_aporte_patronal_cns = $this->seguroSocialObligatorio;
                $registro->patronal_id_entidad_aseguradora = $this->entidadAseguradora;
                $registro->patronal_aporte_patronal_afp = $this->riesgoProfesional;
                $registro->patronal_aporte_patronal_provivienda = $this->proVivienda;
                $registro->patronal_aporte_patronal_solidario = $this->aportePatronalSolidario;
                $registro->patronal_aporte_patronal_total = $this->totalAportesPatronales;
                $registro->patronal_beneficio_social_aguinaldo = $this->beneficioSocialAguinaldo;
                $registro->patronal_beneficio_social_indeminizacion = $this->beneficioSocialIndeminizacion;
                $registro->patronal_beneficio_social_total = $this->totalBeneficioSocial;
                $registro->patronal_total_carga_social = $this->totalCargaSocial;               

                $registro->afp_edad = $this->edad;
                $registro->afp_porcentaje_descuento_de_ley = $this->afpPorcentajeDescuentoDeLey;
                $registro->afp_comision = $this->afpComision;
                $registro->afp_cotizacion_mensual = $this->afpCotizacionMensual;
                $registro->afp_aporte_solidario = $this->afpAporteSolidario;
                $registro->afp_riesgo_comun = $this->afpRiesgoComun;
                $registro->id_banco = $row->id_banco;
                $registro->numero_cuenta_bancaria = $row->banco_numero_cuenta;
                $registro->id_caja_salud = $row->id_caja_salud;
                $registro->caja_salud_numero_asegurado = $row->caja_salud_numero_asegurado;
                $registro->id_entidad_afp = $row->id_entidad_afp;
                $registro->afp_numero_nua = $row->numero_afp;

                $datosPlanillaLaboralPatronalAdministrativo[$row->id_contrato_personal] = $registro;

                $planilla_trabajo = new PlanillaTrabajo();
                $planilla_trabajo->id_planilla_cabecera = $this->id_planilla;
                $planilla_trabajo->id_contrato_personal = $row->id_contrato_personal;
                $planilla_trabajo->dias_trabajado = $this->diasTrabajadas;
                $planilla_trabajo->dias_falta = $row->descuento_sancion_administrativo;
                $planilla_trabajo->descuentos = 0;
                $datosSiacopPlanillaItemAdministrativo[$row->id_contrato_personal] = $planilla_trabajo;
            }
        }

        $rowsPlanillaTributaria = array();
        
        if ($this->tipoPlanilla == 'REGULAR') {  // La planilla tributaria se calcula solo si es REGULAR en Adicional no se Genera
            
            $rowsTributaria = $this->get_filtrar_tributaria($this->gestion, $this->mes);
            
            if (!empty($rowsTributaria)) {
                foreach ($rowsTributaria as $key=>$row) {
                    $this->set_planilla_tributaria($row);

                    $planilla_tributaria = new PlanillaTributaria();
                    $planilla_tributaria->id_planilla_cabecera = $this->id_planilla;
                    $planilla_tributaria->id_persona = $row->id_persona;
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

                    $rowsPlanillaTributaria[$row->id_persona] = $planilla_tributaria;                    
                }
            } else {
                $this->datos['mensaje_tributaria'] = 'No existen datos para el calculo de la PLANILLA TRIBUTARIA';
            }
        }
        /*
         *  Calculo apartir de sueldo neto
         */
        $tablaPlanillaItem_laboralPatronalDocente = array();
        $tablaPlanillaItemDocente = array();

        $tablaPlanillaItem_laboralPatronalAdministrativo = array();
        $tablaPlanillaItemAdministrativo = array();
        if ($contratos) {
            
            foreach ($contratos as $key=>$row) {
                //datos como Administrativo
                $rowsSumatoriaHaberBasico = $this->get_total_haber_basico_docente_administrativo($row->id_persona)[0];
                $totalHaberBasicoAdministrativo = $rowsSumatoriaHaberBasico->sumatoria_haber_basico;
                $numeroAsignacionesAdministrativo = 1;
                $row->numero_asignaciones = 1;
                $haberBasicoAsignacionAdministrativo = $datosPlanillaLaboralPatronalAdministrativo[$row->id_contrato_personal]->planilla_laboral_haber_basico;
                $diasTrabajados = $datosSiacopPlanillaItemAdministrativo[$row->id_contrato_personal]->planilla_laboral_dias_trabajados;
                //Datos como persona
                $totalAsignaciones = 1;
                $totalHaberBasico = $rowsSumatoriaHaberBasico->sumatoria_haber_basico;
                $this->set_descuento_retencion_judicial($row->descuento_retencion_judicial, $totalHaberBasico, $totalAsignaciones);
                $this->set_descuento_varios($row->descuento_varios, $totalHaberBasico, $totalAsignaciones);
                $this->set_descuento_sancion_administrativo($row->descuento_sancion_administrativo, $haberBasicoAsignacionAdministrativo, $diasTrabajados);
                $rcIva = 0;
                if ($this->tipoPlanilla == 'REGULAR') {  // $rcIva se calcula solo si es REGULAR en Adicional no se Genera
                    $rcIva = $rowsPlanillaTributaria[$row->id_persona]->impuesto_retenido_a_pagar / $row->numero_asignaciones;
                    // $rcIva = $this->redondeo($rcIva);
                }

                $this->set_descuento_total_administrativo($rcIva);
                $this->set_liquido_pagable_administrativo($datosPlanillaLaboralPatronalAdministrativo[$row->id_contrato_personal]->planilla_laboral_sueldo_neto, $this->descuentoTotalAdministrativo);

                $registro = $datosPlanillaLaboralPatronalAdministrativo[$row->id_contrato_personal];
                $registro->laboral_rc_iva = $rcIva;
                $registro->laboral_descuento_retencion_judicial = $this->descuentoRetencionJudicial;
                $registro->laboral_descuento_varios = $this->descuentoVarios;
                $registro->laboral_descuento_sanciones = $this->descuentoSancionAdministrativo;
                $registro->laboral_descuento_total = $this->descuentoTotalAdministrativo;
                $registro->laboral_liquido_pagable = $this->liquidoPagableAdministrativo;
                $datosPlanillaLaboralPatronalAdministrativo[$row->id_contrato_personal] = $registro;

                $tablaPlanillaItem_laboralPatronalAdministrativo[] = $datosPlanillaLaboralPatronalAdministrativo[$row->id_contrato_personal];
                $tablaPlanillaItemAdministrativo[] = $datosSiacopPlanillaItemAdministrativo[$row->id_contrato_personal];
            }
        }
        //return $this->datos;
        $this->guardarPlanilla($tablaPlanillaItem_laboralPatronalAdministrativo, $tablaPlanillaItemAdministrativo, $rowsPlanillaTributaria);
        echo "terminado";
    }

    function set_planilla_laboral($row,  $tipo="administrativo") {
        $rowParametrosPlanilla = $this->planilla_parametros;
        $gestion = $this->gestion;
        $mes = $this->mes;
        $this->fechaNacimiento = $row->fecha_nacimiento;
        $this->numeroAsignaciones = 1;
        //$this->mesGestionPlanilla = $mesGestionPlanilla;
        $this->set_fecha_ultimoDiaPlanilla();
        $this->jubilado = $row->jubilado; // "SI"/"NO"
        $this->jubiladoNoAportaAfp = $row->aporta_afp; // "SI"/"NO"
        $this->edad = $this->funcionesComunes->edad_actual($this->fechaNacimiento, $this->fechaUltimoDiaPlanilla);  // edad en base al ultimo dia del  mes y gestion de la planilla
        $this->salarioMinimoNacional = $this->redondeo($rowParametrosPlanilla->salario_minimo_nacional, 2);
        
        //$this->reintegro = $row->reintegro / $this->numeroAsignaciones;
        //$this->reintegroBonoAntiguedad = $row->reintegro_bono_antiguedad / $this->numeroAsignaciones;
        $this->set_laboral_afp();
        $id = '';
        $this->set_planilla_laboral_administrativo($row);
        $this->set_bono_antiguedad($row->id_persona);
        $id = $row->id_contrato_personal;
        $this->set_total_ganado($row->id_persona);
        $this->set_total_descuento_ley($row->id_persona);
        $this->set_sueldo_neto();

        //inserta datos en la tabla temporal
        if (!empty($id)) {
            $this->datosUpdateTablaTemporal[] = array('id_tipo' => $id . $tipo,
                "id_persona" => $row->id_persona,
                'sueldo_neto' => $this->redondeo($this->sueldoNeto),
                'haber_basico' => $this->redondeo($this->haberBasico),
            );
        }
        //calcula la planilla patronal
        $this->set_planilla_patronal($row);
    }

    public function set_planilla_patronal($row) {
        // Aportes Patronales
        // $this->seguroSocialObligatorio = $this->redondeo($this->totalGanado * $this->porcentajeSeguroSocialObligatorio);
        $this->seguroSocialObligatorio = $this->totalGanado * $this->porcentajeSeguroSocialObligatorio;
        $this->entidadAseguradora = $row->id_caja_salud;
        $this->riesgoProfesional = 0;
        //$this->proVivienda = $this->redondeo($this->totalGanado * $this->porcentajeProVivienda);
        $this->proVivienda = $this->totalGanado * $this->porcentajeProVivienda;
        //$this->aportePatronalSolidario = $this->redondeo($this->totalGanado * $this->porcentajeAportePatronalSolidario);
        $this->aportePatronalSolidario = $this->totalGanado * $this->porcentajeAportePatronalSolidario;

        if ($this->edad < 65) {
            //$this->riesgoProfesional = $this->redondeo($this->totalGanado * $this->porcentajeRiesgoProfesional);
            $this->riesgoProfesional = $this->totalGanado * $this->porcentajeRiesgoProfesional;
        }

//        if (empty($this->entidadAseguradora))
//            $this->entidadAseguradora = mensaje('SIN/ENT.ASE.');

        $this->totalAportesPatronales = $this->seguroSocialObligatorio + $this->riesgoProfesional + $this->proVivienda + $this->aportePatronalSolidario;

        //Aportes Beneficios Sociales        
        //$this->beneficioSocialAguinaldo = $this->redondeo($this->totalGanado * $this->porcentajeBeneficioSocialAguinaldo);
        $this->beneficioSocialAguinaldo = $this->totalGanado * $this->porcentajeBeneficioSocialAguinaldo;
        //$this->beneficioSocialIndeminizacion = $this->redondeo($this->totalGanado * $this->porcentajeBeneficioSocialIndeminizacion);
        $this->beneficioSocialIndeminizacion = $this->totalGanado * $this->porcentajeBeneficioSocialIndeminizacion;
        $this->totalBeneficioSocial = $this->beneficioSocialAguinaldo + $this->beneficioSocialIndeminizacion;


        //Total Planilla Patronal (Carga Social)
        $this->totalCargaSocial = $this->totalAportesPatronales + $this->totalBeneficioSocial;
    }

    private function set_fecha_ultimoDiaPlanilla() {
        $gestionPlanilla = $this->gestion;
        $mesPlanilla = $this->mes;
        $ultimoDiaPlanilla = $this->funcionesComunes->getLastDayByGestionAndMes($mesPlanilla, $gestionPlanilla);
        $fechaPlanilla = $gestionPlanilla . '-' . $mesPlanilla . '-' . $ultimoDiaPlanilla;
        $this->fechaUltimoDiaPlanilla = $fechaPlanilla;
    }

    private function set_bono_antiguedad($idPersona) {
        $this->bonoAntiguedad = 0;
        $this->aniosAntiguedad = 0;
        $this->porcentajeAntiguedad = 0;

        $antiguedad_bono = \DB::select("SELECT anio, porcentaje from antiguedad_bono_persona abp
                                inner join antiguedad_bono ab on abp.id_antiguedad_bono=ab.id
                                where id_persona=$idPersona");

        if(!empty($antiguedad_bono)){
            $antiguedad_bono = $antiguedad_bono[0];
            $porcentajeBonoAntiguedad = $antiguedad_bono->porcentaje;
            $this->bonoAntiguedad = ($porcentajeBonoAntiguedad * (3 * $this->salarioMinimoNacional)) / $this->numeroAsignaciones;
            $this->bonoAntiguedad = $this->bonoAntiguedad + $this->reintegroBonoAntiguedad;
            $this->bonoAntiguedad = $this->redondeo($this->bonoAntiguedad);
            $this->porcentajeAntiguedad = $antiguedad_bono->porcentaje;
        }
    }

    private function set_total_ganado($idPersona) {
        $this->totalGanado = $this->haberBasico + $this->bonoAntiguedad/* + $this->reintegro*/;
        $this->arrayTotalGanadoPersona[$idPersona] = $this->totalGanado;
        $this->totalGanado = $this->redondeo($this->totalGanado);
    }

    public function set_total_descuento_ley($idPersona) {
        $totalBonoSolidario = 0;
//        if (empty($this->arrayTotalGanadoPersona[$ci])) {
//            $this->arrayTotalGanadoPersona[$ci] = $this->totalGanado;
//        } else {
//            $this->arrayTotalGanadoPersona[$ci] = $this->totalGanado + $this->arrayTotalGanadoPersona[$ci];
//        }
        if ($this->arrayTotalGanadoPersona[$idPersona] > 13000) {
            $totalBonoSolidario = ($this->arrayTotalGanadoPersona[$idPersona] - 13000) * 0.01; // 1%
        }
        if ($this->arrayTotalGanadoPersona[$idPersona] > 25000) {
            $totalBonoSolidario = $totalBonoSolidario + (($this->arrayTotalGanadoPersona[$idPersona] - 13000) * 0.05); // 5%
        }
        if ($this->arrayTotalGanadoPersona[$idPersona] > 35000) {
            $totalBonoSolidario = $totalBonoSolidario + (($this->arrayTotalGanadoPersona[$idPersona] - 13000) * 0.1);  // 10%
        }
        $this->totalDescuentoDeLey = $totalBonoSolidario + $this->totalGanado * $this->afpPorcentajeDescuentoDeLey;
        $this->totalDescuentoDeLey = $this->redondeo($this->totalDescuentoDeLey);
    }

    private function set_sueldo_neto() {
        $this->sueldoNeto = $this->totalGanado - $this->totalDescuentoDeLey;
        $this->sueldoNeto = $this->redondeo($this->sueldoNeto);
    }

    public function set_update_tabla_temporal() {
        if (!empty($this->datosUpdateTablaTemporal)) {
            $this->ci->db->update_batch('siacop_temporal_docente_administrativo', $this->datosUpdateTablaTemporal, 'id_tipo');
        }
    }

    //falta enviar horas trabajadas
    private function set_horas_asignadas($horas_asignadas_mes, $fechaIngreso, $fechaConclusion, $horasTrabajadas) {
        //$horasAsignadas = (4 * $horasSemana); // calcula para un mes
        $horasAsignadas = $horas_asignadas_mes;
        $mesGestionIngreso = date('m-Y', strtotime($fechaIngreso));
        $mesGestionConclusion = date('m-Y', strtotime($fechaConclusion));
        if ($this->mesGestionPlanilla == $mesGestionIngreso || $this->mesGestionPlanilla == $mesGestionConclusion) {
            $horasAsignadas = $horasTrabajadas;  // se asigna horas trabajadas a horas asignadas cuando empieza o concluye en el mismo mes de pago de planillas
        }
        return $horasAsignadas;
    }

    private function set_horas_trabajadas() {
        // si horas trabajadas es mayor a horas asignadas; las horas trabjadas = horas asignadas
        if (floatval($this->horasTrabajadas) > floatval($this->horasAsignadas)) {
            $this->horasTrabajadas = $this->horasAsignadas;
        }
    }

    private function set_horas_falta() {
        $this->horasFalta = 0;
        // si horas trabajadas es mayor a horas asignadas; las horas trabjadas = horas asignadas
        if ($this->horasAsignadas > $this->horasTrabajadas) {
            $this->horasFalta = ($this->horasAsignadas - $this->horasTrabajadas);
        }
    }

    private function set_haber_basico_docente($idPersona) {
        // haber basico normal
        $this->haberBasico = $this->haberBasicoNivelDocente * $this->horasAsignadas; // calcular con horas asignadas
        $this->haberBasico = $this->redondeo($this->haberBasico);

        if (!empty($this->arrayHorasAsignadasObservados[$idPersona])) {
            $this->haberBasico = $this->arrayHorasAsignadasObservados[$idPersona];
        } else {
            // haber basico se modifica en caso de
            // si exede las 80 horas (docentes)
            // si exede las 32 horas (docente y administrativo)
            $rowsHorasAsignadas = $this->ci->modelo_planillas->set_horas_asignadas_tabla_temporal($idPersona);
            if ($rowsHorasAsignadas) {
                $sumatoriaHorasAsignadas = 0;
                $esAdministrativo = FALSE;
                $numeroAsignacionesAdministrativo = 0;
                foreach ($rowsHorasAsignadas->result() AS $row) {
                    $horasAsignadas = $this->set_horas_asignadas($row->horas_asignadas_mes, $row->fecha_asignacion, $row->fecha_conclusion, $row->horas_trabajadas);
                    $sumatoriaHorasAsignadas = $sumatoriaHorasAsignadas + $horasAsignadas;
                    if ($row->tipo == 'administrativo') {
                        $esAdministrativo = TRUE;
                        $numeroAsignacionesAdministrativo++;
                    }
                }
                
                if ($sumatoriaHorasAsignadas > 80 && $esAdministrativo == FALSE) {
                    $this->haberBasico = ($this->haberBasicoNivelDocente * 80) / $this->numeroAsignaciones; // se prorratea en todas sus asignaturas
                    $this->haberBasico = $this->redondeo($this->haberBasico);
                    $this->arrayHorasAsignadasObservados[$idPersona] = $this->haberBasico;
                }

                if ($sumatoriaHorasAsignadas > 32 && $esAdministrativo == TRUE) {
                    $this->haberBasico = ($this->haberBasicoNivelDocente * 32) / ($this->numeroAsignaciones - $numeroAsignacionesAdministrativo); // se prorratea en todas sus asignaturas
                    $this->haberBasico = $this->redondeo($this->haberBasico);
                    $this->arrayHorasAsignadasObservados[$idPersona] = $this->haberBasico;
                }
            }
        }
    }

    /*
     * Metodos para la planilla laboral ADMINISTRATIVO
     */
    function set_planilla_laboral_administrativo($row) {
        // se calcula horas asignadas en base a las horas trabajadas
        //$this->set_horas_asignadas($row->horas_semana, $row->fecha_asignacion, $row->fecha_conclusion);
        $this->set_dias_trabajadas($row->id_persona, $row->fecha_ingreso, $row->fecha_retiro, $row->fecha_culminacion);
        $this->set_haber_basico_administrativo($row->id_haber_basico);
    }

    private function set_dias_trabajadas($idContratoPersonal, $fechaIngreso, $fechaConclusion, $fechaBaja) {
        $diasMesComercial = 30;
        $this->diasTrabajadas = $diasMesComercial;
        $fechaInicioPlanilla = date('Y-m-d', strtotime('01-' . $this->mes."-".$this->gestion));
        //$fechaFinPlanilla = date('Y-m-d', strtotime($this->fechaUltimoDiaPlanilla . '-' . $this->mesGestionPlanilla));
        $fechaFinPlanilla = date('Y-m-d', strtotime($this->fechaUltimoDiaPlanilla));
        // si fecha de Conclusion es Vacio es por que tiene contrato Inefinido
        // y le asignamos la ultima fecha del mes
        if (empty($fechaConclusion)) {
            $fechaConclusion = $fechaFinPlanilla;
        }
        $estadoIngreso = FALSE;
        $estadoConclusion = FALSE;
        if ($this->funcionesComunes->validar_fecha($fechaIngreso)) {
            // Verifica si fechaIngreso esta en el rango del primer y ultimo dia del Mes de la Planilla
            if ($fechaIngreso >= $fechaInicioPlanilla && $fechaIngreso <= $fechaFinPlanilla) {
                // Fecha de ingreso es en el mes de la planilla
                // diasTrabajadas = ultimoDiaMes - fechaIngreso - 1 
                // se le resta menos uno -1 ya que el dia de la fecha de ingreso ya empieza a trabajar
                $estadoIngreso = TRUE;
                $this->diasTrabajadas = ((integer) date('d', strtotime($this->fechaUltimoDiaPlanilla)) - (integer) date('d', strtotime($fechaIngreso))) + 1;   //sumamos un dia ya que el dia de la fechaIngreso ya empieza a trabajar
            }
        }

        // Verifica si fechaConclusion esta en el rango del primer y ultimo dia del Mes de la Planilla
        if ($this->funcionesComunes->validar_fecha($fechaConclusion)) {
            // Verifica si fechaConclusion esta en el rango del primer (>=) y ultimo dia del Mes de la Planilla
            // fecha Conclusion >= (esto es por que aunque sea por un dia hay que pagarle)
            if ($fechaConclusion >= $fechaInicioPlanilla && $fechaConclusion < $fechaFinPlanilla) {
                // Fecha de conclusion es en el mes de la planilla
                // diasTrabajadas = dia de la fecha Conclusion
                $estadoConclusion = TRUE;
                $this->diasTrabajadas = (integer) date('d', strtotime($fechaConclusion));
            }
        }

        // Si fechaIngreso y Conclusion estan dentro del mes de la Planilla
        if ($estadoIngreso && $estadoConclusion) {
            // fechaConclusion -fechaIngreso + 1 
            // +1 es por que cuenta tambien el dia que ingreso
            $this->diasTrabajadas = ((integer) date('d', strtotime($fechaConclusion)) - (integer) date('d', strtotime($fechaIngreso))) + 1;
        }

        // No puede existir dias trabajadas mayor a diasTrabajadas = 30 (año comercial)
        if ($this->diasTrabajadas > $this->diasPorMes) {
            $this->diasTrabajadas = $this->diasPorMes;
        }

        // Suma el total de dias trabajadas de una persona
        if (empty($this->arrayDiasTrabajadasPorAdministrativo[$idContratoPersonal])) {
            $totalDiasTrabajadas = $this->arrayDiasTrabajadasPorAdministrativo[$idContratoPersonal] = $this->diasTrabajadas;
        } else {
            $totalDiasTrabajadas = $this->arrayDiasTrabajadasPorAdministrativo[$idContratoPersonal] + $this->diasTrabajadas;
        }
        //verifica que no exeda los dias trabajados de una persona en un mes mayor a 30 (cuando tienen mas de un nombramiento)
        if ($totalDiasTrabajadas > $diasMesComercial) {
            $totalDiasTrabajadas = $diasMesComercial;
            $this->diasTrabajadas = $totalDiasTrabajadas - $this->arrayDiasTrabajadasPorAdministrativo[$idContratoPersonal];
        }

        //verifica que el mes sea igual a 30 cuando el mes tenga menor a 30 dias
        $ultimoDiaMes = date('d', strtotime($this->fechaUltimoDiaPlanilla));
        if ($totalDiasTrabajadas == $ultimoDiaMes && $totalDiasTrabajadas < $diasMesComercial) {
            $totalDiasTrabajadas = $diasMesComercial;
            if ($fechaIngreso == $fechaInicioPlanilla) {                
                $this->diasTrabajadas = $totalDiasTrabajadas;
            } else {                
                $this->diasTrabajadas = $totalDiasTrabajadas - $this->arrayDiasTrabajadasPorAdministrativo[$idContratoPersonal];                
            }
        }
        $this->arrayDiasTrabajadasPorAdministrativo[$idContratoPersonal] = $totalDiasTrabajadas;
    }

    private function set_haber_basico_administrativo($nivel) {
        $haberBasicoNivel = $this->redondeo($this->haber_basico_nivel($nivel)->haber_basico);
        //$haberBasicoDiario = $this->redondeo(($haberBasicoNivel / $this->diasPorMes));
        $haberBasicoDiario = $haberBasicoNivel / $this->diasPorMes;
        $haberBasico = $this->redondeo(($haberBasicoDiario * $this->diasTrabajadas));
        $this->haberBasico = $haberBasico;
    }

    function set_laboral_afp() {
        $this->afpCotizacionMensual = 0;
        $this->afpComision = 0;
        $this->afpAporteSolidario = 0;
        $this->afpRiesgoComun = 0;
        $this->afpPorcentajeDescuentoDeLey = 0;
        $cumple65_menorIgual15 = $this->_get_cumple65_menorIgual15();

        if ($this->jubilado == 'SI') {
            if ($this->jubiladoNoAportaAfp == "SI") {
                if ($this->edad >= 65) {
                    $this->afpCotizacionMensual = 0.10;
                    $this->afpComision = 0.005;
                    $this->afpAporteSolidario = 0.005;
                    $this->afpPorcentajeDescuentoDeLey = 0.11;
                } else {
                    if ($cumple65_menorIgual15) {
                        $this->afpCotizacionMensual = 0.10;
                        $this->afpComision = 0.005;
                        $this->afpAporteSolidario = 0.005;

                        $this->afpPorcentajeDescuentoDeLey = 0.11;
                    } else {
                        $this->afpCotizacionMensual = 0.10;
                        $this->afpComision = 0.005;
                        $this->afpAporteSolidario = 0.005;
                        $this->afpRiesgoComun = 0.0171;
                        $this->afpPorcentajeDescuentoDeLey = 0.1271;
                    }
                }
            } else {
                if ($this->edad >= 65) {
                    $this->afpComision = 0.005;
                    $this->afpAporteSolidario = 0.005;
                    $this->afpPorcentajeDescuentoDeLey = 0.01;
                } else {
                    if ($cumple65_menorIgual15) {
                        $this->afpComision = 0.005;
                        $this->afpAporteSolidario = 0.005;
                        $this->afpPorcentajeDescuentoDeLey = 0.01;
                    } else {
                        $this->afpComision = 0.005;
                        $this->afpAporteSolidario = 0.005;
                        $this->afpRiesgoComun = 0.0171;
                        $this->afpPorcentajeDescuentoDeLey = 0.0271;
                    }
                }
            }
        } else {
            if ($this->edad >= 65) {
                $this->afpCotizacionMensual = 0.10;         // aumentado por garmaser
                $this->afpComision = 0.005;                 // aumentado por garmaser
                $this->afpAporteSolidario = 0.005;          // aumentado por garmaser
                $this->afpPorcentajeDescuentoDeLey = 0.11;
            } else {
                if ($cumple65_menorIgual15) {
                    $this->afpCotizacionMensual = 0.10;
                    $this->afpComision = 0.005;
                    $this->afpAporteSolidario = 0.005;
                    $this->afpPorcentajeDescuentoDeLey = 0.11;
                } else {
                    $this->afpCotizacionMensual = 0.10;
                    $this->afpComision = 0.005;
                    $this->afpAporteSolidario = 0.005;
                    $this->afpRiesgoComun = 0.0171;
                    $this->afpPorcentajeDescuentoDeLey = 0.1271;
                }
            }
        }
    }

    function _get_cumple65_menorIgual15() {
        if (!empty($this->fechaNacimiento)) {
            $mesCumple = date('m', strtotime($this->fechaNacimiento));
            $diaCumple = date('d', strtotime($this->fechaNacimiento));
            $mesPlanilla = date('m', strtotime($this->mesGestionPlanilla));

            if ($this->edad == 64 && $mesCumple == $mesPlanilla && $diaCumple <= 15) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    /*
     * Calculos para la planilla Tributaria 
     * NOTA todos los calculos para la planilla tributaria
     * se las realiza con enteros exepto las ufvActual y ufvAnterior
     */

    function set_planilla_tributaria($row) {

        $rowParametrosPlanilla = $this->planilla_parametros;
        $this->tributariaSueldoNeto = $this->redondeo_tributaria($row->sumatoria_sueldo_neto);
        
        $dosSalariosMinimos = $rowParametrosPlanilla->salario_minimo_nacional * 2;  // minimoNoImponible = 2 Salarios Minimos
        $dosSalariosMinimos = $this->redondeo_tributaria($dosSalariosMinimos);
        $this->minimoNoImponible = $dosSalariosMinimos;
        $this->diferenciaSujetoImpuesto = 0;
        $this->impuesto = 0;
        $this->formulario110 = 0;
        $this->impuestoMinimoNoImponible = 0;
        $this->fisco = 0;

        $this->saldoFavorDependiente = 0;
        $this->saldoMesAnterior = $row->saldo_favor_impuestos;  // recupera el saldo a favor del impuestos de una persona
        
        $this->actualizacionMesAnterior = 0;
        $this->saldoTotalMesAnterior = 0;

        $this->saldoTotalFavorDependiente = 0;
        $this->saldoUtiliazado = 0;
        $this->impuestoPagar = 0;
        $this->saldoMesSiguiente = 0;


        $rowFormulario110 = $row->monto_impuestos;

        if (!empty($rowFormulario110)) {
            $this->formulario110 = $this->redondeo_tributaria($rowFormulario110);
        }

        $this->set_tributaria_minimo_no_imponible();
        $this->set_tributaria_diferencia_sujeto_impuesto();
        $this->set_tributaria_impuesto();
        $this->set_tributaria_impuesto_minimo_no_imponible($rowParametrosPlanilla->salario_minimo_nacional);
        $this->set_tributaria_fisco();
        $this->set_tributaria_saldo_favor_dependiente();
        $this->set_tributaria_actualizacion_mes_anterior();
        $this->set_tributaria_total_mes_anterior();
        $this->set_tributaria_saldo_total_favor_dependiente();
        $this->set_tributaria_saldo_utilizado();
        $this->set_tributaria_impuesto_pagar();
        $this->set_tributaria_saldo_mes_siguiente();
    }

    private function set_tributaria_minimo_no_imponible() {
        if ($this->minimoNoImponible >= $this->tributariaSueldoNeto) {
            $this->minimoNoImponible = $this->tributariaSueldoNeto;
            $this->minimoNoImponible = $this->redondeo_tributaria($this->minimoNoImponible);
        }
    }

    private function set_tributaria_diferencia_sujeto_impuesto() {
        $this->diferenciaSujetoImpuesto = $this->tributariaSueldoNeto - $this->minimoNoImponible;
        $this->diferenciaSujetoImpuesto = $this->redondeo_tributaria($this->diferenciaSujetoImpuesto);
    }

    private function set_tributaria_impuesto() {
        $this->impuesto = $this->diferenciaSujetoImpuesto * $this->porcentajeImpuesto;
        $this->impuesto = $this->redondeo_tributaria($this->impuesto);
    }

    private function set_tributaria_impuesto_minimo_no_imponible($salarioMinimoNacional) {
        
        $salarioMinimoNoImponible = $salarioMinimoNacional * 2; // apartir de la planilla 04-2016 (volvio a la anterior)
        if ($this->diferenciaSujetoImpuesto >= $salarioMinimoNoImponible) {
            $this->impuestoMinimoNoImponible = $salarioMinimoNoImponible * $this->porcentajeImpuesto; //calculo 2015
        } elseif ($this->diferenciaSujetoImpuesto < $salarioMinimoNoImponible) {
            $this->impuestoMinimoNoImponible = $this->diferenciaSujetoImpuesto * $this->porcentajeImpuesto;
        } else {
            $this->impuestoMinimoNoImponible = 0;
        }

        $this->impuestoMinimoNoImponible = $this->redondeo_tributaria($this->impuestoMinimoNoImponible);
    }

    private function set_tributaria_fisco() {
        $sumatoria = $this->formulario110 + $this->impuestoMinimoNoImponible;
        $sumatoria = $this->redondeo_tributaria($sumatoria);
        if ($this->impuesto >= $sumatoria) {
            $this->fisco = $this->impuesto - $sumatoria;
        } else {
            $this->fisco = 0;
        }

        $this->fisco = $this->redondeo_tributaria($this->fisco);
    }

    private function set_tributaria_saldo_favor_dependiente() {
        $sumatoria = $this->formulario110 + $this->impuestoMinimoNoImponible;
        if ($sumatoria > $this->impuesto) { //hERA >=
            $this->saldoFavorDependiente = $sumatoria - $this->impuesto;
        } else {
            $this->saldoFavorDependiente = 0;
        }

        $this->saldoFavorDependiente = $this->redondeo_tributaria($this->saldoFavorDependiente);
    }

    private function set_tributaria_actualizacion_mes_anterior() {
//        $this->actualizacionMesAnterior = $this->redondeo_tributaria((($this->ufvActual / $this->ufvAnterior) - 1) * $this->saldoMesAnterior);
        $this->actualizacionMesAnterior = (($this->ufvActual / $this->ufvAnterior) - 1) * $this->saldoMesAnterior;
        $this->actualizacionMesAnterior = $this->redondeo_tributaria($this->actualizacionMesAnterior);
    }

    private function set_tributaria_total_mes_anterior() {
        $this->saldoTotalMesAnterior = $this->saldoMesAnterior + $this->actualizacionMesAnterior;
        $this->saldoTotalMesAnterior = $this->redondeo_tributaria($this->saldoTotalMesAnterior);
    }

    private function set_tributaria_saldo_total_favor_dependiente() {
        $this->saldoTotalFavorDependiente = $this->saldoFavorDependiente + $this->saldoTotalMesAnterior;
        $this->saldoTotalFavorDependiente = $this->redondeo_tributaria($this->saldoTotalFavorDependiente);
    }

    private function set_tributaria_saldo_utilizado() {

        if ($this->fisco >= $this->saldoTotalFavorDependiente) {
            $this->saldoUtiliazado = $this->saldoTotalFavorDependiente;
        }

        if ($this->fisco < $this->saldoTotalFavorDependiente) {
            $this->saldoUtiliazado = $this->fisco;
        }

        $this->saldoUtiliazado = $this->redondeo_tributaria($this->saldoUtiliazado);
    }

    private function set_tributaria_impuesto_pagar() {
        $this->impuestoPagar = $this->fisco - $this->saldoUtiliazado;
        $this->impuestoPagar = $this->redondeo_tributaria($this->impuestoPagar);
    }

    private function set_tributaria_saldo_mes_siguiente() {
        $this->saldoMesSiguiente = $this->saldoTotalFavorDependiente - $this->saldoUtiliazado;
        $this->saldoMesSiguiente = $this->redondeo_tributaria($this->saldoMesSiguiente);
    }

    /* DESCUENTOS DOCENTES ADMINISTRATIVO */
    private function set_descuento_retencion_judicial($montoUnidad, $totalHaberBasico, $totalAsignaciones) {
        $this->descuentoRetencionJudicial = 0;
        if (!empty($montoUnidad)) {
            $this->descuentoRetencionJudicial = $this->set_calcular_descuento($montoUnidad, $totalHaberBasico);
            $this->descuentoRetencionJudicial = $this->descuentoRetencionJudicial / $totalAsignaciones;
            $this->descuentoRetencionJudicial = $this->redondeo($this->descuentoRetencionJudicial);
        }
    }
    private function set_descuento_varios($montoUnidad, $totalHaberBasico, $totalAsignaciones) {
        $this->descuentoVarios = 0;
        if (!empty($montoUnidad)) {
            $this->descuentoVarios = $this->set_calcular_descuento($montoUnidad, $totalHaberBasico);
            $this->descuentoVarios = $this->descuentoVarios / $totalAsignaciones;
            $this->descuentoVarios = $this->redondeo($this->descuentoVarios);
        }
    }

    /* DESCUENTOS ADMINISTRATIVO */
    private function set_descuento_sancion_administrativo($diasSancion, $totalHaberBasicoAsignacion, $diasTrabajados) {
        $this->descuentoSancionAdministrativo = 0;
        if (!empty($diasSancion) && $diasTrabajados > 0) {
            $this->descuentoSancionAdministrativo = $diasSancion * ($totalHaberBasicoAsignacion / $diasTrabajados );
            $this->descuentoSancionAdministrativo = $this->redondeo($this->descuentoSancionAdministrativo);
        }
    }

    private function set_descuento_total_docente($rcIva) {
        $this->descuentoTotalDocente = $rcIva + $this->descuentoCud + $this->descuentoFud + $this->descuentoCarrera + $this->descuentoHcu + $this->descuentoRetencionJudicial + $this->descuentoVarios + $this->descuentoSancionDocente;
    }

    private function set_descuento_total_administrativo($rcIva) {
        $this->descuentoTotalAdministrativo = $rcIva + $this->descuentoRetencionJudicial + $this->descuentoVarios  + $this->descuentoSancionAdministrativo;
    }

    private function set_calcular_descuento($montoUnidad, $montoTotal) {
        $arrayMontoUnidad = explode(';', $montoUnidad);
        $sumatoriaDescuento = 0;
        foreach ($arrayMontoUnidad AS $valor) {
            list($montoDescuento, $unidadDescuento) = explode('_', $valor);

            if ($unidadDescuento == "PORCIENTO") {
                $montoDescuento = $montoTotal * ($montoDescuento / 100);
                $montoDescuento = $this->redondeo($montoDescuento);
            }

            $sumatoriaDescuento = $sumatoriaDescuento + $montoDescuento;
        }
        return $sumatoriaDescuento;
    }

    //totales
    private function set_liquido_pagable_docente($sueldoNeto, $totalDescuentos) {
        $this->liquidoPagableDocente = $sueldoNeto - $totalDescuentos;
        $this->liquidoPagableDocente = $this->redondeo($this->liquidoPagableDocente);
    }

    private function set_liquido_pagable_administrativo($sueldoNeto, $totalDescuentos) {
        $this->liquidoPagableAdministrativo = $sueldoNeto - $totalDescuentos;
        $this->liquidoPagableAdministrativo = $this->redondeo($this->liquidoPagableAdministrativo);
    }

    public function redondeo($valor, $redondeo = 2) {
        $nuevoValor = round($valor, $redondeo);
        //$html = '<div style = "text-align:right">' . number_format($numero,$decimales,',','.') . '</div>';
        return $nuevoValor;
    }

    public function redondeo_tributaria($valor, $redondeo = 4) {
        $nuevoValor = round($valor, $redondeo);
        return $nuevoValor;
    }
}
