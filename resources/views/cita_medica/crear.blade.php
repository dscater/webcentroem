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
                        <form action="{{ url('cita-medica-nuevo-registrar') }}" method="post" accept-charset="utf-8"
                            id="formulario-create" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <h2 class="col-md-8 col-md-offset-2" id="titulo">Nueva Cita Médica</h2>
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
                                                <select name="id_persona" id="id_persona" class="form-control chosen-select"
                                                    data-rel="chosen" placeholder="Seleccionar" requiredd>
                                                    <option value="">Seleccionar</option>
                                                    @if (!empty($paciente))
                                                        @foreach ($paciente as $key => $value)
                                                            <option value="{{ $value->id_persona }}" <?php echo $value->id_persona == old('id_persona') ? 'selected' : ''; ?>>
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
                                                <select name="id_especialidad" id="id_especialidad"
                                                    class="form-control chosen-select" data-rel="chosen"
                                                    placeholder="Seleccionar" requiredd>
                                                    <option value="">Seleccionar</option>
                                                    @if (!empty($especialidad))
                                                        @foreach ($especialidad as $key => $value)
                                                            <option value="{{ $value->id }}" <?php echo $value->id == old('id_especialidad') ? 'selected' : ''; ?>>
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
                                        <label class="app-label"><span>*</span> Prioridad:</label>
                                        <div class="div-create-prioridad">
                                            <select name="prioridad" id="prioridad" class="form-control chosen-select"
                                                data-rel="chosen" placeholder="Seleccionar" requiredd>
                                                <option value="">Seleccionar</option>
                                                <option value="CONSULTA">CONSULTA</option>
                                                <option value="CONTROL">CONTROL</option>
                                                <option value="RECONSULTA">RECONSULTA</option>
                                                <option value="EMERGENCIA">EMERGENCIA</option>
                                            </select>
                                        </div>
                                        @if ($errors->has('prioridad'))
                                            <div class="app-alert alert alert-danger">El campo es requerido</div>
                                        @endif
                                    </div>

                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span> Fecha de la cita:</label>
                                        <div class="div-create-id_especialidad">
                                            <input type="date" name="fecha_cita" id="fecha_cita" class="form-control">
                                        </div>
                                        @if ($errors->has('fecha_cita'))
                                            <div class="app-alert alert alert-danger">El campo es requerido</div>
                                        @endif
                                        <div class="app-alert alert alert-danger" style="display:none" id="alert-fecha">
                                            El
                                            campo es requerido para mostrar horas</div>
                                        <div class="app-alert alert alert-danger" style="display:none"
                                            id="alert-fecha-error">La fecha no es valida, debe ser una fecha igual o mayor
                                            al día de hoy</div>
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <button class="btn btn-success" id="btnBuscarHoras" type="button"
                                            onclick="getHoras()">Buscar
                                            horas</button>
                                    </div>
                                    <div class="app-form-group form-group col-md-12 contenedor_horas">
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
            $("#btnBuscarHoras").hide();
            $(".contenedor_horas").hide();
            $("#menu-cita-medico-nuevo").addClass("active");

            $("#btn-foto").click(function() {
                $("#input-foto").trigger("click");
            });
            $("#input-foto").change(function() {
                if (this.files && this.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#img-foto').attr('src', e.target.result);
                    }
                    reader.readAsDataURL(this.files[0]);
                }
            });


        });

        $("#fecha_cita").on("change keyup", function() {
            if (validaFecha()) {
                $("#hora").html("");
                $("#hora").append('<option value="">Seleccionar</option>');
                $("#hora").val("");
                $("#hora").trigger("chosen:updated")
                $("#btnBuscarHoras").show();
                $(".contenedor_horas").show();
                $("#alert-fecha-error").hide();
            } else {
                $("#hora").html("");
                $("#hora").append('<option value="">Seleccionar</option>');
                $("#hora").val("");
                $("#hora").trigger("chosen:updated")
                $("#alert-fecha-error").show();
                $("#btnBuscarHoras").hide();
                $(".contenedor_horas").hide();
            }
        })

        function validaFecha() {
            // Obtener la fecha ingresada en el formato "yyyy-mm-dd"
            let fechaIngresada = $("#fecha_cita").val();

            // Obtener la fecha actual en el mismo formato "yyyy-mm-dd"
            let fechaActual = new Date().toISOString().slice(0, 10);

            // Comparar las fechas
            if (fechaIngresada < fechaActual) {
                return false; // Devuelve false para evitar enviar el formulario
            }

            // La fecha es válida
            return true;
        }


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
            $.ajax({
                type: "get",
                contentType: "application/json",
                dataType: "json",
                url: "{{ url('') }}/cita-medica-get-hora-por-fecha/" + fecha + "/" + id_especialidad,

                success: function(data) {
                    // console.log(data.horas)
                    var disabled = "";
                    var disponible = "";
                    data.horas.forEach(function(element, index) {
                        element.maniana.forEach(function(e_m, i_m) {
                            disabled = (e_m.estado == 'OCUPADO') ? 'disabled' : '';
                            disponible = (e_m.estado == 'OCUPADO') ? 'OCUPADO' :
                                'DISPONIBLE';
                            $("#hora").append('<option value="' + e_m.value + '" ' +
                                disabled +
                                '>' +
                                e_m.hora + ' | ' + element.nom_doctor + ' (' + e_m.estado +
                                ')</option>');
                        });

                        element.tarde.forEach(function(e_t, i_m) {
                            disabled = (e_t.estado == 'OCUPADO') ? 'disabled' : '';
                            disponible = (e_t.estado == 'OCUPADO') ? 'OCUPADO' :
                                'DISPONIBLE';
                            $("#hora").append('<option value="' + e_t.value + '" ' +
                                disabled +
                                '>' +
                                e_t.hora + ' | ' + element.nom_doctor + ' (' + e_t.estado +
                                ')</option>');
                        });
                    })
                    $("#hora").trigger("chosen:updated")
                }
            });
        }

        function generarHorarios(intervaloInicio, intervaloFin, paso) {
            const horarios = [];
            if (intervaloInicio != '00:00' && intervaloFin != '00:00') {
                const [inicioHora, inicioMinuto] = intervaloInicio.split(':').map(Number);
                const [finHora, finMinuto] = intervaloFin.split(':').map(Number);
                const pasoMinutos = parseInt(paso, 10);

                let horaActual = inicioHora;
                let minutoActual = inicioMinuto;

                while (horaActual < finHora || (horaActual === finHora && minutoActual <= finMinuto)) {
                    horarios.push(`${horaActual.toString().padStart(2, '0')}:${minutoActual.toString().padStart(2, '0')}`);

                    minutoActual += pasoMinutos;
                    if (minutoActual >= 60) {
                        minutoActual -= 60;
                        horaActual += 1;
                    }
                }
            }
            return horarios;
        }
    </script>
@endsection
