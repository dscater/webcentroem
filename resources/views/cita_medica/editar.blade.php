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

                    <div class="panel-body" style="min-height:1000px">
                        <form action="{{ url('cita-medica-modificar-registrar/' . $cita_medica->id) }}" method="post"
                            accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <h2 class="col-md-8 col-md-offset-2" id="titulo">Modificar Cita Médica</h2>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-2 form-group" style="">
                                    <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                                    <a href="{{ url('cita-medica-form-buscar') }}" class="btn btn-success">Cancelar</a>
                                </div>
                                <div class="col-md-12">
                                    @if (Session::has('mensaje'))
                                        <div class="alert alert-{{ Session::get('class-alert') }} fade in m-b-15"
                                            style="margin-bottom:0">
                                            {{ Session::get('mensaje') }}
                                            <span class="close" data-dismiss="alert">×</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <h5>DATOS</h5>
                                </div>


                                <div class="col-12">
                                    @if (!auth()->user()->hasRole('paciente'))
                                        <div class="app-form-group form-group col-md-12">
                                            <label class="app-label"><span>*</span> Paciente:</label>
                                            <div class="div-create-id_persona">
                                                <?php $id_persona = !empty(old('id_persona')) ? old('id_persona') : $cita_medica->id_paciente; ?>
                                                <select name="id_persona" id="id_persona" class="form-control chosen-select"
                                                    data-rel="chosen" placeholder="Seleccionar" requiredd>
                                                    <option value="">Seleccionar</option>
                                                    @if (!empty($paciente))
                                                        @foreach ($paciente as $key => $value)
                                                            <option value="{{ $value->id_persona }}" <?php echo $value->id_persona == $id_persona ? 'selected' : ''; ?>>
                                                                CI: {{ $value->ci }} - {{ $value->nombre }}
                                                                {{ $value->paterno }} {{ $value->materno }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('id_persona'))
                                                <div class="app-alert alert alert-danger">El campo es requerido</div>
                                            @endif
                                        </div>
                                    @endif

                                    @if (
                                        !auth()->user()->hasRole('secretaria') &&
                                            !auth()->user()->hasRole('doctor'))
                                        <div class="app-form-group form-group col-md-12">
                                            <label class="app-label"><span>*</span> Especialidad:</label>
                                            <div class="div-create-id_especialidad">
                                                <?php $id_especialidad = !empty(old('id_especialidad')) ? old('id_especialidad') : $cita_medica->id_especialidad; ?>
                                                <select name="id_especialidad" id="id_especialidad"
                                                    class="form-control chosen-select" data-rel="chosen"
                                                    placeholder="Seleccionar" requiredd>
                                                    <option value="">Seleccionar</option>
                                                    @if (!empty($especialidad))
                                                        @foreach ($especialidad as $key => $value)
                                                            <option value="{{ $value->id }}" <?php echo $value->id == $id_especialidad ? 'selected' : ''; ?>>
                                                                {{ $value->especialidad }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('id_especialidad'))
                                                <div class="app-alert alert alert-danger">El campo es requerido</div>
                                            @endif
                                            <div class="app-alert alert alert-danger" style="display:none"
                                                id="alert-especialidad">El campo es requerido para mostrar horas</div>
                                        </div>
                                    @endif
                                    <!-- end col-2 -->

                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span> Fecha de la cita:</label>
                                        <div class="div-create-id_especialidad">
                                            <?php $fecha = !empty(old('fecha')) ? old('fecha') : $cita_medica->fecha_cita; ?>
                                            <input type="date" name="fecha_cita" id="fecha_cita"
                                                value="{{ $fecha }}" class="form-control">
                                        </div>
                                        @if ($errors->has('fecha_cita'))
                                            <div class="app-alert alert alert-danger">El campo es requerido</div>
                                        @endif
                                        <div class="app-alert alert alert-danger" style="display:none" id="alert-fecha">El
                                            campo es requerido para mostrar horas</div>
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <button class="btn btn-success" type="button" onclick="getHoras()">Buscar
                                            horas</button>
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span> Horas:</label>
                                        <div class="div-create-id_especialidad">
                                            <select name="hora" id="hora" class="form-control chosen-select"
                                                data-rel="chosen" placeholder="Seleccionar" requiredd>
                                                <option value="">Seleccionar</option>
                                            </select>
                                        </div>
                                        @if ($errors->has('hora'))
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

@section('script_3')
    <script>
        $('document').ready(function() {
            $("#menu-cita-medico-form-buscar").addClass("active");

        });

        $("#fecha_cita").on("change", function() {

            $("#hora").html("");
            $("#hora").append('<option value="">Seleccionar</option>');
            $("#hora").val("");
            $("#hora").trigger("chosen:updated")
        })

        $("#id_especialidad").on("change", function() {
            $("#hora").html("");
            $("#hora").append('<option value="">Seleccionar</option>');
            $("#hora").val("");
            $("#hora").trigger("chosen:updated")
        })

        function getHoras() {
            $("#alert-especialidad").css("display", "none")
            $("#alert-fecha").css("display", "none")
            $("#hora").html("");
            $("#hora").append('<option value="">Seleccionar</option>');
            var fecha = $("#fecha_cita").val();
            var id_especialidad = $("#id_especialidad").val();

            @if (auth()->user()->hasRole('administrador') ||
                    auth()->user()->hasRole('paciente'))
                if (id_especialidad == "") {
                    $("#alert-especialidad").css("display", "block")
                }
            @endif
            if (fecha == "") {
                $("#alert-fecha").css("display", "block")
            }

            <?php $hora = !empty(old('hora')) ? old('hora') : $cita_medica->id_doctor . '-' . $cita_medica->hora; ?>
            var hora = '{{ $hora }}';
            $.ajax({
                type: "get",
                contentType: "application/json",
                dataType: "json",
                url: "{{ url('') }}/cita-medica-get-hora-por-fecha/" + fecha + "/" + id_especialidad,

                success: function(data) {
                    console.log(data.horas)
                    var disabled = "";
                    var disponible = "";
                    var selected = "";
                    // data.horas.forEach(function(element, index) {
                    //     disabled = (element.estado_hora == 'ocupado') ? 'disabled' : '';
                    //     disponible = (element.estado_hora == 'ocupado') ? 'OCUPADO' : 'DISPONIBLE';
                    //     if (hora == element.hora) {
                    //         $("#hora").append('<option value="' + element.hora + '" selected>' + element
                    //             .hora + ' ' + disponible + '</option>');
                    //     } else {
                    //         $("#hora").append('<option value="' + element.hora + '" ' + disabled + '>' +
                    //             element.hora + ' ' + disponible + '</option>');
                    //     }

                    // })

                    data.horas.forEach(function(element, index) {
                        disabled = (element.maniana.estado == 'OCUPADO') ? 'disabled' : '';
                        disponible = (element.maniana.estado == 'OCUPADO') ? 'OCUPADO' : 'DISPONIBLE';
                        selected = "";
                        if (hora == element.maniana.value) {
                            selected = " selected";
                        }
                        $("#hora").append('<option value="' + element.maniana.value + '" ' + disabled +
                            selected + '>' +
                            element.maniana.label + ' (' + element.maniana.estado + ')</option>');

                        disabled = (element.tarde.estado == 'OCUPADO') ? 'disabled' : '';
                        disponible = (element.tarde.estado == 'OCUPADO') ? 'OCUPADO' : 'DISPONIBLE';
                        selected = "";
                        if (hora == element.tarde.value) {
                            selected = " selected";
                        }
                        $("#hora").append('<option value="' + element.tarde.value + '" ' + disabled +
                            selected + '>' +
                            element.tarde.label + ' (' + element.tarde.estado + ')</option>');
                    })

                    $("#hora").trigger("chosen:updated")

                }
            });
        }

        getHoras();
    </script>
@endsection
