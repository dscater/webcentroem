@extends('layouts.admin')

@section('link')
    <link href="{{ url('') }}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .panel_nuevo {
            border: solid 1px gray;
            border-radius: 10px;
            padding: 10px;
        }

        .panel_nuevo .panel-body {
            padding-top: 0px;
        }

        table.tabla_calendario thead tr th {
            background: #6E237E!important;
            color: white!important;
        }
    </style>
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

                    <div class="panel-body">
                        <h2 class="col-md-12" id="titulo">Calendario de atención</h2>
                        <div class="row">
                            <div class="col-md-12">
                                @if (Session::has('bien'))
                                    <div class="alert alert-success fade in m-b-15" style="margin-bottom:0">
                                        {{ Session::get('bien') }}
                                        <span class="close" data-dismiss="alert">×</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">
                                <div class="panel panel-default panel_nuevo">
                                    <form class="panel-body"
                                        action="{{ route('calendario_atencions.store', $usuario->id) }}" method="post"
                                        accept-charset="utf-8" id="" enctype="multipart/form-data">
                                        <h5 class="text-center">NO SE ATENDERÁ EN FECHAS</h5>
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-md-6 form-group">
                                                <label>Fecha inicio*:</label>
                                                <input type="date" name="fecha_ini" class="form-control">
                                                @if ($errors->has('fecha_ini'))
                                                    <span class="invalid-feedback text-danger" style="display:block"
                                                        role="alert">
                                                        <strong>{{ $errors->first('fecha_ini') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-6 form-group">
                                                <label>Fecha final*:</label>
                                                <input type="date" name="fecha_fin" class="form-control">
                                                @if ($errors->has('fecha_fin'))
                                                    <span class="invalid-feedback text-danger" style="display:block"
                                                        role="alert">
                                                        <strong>{{ $errors->first('fecha_fin') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-success">
                                                    <i class="fa fa-plus"></i> Agregar
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="w-100 text-center font-md">CALENDARIO - LISTADO</h4>
                            </div>
                            <div class="col-md-12" style="overflow: auto;">
                                <table class="table table-bordered tabla_calendario">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle" rowspan="2">CÓDIGO</th>
                                            <th colspan="2" class="text-center">NO SE ATENDERÁ EN FECHAS</th>
                                            <th style="vertical-align: middle" rowspan="2">ACCIÓN</th>
                                        </tr>
                                        <tr>
                                            <th>FECHA INICIO</th>
                                            <th>FECHA FIN</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($calendario_atencions) > 0)
                                            @foreach ($calendario_atencions as $ca)
                                                <tr>
                                                    <td>{{ $ca->id }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($ca->fecha_ini)) }}</td>
                                                    <td>{{ date('d/m/Y', strtotime($ca->fecha_fin)) }}</td>
                                                    <td>
                                                        <button class="btn btn-xs btn-danger"
                                                            onclick="clickEliminar('{{ route('calendario_atencions.destroy', $ca->id) }}')"
                                                            title=""><span class="fa fa-trash"></span>
                                                            Eliminar</Button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center">SIN REGISTROS</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-12 text-center">
                                {{ $calendario_atencions->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
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

@section('script_3')
    <script>
        $(document).ready(function() {});
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
