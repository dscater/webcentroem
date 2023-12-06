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
                        <form action="{{ url('factura-nuevo-registrar') }}" method="post" accept-charset="utf-8"
                            id="formulario-create" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <h2 class="col-md-8 col-md-offset-2" id="titulo">Nueva Factura</h2>
                            <div class="row">
                                <div class="col-md-6 col-md-offset-2 form-group" style="">
                                    <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                                    <a href="{{ url('factura-form-buscar') }}" class="btn btn-success">Cancelar</a>
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
                                <div class="col-md-12">
                                    @if (auth()->user()->hasRole('administrador'))
                                        <div class="form-group col-md-6">
                                            <label class="app-label"><span>*</span> Especialidad:</label>
                                            <div class="div-create-id_especialidad_create_factura">
                                                <select name="id_especialidad" id="id_especialidad_create_factura"
                                                    class="form-control chosen-select" data-rel="chosen"
                                                    placeholder="Seleccionar" required>
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
                                        </div>
                                    @else
                                        <input type="hidden" id="id_especialidad_create_factura"
                                            value={{ $id_especialidad }}>
                                    @endif
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-6">
                                        <label class="app-label fecha_factura"><span>*</span> Tipo de paciente:</label>
                                        <div class="div-create-tipo_paciente">
                                            <select name="tipo_paciente" id="tipo_paciente" class="form-control">
                                                <option value="">Seleccione...</option>
                                                <option value="PACIENTE PARTICULAR">PACIENTE PARTICULAR</option>
                                                <option value="PACIENTE ASEGURADO">PACIENTE ASEGURADO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-6 institucion">
                                        <label class="app-label fecha_factura"><span>*</span> Institución:</label>
                                        <div class="div-create-tipo_paciente">
                                            <input name="institucion" id="institucion" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">

                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-4">
                                        <label class="app-label fecha_factura"><span>*</span> Fecha de Pago:</label>
                                        <div class="div-create-fecha_factura">
                                            <input name="fecha_factura" value="{{ date('Y-m-d') }}"
                                                class="app-form-control form-control  fadeInLeft animated"
                                                id="input-fecha_factura" type="date" required>
                                            @if ($errors->has('fecha_factura'))
                                                <div class="app-alert alert alert-danger">
                                                    {{ $errors->first('fecha_factura') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    @php
                                        $paciente = null;
                                        if (isset($_GET['nrop']) && $_GET['nrop']) {
                                            $paciente = App\Models\Persona::find($_GET['nrop']);
                                        }
                                    @endphp
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-4">
                                        <label class="app-label paciente_ci"><span>*</span> CI/NIT:</label>
                                        <div class="div-create-paciente_ci">
                                            <input name="paciente_ci"
                                                class="app-form-control form-control  fadeInLeft animated"
                                                id="input-paciente_ci" type="number"
                                                value="{{ $paciente ? $paciente->ci : old('paciente_ci') }}" required>
                                            @if ($errors->has('paciente_ci'))
                                                <div class="app-alert alert alert-danger">
                                                    {{ $errors->first('paciente_ci') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-4">
                                        <label class="app-label paciente_nombre"><span>*</span> A nombre de:</label>
                                        <div class="div-create-paciente_nombre">
                                            <input name="paciente_nombre"
                                                class="app-form-control form-control  fadeInLeft animated"
                                                id="input-paciente_nombre"
                                                value="{{ $paciente ? $paciente->paterno . ' ' . $paciente->materno . ' ' . $paciente->nombre : old('paciente_nombre') }}"
                                                type="text" required>
                                            @if ($errors->has('paciente_nombre'))
                                                <div class="app-alert alert alert-danger">
                                                    {{ $errors->first('paciente_nombre') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-4">
                                        <label class="app-label concepto"><span>*</span> Concepto:</label>
                                        <div class="div-create-concepto">
                                            <select name="concepto_id" id="concepto_id" class="form-control"></select>
                                            @if ($errors->has('concepto_id'))
                                                <div class="app-alert alert alert-danger">
                                                    {{ $errors->first('concepto_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-4">
                                        <label class="app-label monto"><span>*</span> Monto:</label>
                                        <div class="div-create-monto">
                                            <input name="monto" value="{{ old('monto') }}"
                                                class="app-form-control form-control  fadeInLeft animated"
                                                id="input-monto" type="text" required readonly>
                                            @if ($errors->has('monto'))
                                                <div class="app-alert alert alert-danger">{{ $errors->first('monto') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    @if (auth()->user()->hasRole('doctor'))
                                        <div class="form-group col-md-4">
                                            <label class="app-label descuento"><span>*</span> Descuento:</label>
                                            <div class="div-create-descuento">
                                                <input name="descuento"
                                                    value="{{ old('descuento') ? old('descuento') : '0' }}"
                                                    class="app-form-control form-control  fadeInLeft animated"
                                                    id="input-descuento" type="text" required>
                                                @if ($errors->has('descuento'))
                                                    <div class="app-alert alert alert-danger">
                                                        {{ $errors->first('descuento') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @else
                                        <input type="hidden" id="input-descuento" value="0">
                                    @endif
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-4">
                                        <label class="app-label monto_total"><span>*</span> Monto total:</label>
                                        <div class="div-create-monto-total">
                                            <input name="monto_total" value="{{ old('monto_total') }}"
                                                class="app-form-control form-control  fadeInLeft animated"
                                                id="input-monto-total" type="text" required readonly>
                                            @if ($errors->has('monto_total'))
                                                <div class="app-alert alert alert-danger">
                                                    {{ $errors->first('monto_total') }}
                                                </div>
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
    </div>
@endsection

@section('script_3')
    <script>
        let id_especialidad_create_factura = $("#id_especialidad_create_factura");
        let concepto_id = $("#concepto_id");
        let input_monto = $("#input-monto");
        let input_descuento = $("#input-descuento");
        let input_monto_total = $("#input-monto-total");

        let tipo_paciente = $("#tipo_paciente");
        let institucion = $("#institucion");
        $('document').ready(function() {
            getConceptosEspecialidad();

            id_especialidad_create_factura.change(getConceptosEspecialidad);
            concepto_id.change(getConcepto);
            input_monto.on("keyup change", calculaMontoTotal);
            input_descuento.on("keyup change", calculaMontoTotal);

            institucion.parents(".institucion").hide();
            $("#menu-administracion-factura").addClass("active");
            $("#menu-factura-nuevo").addClass("active");
            tipo_paciente.change(function() {
                let tipo = $(this).val();
                if (tipo == "PACIENTE ASEGURADO") {
                    institucion.prop("required", true);
                    institucion.parents(".institucion").show();
                } else {
                    institucion.removeProp("required");
                    institucion.parents(".institucion").hide();
                }
            });
        });

        function calculaMontoTotal() {
            if (input_monto.val().trim() != '' && input_descuento.val().trim() != '' && parseFloat(input_monto.val()) > 0 &&
                parseFloat(input_descuento.val()) >= 0) {
                let total = parseFloat(input_monto.val()) - parseFloat(input_descuento.val());
                input_monto_total.val(total.toFixed(2));
            } else {
                input_monto_total.val(0);
            }
        }

        function getConceptosEspecialidad() {
            if (id_especialidad_create_factura.val().trim() != '') {
                $.ajax({
                    type: "GET",
                    url: "{{ route('conceptos.por_especialidad') }}",
                    data: {
                        id: id_especialidad_create_factura.val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        concepto_id.html(response.html);
                        getConcepto();
                    }
                });
            } else {
                concepto_id.html(`<option value="">SIN REGISTROS</option>`);
            }
        }

        function getConcepto() {
            if (concepto_id.val() != '') {
                let url = `{{ route('conceptos.get_concepto') }}`;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        id: concepto_id.val(),
                    },
                    dataType: "json",
                    success: function(response) {
                        input_monto.val(response.concepto.costo);
                        calculaMontoTotal();
                    }
                });
            } else {
                input_monto.val("");
                calculaMontoTotal();
            }
        }
    </script>
@endsection
