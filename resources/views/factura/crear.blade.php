@extends('layouts.admin')

@section('link')
    <link href="{{ url('') }}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .concepto {
            position: relative;
        }

        .concepto .eliminar {
            position: absolute;
            top: 5px;
            right: -15px;
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
                                <div class="col-md-12">
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
                                </div>
                                <div class="col-md-4">
                                    <div class="col-md-12" id="contenedor_conceptos">
                                        <!-- begin col-2 -->
                                        <div class="form-group concepto">
                                            <label class="app-label concepto"><span>*</span> Concepto:</label>
                                            <div class="div-create-concepto">
                                                <select name="concepto_id[]" class="form-control" required></select>
                                                @if ($errors->has('concepto_id'))
                                                    <div class="app-alert alert alert-danger">
                                                        {{ $errors->first('concepto_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button type="button" id="btnAgregarConcepto"
                                            class="btn btn-xs btn-primary btn-block"><i class="fa fa-plus"></i> Agregar
                                            Concepto</button>
                                    </div>
                                </div>
                                <div class="col-md-8">
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-6">
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
                                        <div class="form-group col-md-6">
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
                                    <div class="form-group col-md-6">
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
        let html_conceptos = "";
        let html_concepto = `
        <div class="form-group concepto">
            <label class="app-label concepto"><span>*</span> Concepto:</label>
            <div class="div-create-concepto">
                <select name="concepto_id[]" class="form-control" required></select>
            </div>
        </div>`;
        let btn_eliminar =
            `<button type="button" class="eliminar btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>`;
        let id_especialidad_create_factura = $("#id_especialidad_create_factura");
        let contenedor_conceptos = $("#contenedor_conceptos");
        let btnAgregarConcepto = $("#btnAgregarConcepto");
        let array_montos = [];
        let input_monto = $("#input-monto");
        let input_descuento = $("#input-descuento");
        let input_monto_total = $("#input-monto-total");

        let tipo_paciente = $("#tipo_paciente");
        let institucion = $("#institucion");
        $('document').ready(function() {
            // obtener conceptos por especialidad
            getConceptosEspecialidad();
            // agregar concepto
            btnAgregarConcepto.click(agregarConcepto);
            // detectar cambio especialidad
            id_especialidad_create_factura.change(getConceptosEspecialidad);

            // obtener montos
            contenedor_conceptos.on("change", ".concepto select", function() {
                arma_montos();
            });

            // eliminar concepto
            contenedor_conceptos.on("click", ".concepto .eliminar", function() {
                $(this).parents(".concepto").remove();
                arma_montos();
            });

            // calcular montos
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
            if (array_montos.length > 0) {
                let suma_montos = 0;
                let suma_total = 0;
                array_montos.forEach(elem => {
                    console.log(elem);
                    suma_montos += parseFloat(elem);
                })

                input_monto.val(suma_montos);
                input_monto_total.val(suma_montos - input_descuento.val());
            } else {
                input_monto.val("");
                input_monto_total.val("");
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
                        html_conceptos = response.html;
                        llenaConceptos();
                    }
                });
            } else {
                vaciaConceptos();
            }
        }

        function vaciaConceptos() {
            let conceptos = contenedor_conceptos.children(".concepto");
            conceptos.each(function() {
                let select = $(this).find("select");
                select.html(`<option value="">SIN REGISTROS</option>`);
            });
        }

        function llenaConceptos() {
            let conceptos = contenedor_conceptos.children(".concepto");
            conceptos.each(function() {
                let select = $(this).find("select");
                select.html(html_conceptos);
            });
            inciaCalculoTotal();
        }

        function arma_montos() {
            array_montos = [];
            let conceptos = contenedor_conceptos.children(".concepto");
            conceptos.each(function() {
                let elem = $(this);
                let select = elem.find("select");
                getConcepto(select.val());
            });
            inciaCalculoTotal();
        }

        function inciaCalculoTotal() {
            setTimeout(() => {
                calculaMontoTotal();
            }, 500);
        }

        function agregarConcepto() {
            let clone_concepto = $(html_concepto).clone();
            let select = clone_concepto.find('select');
            select.html(html_conceptos);
            contenedor_conceptos.append(clone_concepto);
            let conceptos = contenedor_conceptos.children(".concepto");
            if (conceptos.length > 1) {
                conceptos.each(function(index) {
                    let elem = $(this);
                    if (index > 0) {
                        // boton eliminar
                        elem.append(btn_eliminar);
                    }
                });
            }
            inciaCalculoTotal();
        }

        function getConcepto(id) {
            if (id != '') {
                let url = `{{ route('conceptos.get_concepto') }}`;
                $.ajax({
                    type: "GET",
                    url: url,
                    data: {
                        id: id,
                    },
                    dataType: "json",
                    success: function(response) {
                        array_montos.push(response.concepto.costo);
                    }
                });
            }
        }
    </script>
@endsection
