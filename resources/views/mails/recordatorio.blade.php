<?php
use App\Helpers\FuncionesComunes;
use App\Models\Configuracion;
$configuracion = Configuracion::find(1);
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0">
    <title>Recordatorio de Cita Médica</title>
</head>
<body>
    <p><strong>Saludos, Señor(a) {{$cita_medica->nombre}} {{$cita_medica->paterno}} {{$cita_medica->materno}}.</strong></p>
    <p>Queremos recordarle que usted tiene reservada una cita con los siguientes datos:</p>
    <ul>
        <li><strong>Carnet  </strong>del Paciente: {{$cita_medica->ci}}</li>
        <li><strong>Paciente: </strong> {{$cita_medica->nombre}} {{$cita_medica->paterno}} {{$cita_medica->materno}}</li>
        <li><strong>Especialidad: </strong> {{$cita_medica->especialidad}}</li>
        <li><strong>Fecha de la cita: </strong>{{FuncionesComunes::fecha_literal($cita_medica->fecha_cita, 5)}}</li>
        <li><strong>Hora: </strong> {{$cita_medica->hora}} {{((int) substr($cita_medica->hora,0,2)<12) ? 'am':'pm'}}</li>  
    </ul>
    <p><strong>Att:</strong></p>
    <p><strong>Empresa: </strong>{{$configuracion->razon_social}}</p>
    <p><strong>Ciudad: </strong> {{$configuracion->ciudad}}</p>
    <p><strong>Dirección: </strong> {{$configuracion->direccion}}</p>
    <p><strong>Telefonos: </strong> {{$configuracion->telefono}} - {{$configuracion->celular}}</p>
    <p><strong>Email: </strong> {{$configuracion->email}}</p>
    <p><strong>Web: </strong> {{$configuracion->web}}</p>
    <img src="{{url('img/'.$configuracion->logo)}}" alt="" width="400px" id="img-logo">
</body>
</html>