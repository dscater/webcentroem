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
                    <form action="{{url('historial-clinico-modificar-registrar/'.$historial_clinico->id)}}" method="post" accept-charset="utf-8"
                        id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h2 class="col-md-8 col-md-offset-2" id="titulo">Ver datos del Historial Clínico</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2 form-group" style="">
                                <!--input type="submit" value="Guardar" name="guardar" class="btn btn-success"-->
                                <a href="{{url('historial-clinico-form-buscar')}}" class="btn btn-success">Volver al listado</a>
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
                                    <?php $id_persona = (!empty(old('id_persona'))) ? old('id_persona'):$historial_clinico->id_persona ?>
                                    <label class="app-label"><span>*</span> Paciente:</label>
                                    <div class="div-create-id_especialidad">
                                        <select name="id_persona" id="id_persona" class="form-control chosen-select" data-rel="chosen" placeholder="Seleccionar" requiredd disabled>
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
                                    <?php $motivo_consulta = (!empty(old('motivo_consulta'))) ? old('motivo_consulta'):$historial_clinico->motivo_consulta ?>
                                    <label class="text-left" ><span>*</span>  Motivo de la Consulta:</label>
                                    <textarea name="motivo_consulta" class="form-control " id="input-motivo_consulta" disabled>{{$motivo_consulta}}</textarea>
                                    @if ($errors->has('motivo_consulta'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('motivo_consulta')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $dolencia_actual = (!empty(old('dolencia_actual'))) ? old('dolencia_actual'):$historial_clinico->dolencia_actual ?>
                                    <label class="text-left" ><span>*</span>  Dolencia Actual:</label>
                                    <textarea name="dolencia_actual" class="form-control " id="input-dolencia_actual" disabled>{{$dolencia_actual}}</textarea>
                                    @if ($errors->has('dolencia_actual'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('dolencia_actual')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $antecedente_familiar = (!empty(old('antecedente_familiar'))) ? old('antecedente_familiar'):$historial_clinico->antecedente_familiar ?>
                                    <label class="text-left" ><span>*</span>  Antecedentes Patológicos Familiares:</label>
                                    <textarea name="antecedente_familiar" class="form-control " id="input-antecedente_familiar" disabled>{{$antecedente_familiar}}</textarea>
                                    @if ($errors->has('antecedente_familiar'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('antecedente_familiar')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $antecedente_personal = (!empty(old('antecedente_personal'))) ? old('antecedente_personal'):$historial_clinico->antecedente_personal ?>
                                    <label class="text-left" ><span>*</span>  Antecedentes Patológicos Personales:</label>
                                    <textarea name="antecedente_personal" class="form-control " id="input-antecedente_personal" disabled>{{$antecedente_personal}}</textarea>
                                    @if ($errors->has('antecedente_personal'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('antecedente_personal')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="app-form-group form-group col-md-12 ">
                                    <?php $diagnostico = (!empty(old('diagnostico'))) ? old('diagnostico'):$historial_clinico->diagnostico ?>
                                    <label class="text-left" ><span>*</span>  Diagnóstico:</label>
                                    <textarea name="diagnostico" class="form-control " id="input-diagnostico" disabled><?php echo $diagnostico?></textarea>
                                    @if ($errors->has('diagnostico'))
                                    <div class="app-alert alert alert-danger">{{$errors->first('diagnostico')}}</div>
                                    @endif
                                </div>
                                <!-- end col-2 -->
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <?php $fecha = (!empty(old('fecha'))) ? old('fecha'): date("Y-m-d", strtotime($historial_clinico->fecha_hora)) ?>
                                    <label class="app-label fecha"><span>*</span>  Fecha:</label>
                                    <div class="div-create-fecha">
                                        <input name="fecha" value="{{$fecha}}" class="app-form-control form-control  fadeInLeft animated" id="input-fecha" type="date" requiredd disabled>
                                        @if ($errors->has('fecha'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('fecha')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <?php $hora = (!empty(old('hora'))) ? old('hora'): (int) date("H", strtotime($historial_clinico->fecha_hora)) ?>
                                    <label class="app-label hora"><span>*</span>  Hora:</label>
                                    <div class="div-create-hora">
                                        <input name="hora" value="{{$hora}}" class="app-form-control form-control  fadeInLeft animated" id="input-hora" type="number" requiredd disabled>
                                        @if ($errors->has('hora'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('hora')}}</div>
                                        @endif
                                    </div>
                                </div>
                                <!-- begin col-2 -->
                                <div class="form-group col-md-4">
                                    <?php $minuto = (!empty(old('minuto'))) ? old('minuto'): (int) date("i", strtotime($historial_clinico->fecha_hora)) ?>
                                    <label class="app-label minuto"><span>*</span>  Minuto:</label>
                                    <div class="div-create-minuto">
                                        <input name="minuto" value="{{$minuto}}" class="app-form-control form-control  fadeInLeft animated" id="input-minuto" type="number" requiredd disabled>
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
        $("#menu-administracion-historial").addClass("active");
        $("#menu-historial-clinico-form-buscar").addClass("active");
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

