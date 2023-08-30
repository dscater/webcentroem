@extends('layouts.admin')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/bootstrap-toggle-master/css/bootstrap-toggle.min.css" rel="stylesheet">

@endsection

@section('content')
<div class="content">
    <!-- begin row -->
    <div class="row">
        <!-- begin col-12 -->
        <div class="col-md-12">
        
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Panel</h4>
                </div>
                <!--div class="alert alert-warning fade in">
                    <button type="button" class="close" data-dismiss="alert">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
                </div-->
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12" style="">
                            @if (Session::has('mensaje'))
                            @foreach(Session::get('mensaje') as $value)
                            <div class="alert alert-{{Session::get('class-alert')}} fade in m-b-15" style="margin-bottom:0">
                                {{$value}}
                                <span class="close" data-dismiss="alert">×</span>
                            </div>
                            @endforeach
                            @endif
                        </div> 
                        <div class="col-md-9" style="">
                            <h2>Formulario Asignación de Permisos</h2>
                        </div>
                    </div>
                    
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="8" class="text-center"><h3>Datos del Rol</h3></th>
                                        </tr>
                                        <tr>
                                            <th>Codigo del Rol</th>
                                            <th>Nombre del Rol</th>
                                            <th>Slug del Rol</th>
                                            <th>Descripción</th>
                                            <th>Especial</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{{$role->id}}</td>
                                            <td>{{$role->name}}</td>
                                            <td>{{$role->slug}}</td>
                                            <td>{{$role->description}}</td>
                                            <td>{{$role->special}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <form action="{{url('roles-asignar-permisos-registrar/'.$role->id)}}" method="post">
                                {{csrf_field()}}
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th colspan="8" class="text-right">
                                                    <h3>
                                                        <input type="submit" value="Registrar Permisos" name="guardar" class="btn btn-success fadeInLeft animated">
                                                        
                                                    </h3>
                                                </th>
                                            </tr>
                                            <tr>
                                                <th>Descripción</th>
                                                <th>Slug del Permiso</th>
                                                <th>¿Asignar?</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if(!empty($permisos))
                                            @foreach($permisos as $key => $value)
                                            <tr>
                                                <td>
                                                    <div class="note note-success" style="padding: 5px 5px">
                                                        <h4  style="margin-top:0;margin-bottom:0">{{$value->name}}</h4>
                                                        <p style="margin-bottom:0">{{$value->description}}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <h3 class="label label-success" style="font-size:15px">{{$value->slug}}</h3>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="permission_id[]" value="{{$value->id}}">
                                                    <div class="checkbox">
                                                        <label>
                                                            <input value="{{$value->id}}" type="checkbox" name="asignar[]" data-toggle="toggle" data-on="si" data-off="no" <?=($value->asignado=="si")?'checked':''?> data-onstyle="info">
                                                        </label>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>                    
                </div>
            </div>
            <!-- end panel -->
        </div>
        <!-- end col-10 -->
    </div>

    <!-- Button trigger modal -->
    <input id="input-modal-reporte" type="hidden" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-reporte">

    <!-- Modal -->
    <div class="modal fade" id="modal-reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:100%">
        <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Reporte</h4>
        </div>
        <div class="modal-body">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
        </div>
    </div>
    </div>

    <!-- end row -->
</div>
@endsection


@section("script_1")
<script src="{{url('')}}/assets/plugins/bootstrap-toggle-master/js/bootstrap-toggle.min.js"></script>
<!-- ================== END PAGE LEVEL JS ================== -->
@endsection

@section("script_3")
<script>
    $('document').ready(function () {
        $("#menu-usuario").addClass("active");
        $("#menu-usuario-buscar").addClass("active");
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
        $(".datos-persona .form-control").prop( "disabled", true );
        $(".datos-persona input").prop( "disabled", true );
        $(".datos-persona .chosen-select").attr('disabled', true).trigger("chosen:updated")
    });
    function guardarRol(id){
        alert("#form-"+id)
        $("#form-"+id).submit();
    }
    
</script>
@endsection