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
                    <form action="{{url('asignacion-especialidad-nuevo-registrar')}}" method="post" accept-charset="utf-8"
                        id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h2 class="col-md-8 col-md-offset-2" id="titulo">Nueva Asignación de Especialidad</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2 form-group" style="">
                                <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                                <a href="{{url('asignacion-especialidad-form-buscar')}}" class="btn btn-success">Cancelar</a>
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
                                    <label class="app-label"><span>*</span> Doctor:</label>
                                    <div class="div-create-id_especialidad">
                                        <select name="id_persona" id="id_persona" class="form-control chosen-select" data-rel="chosen" placeholder="Seleccionar" requiredd>
                                            <option value="">Seleccionar</option>
                                            @if(!empty($doctor))
                                            @foreach($doctor as $key => $value)
                                            <option value="{{$value->id_persona}}" <?php echo ($value->id_persona==old("id_persona"))?"selected":""?>>Cód. Usuario: {{$value->name}} - {{$value->nombre}} {{$value->paterno}} {{$value->materno}} CI: {{$value->ci}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('id_persona'))
                                    <div class="app-alert alert alert-danger">El campo es requerido</div>
                                    @endif
                                </div>
                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span>*</span> Especialidad:</label>
                                    <div class="div-create-id_especialidad">
                                        <select name="id_especialidad" id="id_especialidad" class="form-control chosen-select" data-rel="chosen" placeholder="Seleccionar" requiredd>
                                            <option value="">Seleccionar</option>
                                            @if(!empty($especialidad))
                                            @foreach($especialidad as $key => $value)
                                            <option value="{{$value->id}}" <?php echo ($value->id==old("id_especialidad"))?"selected":""?>>{{$value->especialidad}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('id_especialidad'))
                                    <div class="app-alert alert alert-danger">El campo es requerido</div>
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
@endsection

@section("script_3")
<script>
    $('document').ready(function () {
        $("#menu-administracion-asignacion").addClass("active");
        $("#menu-asignacion-especialidad-nuevo").addClass("active");
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

