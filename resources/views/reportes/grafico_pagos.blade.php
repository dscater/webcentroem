@extends('layouts.admin')

@section('link')
    <link href="{{ url('') }}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
        rel="stylesheet" />
    <style>
        .key {
            font-weight: 500;
            font-size: 11px;
            display: block;
            color: gray;
        }

        .value {
            color: #000;
            font-size: 14px;
            font-weight: 400;
        }

        .condicion--list {
            background: #daf1ff;
        }

        .condicion--text {
            font-size: 20px;
            color: #24485f;
        }

        .correccion-light {
            font-size: 20px;
            background: #88e8a1;
            color: #031d0c;
        }

        .correccion-dark {
            font-size: 20px;
            background: #e9ea7e;
            color: #313102;
        }

        .causa-light {
            font-size: 20px;
            background: #98f9b1;
            color: #002f11;
        }

        .causa-dark {
            font-size: 20px;
            background: #f8f998;
            color: #2c2f00;
        }

        #contenedorGrafico {
            z-index: 0 !important;
        }

        .chosen-drop,
        .chosen-drop .chosen-results {
            z-index: 9999 !important;
        }
    </style>
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

                        <form action="{{ url('reporte-factura') }}" method="get" target="_blank" accept-charset="utf-8"
                            id="formulario-create">
                            <div class="row">
                                <div class="col-md-12 text-center" style="">
                                    <h2 style="margin-bottom:0">REPORTE GRÁFICO DE PAGOS</h2>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-md-12" id="contenedorGrafico"></div>
                            </div>
                            <!-- end row -->
                        </form>
                    </div>
                </div>
                <!-- end panel -->
                <div class="panel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h5>FILTRO</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span>*</span> Especialidad:</label>
                                    <div class="div-create-id_especialidad">
                                        <select name="id_especialidad" id="id_especialidad"
                                            class="form-control chosen-select" data-rel="chosen" placeholder="Seleccionar"
                                            required>
                                            @if (
                                                !auth()->user()->hasRole('doctor') &&
                                                    !auth()->user()->hasRole('secretaria'))
                                                <option value="">Seleccionar</option>
                                                <option value="todos">Todos</option>
                                            @endif
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
                                <div class="app-form-group form-group col-md-12">
                                    <label class="app-label"><span>*</span> Gestión:</label>
                                    <div class="div-create-gestion">
                                        <select name="gestion" id="gestion" class="form-control chosen-select"
                                            data-rel="chosen" placeholder="Seleccionar" required>
                                            <option value="">Seleccionar</option>
                                            @if (!empty($array_gestiones))
                                                @foreach ($array_gestiones as $key => $value)
                                                    <option value="{{ $value }}"> <?php echo $value; ?>
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    @if ($errors->has('gestion'))
                                        <div class="app-alert alert alert-danger">El campo es requerido</div>
                                    @endif
                                </div>
                                <div class="app-form-group form-group col-md-12">
                                    <button class="btn btn-success" type="button" id="btnGeneraReporte"><i
                                            class="fa fa-print"></i> GENERAR
                                        REPORTE</button>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end col-10 -->
        </div>

        <!-- Button trigger modal -->
        <input id="input-modal-reporte" type="hidden" class="btn btn-primary btn-lg" data-toggle="modal"
            data-target="#modal-reporte">

        <!-- Modal -->
        <div class="modal fade" id="modal-reporte" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" style="width:100%">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
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


@section('script_1')
@endsection

@section('script_3')
    <script>
        $('document').ready(function() {
            generaGrafico();
            $("#btnGeneraReporte").click(generaGrafico);
        });

        function generaGrafico() {
            $.ajax({
                type: "GET",
                url: "{{ route('reporte.grafico_pagos') }}",
                data: {
                    id_especialidad: $('#id_especialidad').val(),
                    gestion: $('#gestion').val(),
                },
                dataType: "json",
                success: function(response) {
                    Highcharts.chart('contenedorGrafico', {
                        chart: {
                            type: 'column'
                        },
                        title: {
                            text: response.nombre
                        },
                        subtitle: {
                            text: `Gestión ${response.gestion}`
                        },
                        xAxis: {
                            type: 'category',
                            labels: {
                                rotation: -45,
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        },
                        yAxis: {
                            min: 0,
                            title: {
                                text: 'Total'
                            }
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            pointFormat: 'Total: <b>{point.y:.2f}</b>'
                        },
                        series: [{
                            name: 'Population',
                            colorByPoint: true,
                            groupPadding: 0,
                            data: response.data,
                            dataLabels: {
                                enabled: true,
                                rotation: -90,
                                color: '#FFFFFF',
                                align: 'right',
                                format: '{point.y:.2f}', // one decimal
                                y: 10, // 10 pixels down from the top
                                style: {
                                    fontSize: '13px',
                                    fontFamily: 'Verdana, sans-serif'
                                }
                            }
                        }]
                    });

                }
            });
        }
    </script>
@endsection
