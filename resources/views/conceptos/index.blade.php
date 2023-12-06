<?php
use App\Helpers\FuncionesComunes;
?>
@extends('admin.templates.contenido')

@section('link')
    <link href="{{ url('') }}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
        rel="stylesheet" />
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
                <div class="row">
                    <div class="col-md-9 text-center" style="">
                        <h2 style="margin-bottom:0">Conceptos</h2>

                    </div>
                    <div class="col-md-12" style="">
                        @if (Session::has('mensaje'))
                            <div class="alert alert-{{ Session::get('class-alert') }} fade in m-b-15"
                                style="margin-bottom:0">
                                {{ Session::get('mensaje') }}
                                <span class="close" data-dismiss="alert">×</span>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="panel-body">
                    <a href="{{ route('conceptos.create') }}" class="btn btn-success" id="tabla-button-nuevo">Nuevo</a>
                    <table id="data-table" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>Expandir</th>
                                <th id="th-id">Código</th>
                                <th id="th-nombre">Nombre</th>
                                <th id="th-costo">Costo</th>
                                <th id="th-especialidad">Especialidad</th>
                                <th id="th-acciones">Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tbody">
                            @if (!empty($conceptos))
                                @foreach ($conceptos as $key => $value)
                                    <tr class="" id="tabla-tr-1">
                                        <td></td>
                                        <td>{{ $value->id }}</td>
                                        <td>{{ $value->nombre }}</td>
                                        <td>{{ $value->costo }}</td>
                                        <td>{{ $value->especialidad->especialidad }}</td>
                                        <td class="td-acciones">
                                            @if (auth()->user()->hasRole('administrador'))
                                                <a class="btn btn-xs btn-info"
                                                    href="{{ route('conceptos.edit', $value->id) }}" title=""
                                                    target="blank"><span class="fa fa-pencil-square-o"></span> Editar</a>
                                            @endif
                                            @if (auth()->user()->hasRole('administrador'))
                                                <button class="btn btn-xs btn-danger"
                                                    onclick="clickEliminar('{{ route('conceptos.destroy', $value->id) }}')"
                                                    title=""><span class="fa fa-trash"></span> Eliminar</Button>
                                            @endif
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
    <input id="input-modal-borrar" type="hidden" class="btn btn-primary btn-lg" data-toggle="modal"
        data-target="#modal-borrar">

    <!-- Modal -->
    <div class="modal fade" id="modal-borrar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" style="width:40%">
            <div class="modal-content">
                <div class="modal-header bg-red">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel" style="color:#FFF">Alerta confirmar</h4>
                </div>
                <div class="modal-body">
                    ¿Esta seguro de eliminar el registro?
                    <form method="post" id="form-eliminar" action="">
                        @csrf
                        <input type="hidden" name="_method" value="delete">
                    </form>
                    <input type="hidden" id="borrar-id">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-danger" onclick="eliminar()">Si</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script_1')
    <script src="{{ url('') }}/assets/plugins/DataTables/media/js/jquery.dataTables.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/media/js/dataTables.bootstrap.min.js"></script>

    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/dataTables.buttons.min.js"></script>

    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/buttons.bootstrap.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/buttons.flash.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/jszip.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/pdfmake.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/vfs_fonts.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/buttons.html5.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/js/buttons.print.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/js/dataTables.responsive.min.js">
    </script>
    <script src="{{ url('') }}/assets/js/table-manage-buttons.demo.min.js"></script>

    <!-- ================== END PAGE LEVEL JS ================== -->
@endsection

@section('script_3')
    <script>
        $(document).ready(function() {
            TableManageButtons.init();
        });
    </script>
    <script>
        function clickEliminar(url) {
            $("#form-eliminar").attr("action", url);
            $("#input-modal-borrar").trigger("click");
        }

        function eliminar() {
            var id = $("#borrar-id").val();
            $("#form-eliminar").submit();
        }
    </script>
@endsection
