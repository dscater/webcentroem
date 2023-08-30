<?php

namespace App\Http\Controllers\ModuloPlanilla\SaveRowPlanilla;

abstract class SavePlanillaFactory
{
    protected $diasPorMes = 30;
    

    public abstract function procesar();

    protected function setPorcentajeAntiguedadBono() {
        $resultado = \DB::select("SELECT * FROM antiguedad_bono where state=1");
        $bonos = array();
        foreach ($resultado AS $key => $value) {
            $bonos[$value->anio] = $value->porcentaje;
        }
        return $bonos;
    }

    protected function setPersonalRegular() {
        
        $sqlAdministrativos = $this->getConsulta();

        // PASO 1 Eliminamos la tabla temporal si existe para futuras consultas (ya que si se mantiene genera un error de que la tabla ya existe)
        \DB::select('DROP TABLE IF EXISTS temporal_contratos');

        // PASO 2 creamos la tabla temporal para obtener el total de contratos vigentes
        $sqlTablaTemporal = ' CREATE /*TEMPORARY*/ TABLE temporal_contratos ';
        $sqlTablaTemporal.=  $sqlAdministrativos;
        
        \DB::select($sqlTablaTemporal);
        
        \DB::select(" DROP TABLE IF EXISTS temporal_descuento; ");

        $sqlDescuento = " SELECT sum(monto) monto, pd.id_contrato_personal, pd.id_tipo_descuento, td.tipo_descuento
                        from planilla_descuento pd
                        inner join tipo_descuento td on pd.id_tipo_descuento=td.id
                        group by pd.id_contrato_personal, pd.id_tipo_descuento, td.tipo_descuento;";

        $sqlTablaTemporal = " CREATE /*TEMPORARY*/ TABLE temporal_descuento";
        
        $sqlTablaTemporal.= $sqlDescuento;
        \DB::select($sqlTablaTemporal);
    }

    private function getConsulta() {

        $idPlanilla = $this->id_planilla;
        $gestion = $this->gestion;
        $mes = $this->mes;
        $fecha_limite_contrato = $this->planilla_cabecera->fecha_limite_contrato;
        $fecha_limite_contrato = date('Y-m-d', strtotime($gestion . '-' . $mes . '-' . $fecha_limite_contrato));
        $gestion = $this->gestion;
        $mes = $this->mes;

        if($mes<10){
            $mes ='0'.$mes;
        }

        return  " SELECT p.id AS id_persona, p.nombre1, p.nombre2, p.materno, p.paterno, p.numero_documento, p.id_departamento, p.saldo_favor_impuestos, cp.id AS id_contrato_personal, CAST(0.0 AS decimal(10,2)) AS sueldo_neto,CAST(0.0 AS decimal(10,2)) AS haber_basico, '0' AS horas_trabajadas     
        FROM contrato_personal AS cp
        INNER JOIN tipo_horario th ON(cp.id_tipo_horario = th.id)
        INNER JOIN persona p ON (cp.id_persona = p.id)
        
        INNER JOIN cargo c ON(cp.id_cargo=c.id)
        LEFT JOIN caja_salud cs ON(p.id_caja_salud = cs.id)
        LEFT JOIN ( select planilla.id_contrato_personal  from planilla
                INNER JOIN planilla_cabecera ON(planilla.id_planilla_cabecera = planilla_cabecera.id AND planilla_cabecera.mes = $mes and planilla_cabecera.gestion=$gestion AND planilla_cabecera.estado_planilla = 'APROBADO' AND planilla_cabecera.id_tipo_planilla <>4)
                inner JOIN contrato_personal AS cp ON(cp.id = planilla.id_contrato_personal)
        ) tabla on cp.id=tabla.id_contrato_personal
        WHERE tabla.id_contrato_personal IS NULL AND ('{$gestion}{$mes}' BETWEEN DATE_FORMAT(cp.fecha_ingreso,'%Y%m') AND DATE_FORMAT(IFNULL(cp.fecha_retiro, IFNULL(cp.fecha_culminacion,curdate())),'%Y%m') ) ";
        
    }

    public function getContratoPersonal() {
        
        $gestion = $this->gestion;
        $mes = $this->mes;

        if($mes<10){
            $mes ='0'.$mes;
        }

        $sql = " SELECT cp.*, cp.id id_contrato_personal, p.*, cs.abrev1, cs.id id_caja_salud, p.id AS id_persona, c.id_haber_basico, c.cargo, 
                (SELECT monto FROM temporal_descuento WHERE cp.id = temporal_descuento.id_contrato_personal and temporal_descuento.id_tipo_descuento=3) AS descuento_retencion_judicial,
                (SELECT monto FROM temporal_descuento WHERE cp.id = temporal_descuento.id_contrato_personal and temporal_descuento.id_tipo_descuento=2) AS descuento_varios,
                (SELECT monto FROM temporal_descuento WHERE cp.id = temporal_descuento.id_contrato_personal and temporal_descuento.id_tipo_descuento=1) AS descuento_sancion_administrativo
                FROM contrato_personal AS cp
        INNER JOIN tipo_horario th ON(cp.id_tipo_horario = th.id)
        INNER JOIN persona p ON (cp.id_persona = p.id)
        
        INNER JOIN cargo c ON(cp.id_cargo=c.id)
        LEFT JOIN caja_salud cs ON(p.id_caja_salud = cs.id)
        LEFT JOIN ( select planilla.id_contrato_personal  from planilla
                INNER JOIN planilla_cabecera ON(planilla.id_planilla_cabecera = planilla_cabecera.id AND planilla_cabecera.mes = $mes and planilla_cabecera.gestion=$gestion AND planilla_cabecera.estado_planilla = 'APROBADO' AND planilla_cabecera.id_tipo_planilla <>4)
                inner JOIN contrato_personal AS cp ON(cp.id = planilla.id_contrato_personal)
        ) tabla on cp.id=tabla.id_contrato_personal
        WHERE tabla.id_contrato_personal IS NULL AND ('{$gestion}{$mes}' BETWEEN DATE_FORMAT(cp.fecha_ingreso,'%Y%m') AND DATE_FORMAT(IFNULL(cp.fecha_retiro, IFNULL(cp.fecha_culminacion,curdate())),'%Y%m') )
        ORDER BY cp.fecha_ingreso ASC, p.paterno, p.materno, p.nombre1";
        
        return \DB::select($sql);
        
    }

    public function haber_basico_nivel($id_haber_basico) {
        return \DB::select("SELECT *
                from haber_basico 
                where id=$id_haber_basico")[0];
        
    }

    public function get_filtrar_tributaria($gestion, $mes) {
        
        $sql = "SELECT temporal.id_persona, temporal.nombre1, temporal.materno, temporal.paterno, temporal.numero_documento, d.abrev1 expedido, temporal.saldo_favor_impuestos, SUM(temporal.sueldo_neto) AS sumatoria_sueldo_neto,
            (SELECT case when sum(impuestos.monto) is null then 0 else sum(impuestos.monto) end
            FROM impuestos 
            WHERE temporal.id_persona = impuestos.id_persona 
            AND impuestos.gestion = $gestion
            and impuestos.mes=$mes
            and impuestos.id_persona=temporal.id_persona) AS monto_impuestos
        FROM temporal_contratos AS temporal                        
        inner join departamento d on temporal.id_departamento=d.id
        GROUP BY temporal.id_persona, temporal.nombre1, temporal.materno, temporal.paterno, temporal.numero_documento, d.abrev1, temporal.saldo_favor_impuestos, temporal.sueldo_neto
        ORDER BY temporal.paterno, temporal.materno, temporal.nombre1";
        
        return \DB::select($sql);
    }

    public function get_total_haber_basico_docente_administrativo($idPersona) {
        $sql = "SELECT 1 numero_asignaciones, SUM(haber_basico) AS sumatoria_haber_basico
                FROM temporal_contratos 
                WHERE id_persona = '$idPersona'
                GROUP BY id_persona";
        
        return \DB::select($sql);
    }

    public function guardarPlanilla($planilla, $planilla_trabajo, $planilla_tributaria) {
        if (!empty($planilla)) {
            foreach($planilla as $key=>$value){
                $value->save();
            }
            foreach($planilla_trabajo as $key=>$value){
                $value->save();
            }
            
        }
        //Planilla tributaria
        if (!empty($planilla_tributaria)) {
            foreach($planilla_tributaria as $key=>$value){
                $value->save();
            }
        }
        
    }

    protected function setFechaLastDayPlanilla() {
        $gestion = $this->gestion;
        $mes = $this->mes;
        if($mes<10){
            $mes = "0".$mes;
        }
        $ultimoDia = $this->funcionesComunes->getLastDayByGestionAndMes($gestion, $mes);
        $this->fechaUltimoDiaPlanilla = $gestion . '-' . $mes . '-' . $ultimoDia;
    }

    protected function calcularDiasTrabajados() {

        $fechaIngreso = $this->contrato->fecha_ingreso;
        $fechaConclusion = $this->contrato->fecha_retiro;
        $fechaBaja = $this->contrato->fecha_culminacion;

        $ingreso = false;
        $conclusion = false;
        $diasMesComercial = 30;
        $this->diasTrabajados = $diasMesComercial;

        $fechaInicioPlanilla = date('Y-m-d', strtotime('01-' . $this->mes."-".$this->gestion));
        $fechaFinPlanilla = date('Y-m-d', strtotime($this->fechaUltimoDiaPlanilla));
        // si fecha de Conclusion es Vacio es por que tiene contrato Inefinido
        // y le asignamos la ultima fecha del mes
        if (empty($fechaConclusion)) {
            $fechaConclusion = $fechaFinPlanilla;
        }
        
        // Verifica si fechaIngreso esta en el rango del primer y ultimo dia del Mes de la Planilla
        if ($fechaIngreso >= $fechaInicioPlanilla && $fechaIngreso <= $fechaFinPlanilla) {
            // Fecha de ingreso es en el mes de la planilla
            $ingreso = true;
            // diasTrabajados = ultimoDiaMes - fechaIngreso + 1             
            $this->diasTrabajados = (int) date('d', strtotime($this->fechaUltimoDiaPlanilla)) - (int) date('d', strtotime($fechaIngreso)) + 1;
        }
        
        // Verifica si fechaConclusion esta en el rango del primer y ultimo dia del Mes de la Planilla
        if ($fechaConclusion >= $fechaInicioPlanilla && $fechaConclusion < $fechaFinPlanilla) {
            // Fecha de conclusion es en el mes de la planilla
            $conclusion = true;
            // diasTrabajados = dia de la fecha Conclusion            
            $this->diasTrabajados = (int) date('d', strtotime($fechaConclusion));
        }
        
        // Si fechaIngreso y Conclusion estan dentro del mes de la Planilla
        if ($ingreso && $conclusion) {
            // fechaConclusion - fechaIngreso + 1
            $this->diasTrabajados = (int) date('d', strtotime($fechaConclusion)) - (int) date('d', strtotime($fechaIngreso)) + 1;
        }

        if ($this->diasTrabajados > 30) {
            $this->diasTrabajados = 30;
        }

        //verifica que el mes sea igual a 30 cuando el mes tenga menor a 30 dias
        $ultimoDiaMes = date('d', strtotime($this->fechaUltimoDiaPlanilla));
        if ($this->diasTrabajados == $ultimoDiaMes && $this->diasTrabajados < $diasMesComercial) {
            $this->diasTrabajados = $diasMesComercial;
            if ($fechaIngreso != $fechaInicioPlanilla) {                
                $this->diasTrabajados = 31 - (int) date('d', strtotime($fechaIngreso));
            }
        }
    }

    protected function calcularHaberBasico($haber_basico) {
        $haberBasicoContrato = $this->redondear($haber_basico);
        $haberBasicoDiario = $haberBasicoContrato / $this->diasPorMes;
        $haberBasico = $this->redondear(($haberBasicoDiario * $this->diasTrabajados));
        $this->haberBasico = $haberBasico;
    }

    protected function calcularBonoAntiguedad($porcentajeBonoAntiguedad) {
        $this->bonoAntiguedad = 0;
        $this->bonoAntiguedad = ($porcentajeBonoAntiguedad * (3 * round($this->planilla_parametros->salario_minimo_nacional, 2)));
        $this->bonoAntiguedad = $this->redondear($this->bonoAntiguedad);
        $this->porcentajeBonoAntiguedad = $porcentajeBonoAntiguedad;
    }

    protected function calcularTotalGanado() {
        $this->totalGanado = $this->haberBasico + $this->bonoAntiguedad + $this->pagoPorHorasExtraTrabajadas;
        $this->totalGanado = $this->redondear($this->totalGanado);
    }

    protected function redondear($valor, $decimales = 2) {
        return round($valor, $decimales);
    }
    public function redondearToTributaria($valor, $redondeo = 4) {
        $nuevoValor = round($valor, $redondeo);
        return $nuevoValor;
    }

    public function calcularTotalDescuentoLey() {
        $totalBonoSolidario = 0;

        if ($this->totalGanado > 13000) {
            $totalBonoSolidario = ($this->totalGanado - 13000) * 0.01; // 1%
        }
        if ($this->totalGanado > 25000) {
            $totalBonoSolidario = $totalBonoSolidario + (($this->totalGanado - 13000) * 0.05); // 5%
        }
        if ($this->totalGanado > 35000) {
            $totalBonoSolidario = $totalBonoSolidario + (($this->totalGanado - 13000) * 0.1);  // 10%
        }
        $this->totalDescuentoDeLey = $totalBonoSolidario + $this->totalGanado * $this->afpPorcentajeDescuentoDeLey;
        $this->totalDescuentoDeLey = $this->redondear($this->totalDescuentoDeLey);
    }

    protected function calcularParametrosAfp() {
        $this->afpCotizacionMensual = 0.10;
        $this->afpComision = 0.005;
        $this->afpAporteSolidario = 0.005;
        $this->afpRiesgoComun = 0.0171;
        $this->afpPorcentajeDescuentoDeLey = 0;
        $this->edad = $this->funcionesComunes->calcularEdad($this->fechaNacimiento, $this->fechaUltimoDiaPlanilla);
        $cumpleEdadRequerida = $this->isEdad65();

        if ($this->edad >= 65 || $cumpleEdadRequerida) {
            $this->afpRiesgoComun = 0;
        }

        if ($this->jubilado == 'SI') {
            if ($this->aportaAfp == "NO") {
                $this->afpCotizacionMensual = 0;
            }
        }

        $this->afpPorcentajeDescuentoDeLey = $this->afpCotizacionMensual;
        $this->afpPorcentajeDescuentoDeLey += $this->afpComision;
        $this->afpPorcentajeDescuentoDeLey += $this->afpAporteSolidario;
        $this->afpPorcentajeDescuentoDeLey += $this->afpRiesgoComun;
    }

    private function isEdad65() {
        $fechaNacimiento = $this->fechaNacimiento;
        if (!empty($fechaNacimiento)) {
            $mes = (int) date('m', strtotime($fechaNacimiento));
            $dia = (int) date('d', strtotime($fechaNacimiento));

            if ($this->edad == 64 && $mes == $this->mes && $dia <= 15) {
                return true;
            }
            return false;
        }
        return false;
    }

    protected function calcularSueldoNeto() {
        $this->sueldoNeto = $this->totalGanado - $this->totalDescuentoDeLey;
        $this->sueldoNeto = $this->redondear($this->sueldoNeto);
    }

    public function calcularPlanillaPatronal() {
        
        $this->seguroSocialObligatorio = $this->totalGanado * $this->porcentajeSeguroSocialObligatorio;
        $this->riesgoProfesional = 0;
        
        $this->proVivienda = $this->totalGanado * $this->porcentajeProVivienda;
        $this->aportePatronalSolidario = $this->totalGanado * $this->porcentajeAportePatronalSolidario;

        if ($this->edad < 65) {
            $this->riesgoProfesional = $this->totalGanado * $this->porcentajeRiesgoProfesional;
        }

        $this->totalAportesPatronales = $this->seguroSocialObligatorio + $this->riesgoProfesional + $this->proVivienda + $this->aportePatronalSolidario;
        $this->beneficioSocialAguinaldo = $this->totalGanado * $this->porcentajeBeneficioSocialAguinaldo;
        $this->beneficioSocialIndeminizacion = $this->totalGanado * $this->porcentajeBeneficioSocialIndeminizacion;
        $this->totalBeneficioSocial = $this->beneficioSocialAguinaldo + $this->beneficioSocialIndeminizacion;
        //Total Planilla Patronal (Carga Social)
        $this->totalCargaSocial = $this->totalAportesPatronales + $this->totalBeneficioSocial;
    }

    protected function calcularPlanillaTributaria() {
        $this->tributariaSueldoNeto = $this->redondear($this->sueldoNeto, 4);
        $this->minimoNoImponible = $this->redondear($this->planilla_parametros->salario_minimo_nacional * 2, 4);
        $this->diferenciaSujetoImpuesto = 0;
        $this->impuesto = 0;
        $this->impuestoMinimoNoImponible = 0;
        $this->fisco = 0;
        $this->saldoFavorDependiente = 0;
        $this->actualizacionMesAnterior = 0;
        $this->saldoTotalMesAnterior = 0;
        $this->saldoTotalFavorDependiente = 0;
        $this->saldoUtiliazado = 0;
        $this->impuestoPagar = 0;
        $this->saldoMesSiguiente = 0;
        $this->saldoMesAnterior = 0;
        $this->formulario110 = 0;

        // solo cobrar iva en caso de que el tipo de contrato sea indefinido o eventual
        if($this->parametros_contrato->id_tipo_contrato != 1 && $this->parametros_contrato->id_tipo_contrato != 2){
            return;
        }

        $this->saldoMesAnterior = $this->parametros_contrato->saldo_favor_mes_anterior;
        
        $this->formulario110 = $this->redondear($this->parametros_contrato->saldo_favor, 4);

        
        if ($this->minimoNoImponible >= $this->tributariaSueldoNeto) 
            $this->minimoNoImponible = $this->redondear($this->tributariaSueldoNeto, 4);
        
        $this->diferenciaSujetoImpuesto = $this->redondear($this->tributariaSueldoNeto - $this->minimoNoImponible, 4);
        $this->impuesto = $this->redondear($this->diferenciaSujetoImpuesto * $this->porcentajeImpuesto, 4);
        
        $salarioMinNoImponible = $this->planilla_parametros->salario_minimo_nacional * 2;
        $this->impuestoMinimoNoImponible = $this->diferenciaSujetoImpuesto * $this->porcentajeImpuesto;
        if ($this->diferenciaSujetoImpuesto >= $salarioMinNoImponible) {
            $this->impuestoMinimoNoImponible = $salarioMinNoImponible * $this->porcentajeImpuesto;
            $this->impuestoMinimoNoImponible = $this->redondear($this->impuestoMinimoNoImponible, 4);
        }        
        
        if ($this->impuesto >= $this->formulario110 + $this->impuestoMinimoNoImponible) {
            $this->fisco = $this->redondear($this->impuesto - $this->formulario110 + $this->impuestoMinimoNoImponible, 4);
        }

        if ($this->formulario110 + $this->impuestoMinimoNoImponible > $this->impuesto) {
            $this->saldoFavorDependiente = $this->formulario110 + $this->impuestoMinimoNoImponible - $this->impuesto;
            $this->saldoFavorDependiente = $this->redondear($this->saldoFavorDependiente, 4);
        }
        
        $this->actualizacionMesAnterior = $this->redondear(($this->ufvActual/$this->ufvAnterior-1)*$this->saldoMesAnterior, 4);
        $this->saldoTotalMesAnterior = $this->redondear($this->saldoMesAnterior + $this->actualizacionMesAnterior, 4);
        $this->saldoTotalFavorDependiente = $this->redondear($this->saldoFavorDependiente + $this->saldoTotalMesAnterior, 4);
        
        $this->saldoUtiliazado = $this->fisco;
        if ($this->fisco >= $this->saldoTotalFavorDependiente) {
            $this->saldoUtiliazado = $this->redondear($this->saldoTotalFavorDependiente, 4);
        }
        $this->impuestoPagar = $this->redondear($this->fisco - $this->saldoUtiliazado, 4);
        $this->saldoMesSiguiente = $this->redondear($this->saldoTotalFavorDependiente - $this->saldoUtiliazado, 4);
    }
    protected function calcularDescuentos(){
        $this->calcularDescuentoSancion();
        $this->calcularDescuentoAnticipos();
        $this->calcularDescuentoVarios();
        $this->calcularDescuentoRetencionJudicial();
        
        $this->descuentoTotal = $this->impuestoPagar + $this->descuentoAnticipos + $this->descuentoVarios;
        $this->descuentoTotal += $this->descuentoRetencionJudicial + $this->descuentoSancion;
    }
    protected function calcularDescuentoSancion() {
        $this->descuentoSancion = 0;
        if (!empty($this->diasFalta) && $this->diasTrabajados > 0) {
            $this->descuentoSancion = $this->diasFalta * ($this->haberBasico / $this->diasTrabajados);
            $this->descuentoSancion = $this->redondear($this->descuentoSancion);
        }
    }
    protected function calcularDescuentoAnticipos() {
        $monto = $this->parametros_descuentos->descuento_anticipos;
        $unidad = $this->parametros_descuentos->unidad_anticipos;
        $this->descuentoAnticipos = 0;
        if(empty($monto))
            return;
        $this->descuentoAnticipos = $this->calcularDescuento($unidad, $monto);   
    }
    protected function calcularDescuentoVarios() {
        $monto = $this->parametros_descuentos->descuento_varios;
        $unidad = $this->parametros_descuentos->unidad_varios;
        $this->descuentoVarios = 0;
        if(empty($monto))
            return;
        $this->descuentoVarios = $this->calcularDescuento($unidad, $monto);        
    }

    protected function calcularDescuentoRetencionJudicial() {
        $monto = $this->parametros_descuentos->descuento_retencion_judicial;
        $unidad = $this->parametros_descuentos->unidad_retencion_judicial;
        $this->descuentoRetencionJudicial = 0;
        if(empty($monto))
            return;
        $this->descuentoRetencionJudicial = $this->calcularDescuento($unidad, $monto);
    }

    protected function calcularDescuento($unidad, $monto) {
        if ($unidad == "PORCIENTO") {
            return $this->redondear($this->haberBasico * ($monto / 100));
        }
        return $this->redondear($monto);
    }

    protected function calcularLiquidoPagable() {
        $this->liquidoPagable = $this->redondear($this->sueldoNeto - $this->descuentoTotal);
    }

    protected function calcularPagoHoraExtra($haberBasico, $horasExtra) {
        /*Para ello, dividimos tu salario entre 30 días del mes y luego entre la duración de la jornada. Entre 8, en este caso:
            Sueldo por hora  = (Sueldo básico /30 días)/8 horas
            Salario por horas trabajadas para el valor de horas extras multiplicamos por 2.
            Sueldo por hora *2
            Ahora, este valor lo multiplicamos por las horas extras acumuladas  
            Horas extras= (Sueldo por hora *2)* Horas extras acumuladas
            Formula:
            horas extras=(((Sueldo básico /30 días)/8 horas)*2)* Horas extras acumuladas*/
        $sueldoPorHora = ($haberBasico / 30) / 8;
        $pagoPorHoraExtra = $sueldoPorHora * 2;
        $this->pagoPorHorasExtraTrabajadas = $pagoPorHoraExtra * $horasExtra;
        $this->horasExtra = $horasExtra;
    }

}
