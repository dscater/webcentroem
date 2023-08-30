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

                <div class="panel-body" style="">
                    <form action="{{url('factura-modificar-registrar/'.$factura->id)}}" method="post" accept-charset="utf-8"
                        id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h2 class="col-md-8 col-md-offset-2" id="titulo">Ver datos de la Factura</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2 form-group" style="">
                                <!--input type="submit" value="Guardar" name="guardar" class="btn btn-success"-->
                                <a href="{{url('factura-form-buscar')}}" class="btn btn-success">Volver</a>
                                <a href="{{url('factura-reporte/'.$factura->id)}}" class="btn btn-success" target="_blank"> <span class="fa fa-print"></span> PDF</a>
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

                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <label class="app-label fecha_factura"><span>*</span>  Fecha de la Factura:</label>
                                    <div class="div-create-fecha_factura">
                                        <input name="fecha_factura" value="{{(!empty(old('fecha_factura'))) ? old('fecha_factura') : $factura->fecha_factura}}" class="app-form-control form-control  fadeInLeft animated" id="input-fecha_factura" type="date" required disabled>
                                        @if ($errors->has('fecha_factura'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('fecha_factura')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <label class="app-label nro_factura"><span>*</span>  Nro. de la factura:</label>
                                    <div class="div-create-nro_factura">
                                        <input name="nro_factura" value="{{(!empty(old('nro_factura'))) ? old('nro_factura') : $factura->nro_factura}}" class="app-form-control form-control  fadeInLeft animated" id="input-nro_factura" type="number" required disabled>
                                        @if ($errors->has('nro_factura'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('nro_factura')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <label class="app-label paciente_ci"><span>*</span>  CI/NIT:</label>
                                    <div class="div-create-paciente_ci">
                                        <input name="paciente_ci" value="{{(!empty(old('paciente_ci'))) ? old('paciente_ci') : $factura->paciente_ci}}" class="app-form-control form-control  fadeInLeft animated" id="input-paciente_ci" type="number" required disabled>
                                        @if ($errors->has('paciente_ci'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('paciente_ci')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-8">
                                    <label class="app-label paciente_nombre"><span>*</span>  A nombre de:</label>
                                    <div class="div-create-paciente_nombre">
                                        <input name="paciente_nombre" value="{{(!empty(old('paciente_nombre'))) ? old('paciente_nombre') : $factura->paciente_nombre}}" class="app-form-control form-control  fadeInLeft animated" id="input-paciente_nombre" type="text" required disabled>
                                        @if ($errors->has('paciente_nombre'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('paciente_nombre')}}</div>
                                        @endif
                                    </div>
                                </div>

                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <label class="app-label monto"><span>*</span>  Monto:</label>
                                    <div class="div-create-monto">
                                        <input name="monto" value="{{(!empty(old('monto'))) ? old('monto') : $factura->monto}}" class="app-form-control form-control  fadeInLeft animated" id="input-monto" type="text" required disabled>
                                        @if ($errors->has('monto'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('monto')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-12">
                                    <label class="app-label concepto"><span>*</span>  Concepto:</label>
                                    <div class="div-create-concepto">
                                        <input name="concepto" value="{{(!empty(old('concepto'))) ? old('concepto') : $factura->concepto}}" class="app-form-control form-control  fadeInLeft animated" id="input-concepto" type="text" required disabled>
                                        @if ($errors->has('concepto'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('concepto')}}</div>
                                        @endif
                                    </div>
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
        $("#menu-administracion-factura").addClass("active");
        $("#menu-factura-form-buscar").addClass("active");
    });

    
    
</script>
@endsection

