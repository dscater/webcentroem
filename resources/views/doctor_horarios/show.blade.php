@extends('layouts.admin')

@section('link')
    <link href="{{ url('') }}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
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

                    <div class="panel-body">
                        <form action="{{ route('doctor_horarios.update', $usuario->id) }}" method="post"
                            accept-charset="utf-8" id="" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <h2 class="col-md-12" id="titulo">Gestionar Horarios</h2>
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
                                <div class="col-md-12">
                                    <h5 class="text-center">HORARIOS</h5>
                                </div>
                                <div class="col-md-12">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>DÍA</th>
                                                <th>ACTIVO/INACTIVO</th>
                                                <th colspan="2">TURNO MAÑANA</th>
                                                <th colspan="2">TURNO TARDE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($doctor_horarios as $dh)
                                                <tr>
                                                    <td>{{ $dh->dia }}<input type="hidden" name="id[]"
                                                            value="{{ $dh->id }}"></td>
                                                    <td>
                                                        <select name="estado[]" class="form-control">
                                                            <option value="ACTIVO"
                                                                {{ $dh->estado == 'ACTIVO' ? 'selected' : '' }}>ACTIVO
                                                            </option>
                                                            <option value="INACTIVO"
                                                                {{ $dh->estado == 'INACTIVO' ? 'selected' : '' }}>INACTIVO
                                                            </option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="time" name="tm_hora_ini[]"
                                                            value="{{ $dh->tm_hora_ini }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="tm_hora_fin[]"
                                                            value="{{ $dh->tm_hora_fin }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="tt_hora_ini[]"
                                                            value="{{ $dh->tt_hora_ini }}" class="form-control">
                                                    </td>
                                                    <td>
                                                        <input type="time" name="tt_hora_fin[]"
                                                            value="{{ $dh->tt_hora_fin }}" class="form-control">
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-md-3">
                                    <button class="btn btn-success btn-block btn-flat" id="btnGuardaCambios">Guardar
                                        cambios</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_3')
    <script>
        $(document).ready(function() {
            $("#btnGuardaCambios").hide();
            $(document).on("change", "input,select", function() {
                $("#btnGuardaCambios").show();
            })
        });
    </script>
@endsection
