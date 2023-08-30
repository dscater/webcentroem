@extends('layouts.admin')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
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
                            <h2>Administración de Roles</h2>
                        </div>
                        <div class="form-group" style="">
                            <h2></h2>
                            <a class="btn btn-success" href="{{url('roles-nuevo/')}}" target="blank">
                                <span class="fa fa-plus"></span> Nuevo Rol
                            </a>
                        </div>
                    </div>
                    
                    <!-- end row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th colspan="8" class="text-center"><h3>Roles</h3></th>
                                        </tr>
                                        <tr>
                                            <th>Codigo del Rol</th>
                                            <th>Nombre del Rol</th>
                                            <th>Slug del Rol</th>
                                            <th>Descripción</th>
                                            <th>Especial</th>
                                            <th>Editar</th>
                                            <th>Eliminar</th>
                                            <th>Administrar</th>
                                            <th>Imprimir</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(!empty($roles))
                                        @foreach($roles as $key => $value)
                                        <tr>
                                            <td>{{$value->id}}</td>
                                            <td>{{$value->name}}</td>
                                            <td>{{$value->slug}}</td>
                                            <td>{{$value->description}}</td>
                                            <td>{{$value->special}}</td>
                                            <td>
                                                <a class="btn btn-primary btn-xs m-r-5" href="{{url('roles-modificar/'.$value->id)}}" target="blank">
                                                    <span class="fa fa-edit"></span> Editar
                                                </a>
                                            </td>
                                            <td>
                                                <form action="{{url('roles-eliminar/'.$value->id)}}" method="post">
                                                    {{csrf_field()}}
                                                    <button class="btn btn-danger btn-xs m-r-5" type="submit" target="blank">
                                                        <span class="fa fa-edit"></span> Eliminar
                                                    </button>
                                                </form>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-xs m-r-5" href="{{url('roles-asignar-permisos/'.$value->id)}}" target="blank">
                                                    Permisos
                                                </a>
                                            </td>
                                            <td>
                                                <a class="btn btn-primary btn-xs m-r-5" href="{{url('roles-reporte/'.$value->id)}}" target="blank">
                                                    <span class="fa fa-print"></span> PDF
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
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
    $('document').ready(function () {
        $("#menu-usuario").addClass("active");
        $("#menu-roles").addClass("active");
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