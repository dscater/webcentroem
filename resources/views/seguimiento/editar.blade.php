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
                    <form action="{{url('seguimiento-modificar-registrar/'.$seguimiento->id)}}" method="post" accept-charset="utf-8"
                        id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h2 class="col-md-8 col-md-offset-2" id="titulo">Modificar datos del Seguimiento y Control</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2 form-group" style="">
                                <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                                <a href="{{url('seguimiento-form-buscar')}}" class="btn btn-success">Cancelar</a>
                                <a href="{{url('seguimiento-reporte/'.$seguimiento->id)}}" target="_blank" class="btn btn-success"><i class="fa fa-print"></i> PDF</a>
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
                                    <?php $id_persona = (!empty(old('id_persona'))) ? old('id_persona'):$seguimiento->id_persona ?>
                                    <label class="app-label"><span>*</span> Paciente:</label>
                                    <div class="div-create-id_especialidad">
                                        <select name="id_persona" id="id_persona" class="form-control chosen-select" data-rel="chosen" placeholder="Seleccionar" requiredd>
                                            <option value="">Seleccionar</option>
                                            @if(!empty($paciente))
                                            @foreach($paciente as $key => $value)
                                            <option value="{{$value->id_persona}}" <?php echo ($value->id_persona==$id_persona)?"selected":""?>>Cód. Paciente: {{$value->name}} - {{$value->nombre}} {{$value->paterno}} {{$value->materno}} CI: {{$value->ci}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('id_persona'))
                                    <div class="app-alert alert alert-danger">El campo es requerido</div>
                                    @endif
                                </div>
                        
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $tratamiento = (!empty(old('tratamiento'))) ? old('tratamiento'):$seguimiento->tratamiento ?>
                                    <label class="text-left" ><span>*</span>  Motivo de la Consulta:</label>
                                    <textarea name="tratamiento" class="form-control " id="input-tratamiento">{{$tratamiento}}</textarea>
                                    @if ($errors->has('tratamiento'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('tratamiento')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $descripcion_evolucion = (!empty(old('descripcion_evolucion'))) ? old('descripcion_evolucion'):$seguimiento->descripcion_evolucion ?>
                                    <label class="text-left" ><span>*</span>  Dolencia Actual:</label>
                                    <textarea name="descripcion_evolucion" class="form-control " id="input-descripcion_evolucion">{{$descripcion_evolucion}}</textarea>
                                    @if ($errors->has('descripcion_evolucion'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('descripcion_evolucion')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $medicamento = (!empty(old('medicamento'))) ? old('medicamento'):$seguimiento->medicamento ?>
                                    <label class="text-left" ><span>*</span>  Antecedentes Patológicos Familiares:</label>
                                    <textarea name="medicamento" class="form-control " id="input-medicamento">{{$medicamento}}</textarea>
                                    @if ($errors->has('medicamento'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('medicamento')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <?php $fecha = (!empty(old('fecha'))) ? old('fecha'): date("Y-m-d", strtotime($seguimiento->fecha_hora)) ?>
                                    <label class="app-label fecha"><span>*</span>  Fecha y hora:</label>
                                    <div class="div-create-fecha">
                                        <input name="fecha" value="{{$fecha}}" class="app-form-control form-control  fadeInLeft animated" id="input-fecha" type="date" requiredd>
                                        @if ($errors->has('fecha'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('fecha')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <?php $hora = (!empty(old('hora'))) ? old('hora'): (int) date("H", strtotime($seguimiento->fecha_hora)) ?>
                                    <label class="app-label hora"><span>*</span>  Hora:</label>
                                    <div class="div-create-hora">
                                        <input name="hora" value="{{$hora}}" class="app-form-control form-control  fadeInLeft animated" id="input-hora" type="number" requiredd>
                                        @if ($errors->has('hora'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('hora')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <?php $minuto = (!empty(old('minuto'))) ? old('minuto'): (int) date("i", strtotime($seguimiento->fecha_hora)) ?>
                                    <label class="app-label minuto"><span>*</span>  Minuto:</label>
                                    <div class="div-create-minuto">
                                        <input name="minuto" value="{{$minuto}}" class="app-form-control form-control  fadeInLeft animated" id="input-minuto" type="number" requiredd>
                                        @if ($errors->has('minuto'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('minuto')}}</div>
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
        $("#menu-administracion-seguimiento").addClass("active");
        $("#menu-seguimiento-form-buscar").addClass("active");
        $("#btn-foto").click(function () {
            $("#input-foto").trigger("click");    
        });
        $("#input-foto").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-foto').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
</script>
@endsection

