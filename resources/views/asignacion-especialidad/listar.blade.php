@extends('admin.templates.contenido')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
@endsection

@section('content_contenido')

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
            <div class="row">
                    <div class="col-md-9 text-center" style="">
                        <h2 style="margin-bottom:0">Administración de Asignación de Especialidad</h2>
                        
                    </div>
                    <div class="col-md-12" style="">
                        @if (Session::has('mensaje')) 
                        <div class="alert alert-{{Session::get('class-alert')}} fade in m-b-15" style="margin-bottom:0">
                            {{Session::get('mensaje')}}
                            <span class="close" data-dismiss="alert">×</span>
                        </div>
                        @endif
                    </div>    
                </div>
            <!--div class="alert alert-warning fade in">
                <button type="button" class="close" data-dismiss="alert">
                    <span aria-hidden="true">&times;</span>
                </button>
                The Buttons extension for DataTables provides a common set of options, API methods and styling to display buttons on a page that will interact with a DataTable. The core library provides the based framework upon which plug-ins can built.
            </div-->
            <div class="panel-body">
                <table id="data-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Expandir</th>
                            <th id="th-id">Código</th>
                            <th id="th-rol">Tipo de usuario</th>
                            <th id="th-especialidad">Especialidad</th>
                            <th id="th-id">Usuario</th>
                            <th id="th-nombres">Nombres</th>
                            <th id="th-paterno">Ap.Paterno</th>
                            <th id="th-materno">Ap.Materno</th>
                            <th id="th-ci">CI</th>
                            <th id="th-created_at">Fecha de Registro</th>
                            <th id="th-acciones">Acciones</th>                                                        
                        </tr>
                    </thead>
                    <tbody id="tbody">
                        @if(!empty($users))
                        @foreach($users as $key=>$value)
                        <tr class="" id="tabla-tr-1">
                            <td></td>
                            <td >{{$value->id}}</td>
                            <td >{{$value->rol}}</td>
                            <td >{{$value->especialidad}}</td>
                            <td >{{$value->name}}</td>
                            <td >{{$value->nombre}}</td>
                            <td >{{$value->paterno}}</td>
                            <td >{{$value->materno}}</td>
                            <td >{{$value->ci}}</td>
                            <td >{{date("d-m-Y", strtotime($value->created_at))}}</td>
                            <td class="td-acciones">
                                <a class="btn btn-xs btn-inverse" href="{{url('asignacion-especialidad-ver/'.$value->id)}}" target="blank"><span class="fa fa-eye"></span> Ver</a>
                                <a class="btn btn-xs btn-info" href="{{url('asignacion-especialidad-modificar/'.$value->id)}}" title="" target="blank"><span class="fa fa-pencil-square-o"></span> Editar</a>
                                <button class="btn btn-xs btn-danger" onclick="clickEliminar({{$value->id}})" title="" ><span class="fa fa-trash"></span> Eliminar</Button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
                
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

<!-- Button trigger modal -->
<input id="input-modal-borrar" type="hidden" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#modal-borrar">

<!-- Modal -->
<div class="modal fade" id="modal-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document" style="width:40%">
        <div class="modal-content">
        <div class="modal-header bg-red">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel" style="color:#FFF">Alerta confirmar</h4>
        </div>
        <div class="modal-body">
            ¿Esta seguro de eliminar el registro?
            <input type="hidden" id="borrar-id">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
            <button type="button" class="btn btn-danger" onclick="eliminar()">Si</button>
        </div>
        </div>
    </div>
</div>

<!-- end row -->

@endsection


@section("script_1")
<script src="{{url('')}}/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>

<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>

<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
<script src="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js"></script>
<script src="{{url('')}}/assets/js/table-manage-buttons.demo.min.js"></script>

<!-- ================== END PAGE LEVEL JS ================== -->


@endsection

@section("script_3")
<script>
    $(document).ready(function() {
        TableManageButtons.init();
    });
</script>
<script>
    $('document').ready(function () {
        $("#menu-administracion-asignacion").addClass("active");
        $("#menu-asignacion-especialidad-form-buscar").addClass("active");
    });

    function clickEliminar(id) {
        $("#borrar-id").val(id)
        $("#input-modal-borrar").trigger("click");
    }
    function eliminar() {
        var id = $("#borrar-id").val();
        window.location.href = "{{url('asignacion-especialidad-eliminar')}}/"+id;
    }
    
</script>
@endsection

