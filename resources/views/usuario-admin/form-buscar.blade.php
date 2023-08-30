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
                        <div class="col-md-9" style="">
                            <h2>Formulario Buscar Usuarios</h2>
                        </div>    
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div  class="col-md-12 app-card style-card">
                                <!-- begin col-2 -->
                                <form action="{{url('usuario-buscar-por-carnet')}}" method="post" accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
                                    {{csrf_field()}}
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label control-label col-md-3 text-right">C.I.:</label>
                                        <div class="div-create-nombre1 col-md-6">
                                            <input name="numero_documento" class="app-form-control form-control  fadeInLeft animated" id="input-nombre1" type="text" required="" value="<?= (!empty($numero_documento))?$numero_documento:''?>">
                                        </div>
                                        <div class="form-group col-md-3" style="">
                                            <input type="submit" value="Buscar" name="guardar" class="btn btn-success fadeInLeft animated">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        
                    </div>                           
                    
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="8" class="text-center"><h3>Datos de la Persona</h3></th>
                                </tr>
                                <tr>
                                    <th>C.I.</th>
                                    <th>Expedido</th>
                                    <th>Nombre</th>
                                    <th>Telefono</th>
                                    <th>Celular</th>
                                    <th>Persona</th>
                                    <th>Usuario</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($persona))
                                @foreach($persona as $key => $value)
                                <tr>
                                    <td>{{$value->numero_documento}}</td>
                                    <td>{{$value->expedido}}</td>
                                    <td>{{$value->nombre1}} {{$value->nombre2}} {{$value->paterno}} {{$value->materno}}</td>
                                    <td>{{$value->telefono}}</td>
                                    <td>{{$value->celular}}</td>
                                    <td>
                                        <form action="{{url('persona-buscar')}}" method="post">
                                            {{csrf_field()}}
                                            <input type="hidden" name="numero_documento" value="{{$value->numero_documento}}">
                                            <button class="btn btn-primary btn-xs m-r-5" style="margin-bottom:3px">
                                                <span class="fa fa-eye fa-lg"></span>
                                            </button>
                                        </form>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-xs m-r-5" href="{{url('usuario-nuevo/'.$value->id)}}" target="blank" style="margin-bottom:3px">
                                            <span class="fa fa-plus fa-lg"></span> Usuario
                                        </a>
                                        
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="10" class="text-center"><h3>Datos del Usuario</h3></th>
                                </tr>
                                <tr>
                                    <th>Nombre de usuario</th>
                                    <th>E-mail</th>
                                    <th>Fecha Registro</th>
                                    <th>Fecha Actualizado</th>    
                                    <th>Imprimir</th>
                                    <th>Editar</th>
                                    <th>Administrar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($usuario->name))
                                <tr>
                                    <td>{{$usuario->name}}</td>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{$usuario->created_at}}</td>
                                    <td>{{$usuario->updated_at}}</td>
                                    <td>
                                        <a class="btn btn-primary btn-xs m-r-5" href="{{url('usuario-reporte/'.$usuario->id)}}" target="blank">
                                            <span class="fa fa-print fa-lg"></span> PDF
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-xs m-r-5" href="{{url('usuario-modificar/'.$usuario->id)}}" target="blank">
                                            <span class="fa fa-pencil-square-o fa-lg"></span> Editar
                                        </a>
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-xs m-r-5" href="{{url('usuario-asignar-roles/'.$usuario->id)}}" target="blank">
                                            Roles
                                        </a>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                            

                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th colspan="8" class="text-center"><h3>Roles asignados al usuario</h3></th>
                                </tr>
                                <tr>
                                    <th>Codigo del Rol</th>
                                    <th>Nombre del Rol</th>
                                    <th>Slug del Rol</th>
                                    <th>Full acceso</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(!empty($roles))
                                @foreach($roles as $key => $value)
                                <tr>
                                    <td>{{$value->role_id}}</td>
                                    <td>{{$value->name}}</td>
                                    <td>{{$value->slug}}</td>
                                    <td>{{$value->special}}</td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
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
    });
    
</script>
@endsection

