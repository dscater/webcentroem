<?php 
	$estado=false;
	switch ($nombre_tabla) {
		case 'catalogo_nacion':
			$estado=true;
			
			break;
		case 'departamento':
			$estado=true;
			
			break;
		case 'entidad_afp':
			$estado=true;
		
			break;
		case 'caja_salud':
			$estado=true;
		
			break;
		case 'unidad_area':
			$estado=true;
		
			break;
		case 'descuento_docente':
			$estado=true;
		
			break;
		case 'configuracion':
			$estado=true;
		
			break;
		case 'mencion':
			$estado=true;
		
			break;

		case 'asistencia_docente':
			$estado=true;
		
			break;
		case 'evaluacion':
			$estado=true;
		
			break;
		
		default:
			
			break;
	}

?>
@if($estado)
	@include("table.script.".$nombre_tabla)
@endif