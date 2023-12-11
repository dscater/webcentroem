<?php
use App\Helpers\FuncionesComunes;
?>
@extends('layouts.admin')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
    rel="stylesheet" />
@endsection

@section('content')
<div class="content">
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                            data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                            data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Panel</h4>
                </div>

                <div class="panel-body" style="min-height:1000px">
                    <form action="{{url('cita-medica-modificar-registrar/'.$cita_medica->id)}}" method="post" accept-charset="utf-8"
                        id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h2 class="col-md-8 col-md-offset-2" id="titulo">Ver Cita Médica</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2 form-group" style="">
                                
                                <a href="{{url('cita-medica-form-buscar')}}" class="btn btn-success">Volver</a>
                            </div>
                            <div class="col-md-12">
                                @if (Session::has('mensaje')) 
                                <div class="alert alert-{{Session::get('class-alert')}} fade in m-b-15" style="margin-bottom:0">
                                    {{Session::get('mensaje')}}
                                    <span class="close" data-dismiss="alert">×</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>DATOS</h5>
                            </div>
                            
                            
                            <div  class="col-12">
                                
                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Email: {{$cita_medica->email }}</label>
                                </div>
                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Carnet del Paciente: {{$cita_medica->ci}}</label>
                                </div>

                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Paciente: {{$cita_medica->paterno}} {{$cita_medica->materno}} {{$cita_medica->nombre}}</label>
                                </div>

                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Especialidad: {{$cita_medica->especialidad}}</label>
                                </div>

                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Prioridad: {{$cita_medica->prioridad}}</label>
                                </div>

                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Fecha de la cita: {{FuncionesComunes::fecha_literal($cita_medica->fecha_cita, 5)}}</label>
                                </div>

                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span></span> Hora: {{$cita_medica->hora}} {{((int) substr($cita_medica->hora,0,2)<12) ? 'am':'pm'}}</label>
                                </div>
                                

                                
                                

                        
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

@section("script_3")
<script>
    $('document').ready(function () {
        $("#menu-cita-medico-form-buscar").addClass("active");
    });
    
    
    
</script>
@endsection

