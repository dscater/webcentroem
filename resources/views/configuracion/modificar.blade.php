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
                    
                    <form action="{{url('configuracion-registrar-modificacion')}}" method="post" accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                        <div class="row">
                            <div class="col-md-9" style="">
                                <h2>Formulario Modificar Configuración</h2>
                            </div>
                            <div class="form-group" style="">
                                <h2></h2>
                                <input type="submit" value="Registrar Informacion" name="guardar" class="btn btn-success fadeInLeft animated">
                            </div>
                        </div>
                        
                        <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Configuración</h5>
                            </div>
                            <div class="col-md-12">
                                <div  class="col-md-12 ">
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span>  NOMBRE DE RAZÓN SOCIAL:</label>
                                        <div class="div-create-razon_social">
                                            <input name="razon_social" value="{{(!empty(old('razon_social')))?old('razon_social'):$configuracion->razon_social}}" class="app-form-control form-control  fadeInLeft animated" id="input-razon_social" type="text" required>
                                        </div>
                                        @if ($errors->has('razon_social'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('razon_social')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span></span>  ALIAS:</label>
                                        <div class="div-create-alias">
                                            <input name="alias" value="{{(!empty(old('alias')))?old('alias'):$configuracion->alias}}" class="app-form-control form-control  fadeInLeft animated" id="input-alias" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('alias'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('alias')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span>  CIUDAD:</label>
                                        <div class="div-create-ciudad">
                                            <input name="ciudad" value="{{(!empty(old('ciudad')))?old('ciudad'):$configuracion->ciudad}}" class="app-form-control form-control  fadeInLeft animated" id="input-ciudad" type="text" required>
                                        </div>
                                        @if ($errors->has('ciudad'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('ciudad')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span>  DIRECCIÓN:</label>
                                        <div class="div-create-direccion">
                                            <input name="direccion" value="{{(!empty(old('direccion')))?old('direccion'):$configuracion->direccion}}" class="app-form-control form-control  fadeInLeft animated" id="input-direccion" type="text" required>
                                        </div>
                                        @if ($errors->has('direccion'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('direccion')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-4">
                                        <label class="app-label"><span></span>  NIT:</label>
                                        <div class="div-create-nit">
                                            <input name="nit" value="{{(!empty(old('nit')))?old('nit'):$configuracion->nit}}" class="app-form-control form-control  fadeInLeft animated" id="input-nit" type="number" requiredd="">
                                        </div>
                                        @if ($errors->has('nit'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('nit')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-4">
                                        <label class="app-label"><span></span>  NÚMERO DE AUTORIZACIÓN:</label>
                                        <div class="div-create-numero_autorizacion">
                                            <input name="numero_autorizacion" value="{{(!empty(old('numero_autorizacion')))?old('numero_autorizacion'):$configuracion->numero_autorizacion}}" class="app-form-control form-control  fadeInLeft animated" id="input-numero_autorizacion" type="number" requiredd="">
                                        </div>
                                        @if ($errors->has('numero_autorizacion'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('numero_autorizacion')}}</div>
                                        @endif
                                    </div>

                                     <!-- begin col-2 -->
                                     <div class="app-form-group form-group col-md-4">
                                        <label class="app-label"><span></span>  Fecha límite emisión:</label>
                                        <div class="div-create-fecha_limite_emision">
                                            <input name="fecha_limite_emision" value="{{(!empty(old('fecha_limite_emision')))?old('fecha_limite_emision'):$configuracion->fecha_limite_emision}}" class="app-form-control form-control  fadeInLeft animated" id="input-fecha_limite_emision" type="date" requiredd="">
                                        </div>
                                        @if ($errors->has('fecha_limite_emision'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('fecha_limite_emision')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label"><span>*</span>  TELÉFONO:</label>
                                        <div class="div-create-telefono">
                                            <input name="telefono" value="{{(!empty(old('telefono')))?old('telefono'):$configuracion->telefono}}" class="app-form-control form-control  fadeInLeft animated" id="input-telefono" type="number" required>
                                        </div>
                                        @if ($errors->has('telefono'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('telefono')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label"><span>*</span>  CELULAR:</label>
                                        <div class="div-create-celular">
                                            <input name="celular" value="{{(!empty(old('celular')))?old('celular'):$configuracion->celular}}" class="app-form-control form-control  fadeInLeft animated" id="input-celular" type="number" required>
                                        </div>
                                        @if ($errors->has('celular'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('celular')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label"><span></span>  CASILLA:</label>
                                        <div class="div-create-casilla">
                                            <input name="casilla" value="{{(!empty(old('casilla')))?old('casilla'):$configuracion->casilla}}" class="app-form-control form-control  fadeInLeft animated" id="input-casilla" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('casilla'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('casilla')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label"><span></span>  CORREO ELECTRÓNICO:</label>
                                        <div class="div-create-email">
                                            <input name="email" value="{{(!empty(old('email')))?old('email'):$configuracion->email}}" class="app-form-control form-control  fadeInLeft animated" id="input-email" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('email'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('email')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span>  ACTIVIDAD ECONÓMICA:</label>
                                        <div class="div-create-actividad_economica">
                                            <input name="actividad_economica" value="{{(!empty(old('actividad_economica')))?old('actividad_economica'):$configuracion->actividad_economica}}" class="app-form-control form-control  fadeInLeft animated" id="input-actividad_economica" type="text" required>
                                        </div>
                                        @if ($errors->has('actividad_economica'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('actividad_economica')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span>  LEYENDA DE LA FACTURA:</label>
                                        <div class="div-create-leyenda_factura">
                                            <input name="leyenda_factura" value="{{(!empty(old('leyenda_factura')))?old('leyenda_factura'):$configuracion->leyenda_factura}}" class="app-form-control form-control  fadeInLeft animated" id="input-leyenda_factura" type="text" required>
                                        </div>
                                        @if ($errors->has('leyenda_factura'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('leyenda_factura')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label"><span></span>  WEB:</label>
                                        <div class="div-create-web">
                                            <input name="web" value="{{(!empty(old('web')))?old('web'):$configuracion->web}}" class="app-form-control form-control  fadeInLeft animated" id="input-web" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('web'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('web')}}</div>
                                        @endif
                                    </div>
                                    
                                    <div class="col-md-6 text-center" style="padding:30px">
                                        <img src="{{$configuracion->logo}}" alt="" width="100%" id="img-logo">
                                        <button class="btn btn-primary btn-xs m-r-5" type="button" id="btn-logo">Subir Logo</button>
                                        <input type="file" name="logo" value="{{old('logo')}}" style="display:none" id="input-logo" accept="image/*">
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </form>
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
        $("#menu-configuracion").addClass("active");
        $("#btn-logo").click(function () {
            $("#input-logo").trigger("click");    
        });
        $("#input-logo").change(function () {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#img-logo').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
        
    });
    
</script>
@endsection