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
                    
                    <form action="{{url('usuario-nuevo-registrar')}}" method="post" accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                        <div class="row">
                            <div class="col-md-12" style="">
                                @if (Session::has('mensaje'))
                                @foreach(Session::get('mensaje') as $value)
                                <div class="alert alert-{{Session::get('class-alert')}} fade in m-b-15" style="margin-bottom:0">
                                    {{$value}}
                                    <span class="close" data-dismiss="alert">×</span>
                                </div>
                                @endforeach
                                @endif
                            </div> 
                            <div class="col-md-9" style="">
                                <h2>Formulario de Registro de Usuario</h2>
                            </div>
                            <div class="form-group" style="">
                                <h2></h2>
                                <input type="submit" value="Registrar Informacion" name="guardar" class="btn btn-success fadeInLeft animated">
                            </div>
                        </div>
                        <div class="row datos-persona">
                            <div class="col-md-12">
                                <h5>I. DATOS PERSONALES</h5>
                            </div>
                            <div class="col-md-7">
                                <div  class="col-md-12 app-card style-card">
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label nombre1"><span>*</span>  1er nombre:</label>
                                        <div class="div-create-nombre1">
                                            <input name="nombre1" class="app-form-control form-control  fadeInLeft animated" id="input-nombre1" type="text" requiredd="" value="{{$persona->nombre1}}">    
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label nombre2"><span></span>  2do nombre:</label>
                                        <div class="div-create-nombre2">
                                            <input name="nombre2" class="app-form-control form-control  fadeInLeft animated" id="input-nombre2" type="text" value="{{$persona->nombre2}}">    
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label paterno"><span></span>  Paterno:</label>
                                        <div class="div-create-paterno">
                                            <input name="paterno" class="app-form-control form-control  fadeInLeft animated" id="input-paterno" type="text" value="{{$persona->paterno}}">    
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label materno"><span></span>  Materno:</label>
                                        <div class="div-create-materno">
                                            <input name="materno" class="app-form-control form-control  fadeInLeft animated" id="input-materno" type="text" value="{{$persona->materno}}">
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-4">
                                        <label class="app-label estado_civil"><span>*</span>  Estado civil:</label>
                                        <select name="estado_civil" id="select-estado_civil" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Estado civil">
                                            <option value=""></option>
                                            <option <?php echo ($persona->estado_civil=="SOLTERO")?'selected':'';?> value="SOLTERO">SOLTERO</option>
                                            <option <?php echo ($persona->estado_civil=="CASADO")?'selected':'';?> value="CASADO">CASADO</option>
                                            <option <?php echo ($persona->estado_civil=="VIUDO")?'selected':'';?> value="VIUDO">VIUDO</option>
                                            <option <?php echo ($persona->estado_civil=="DIVORCIADO")?'selected':'';?> value="DIVORCIADO">DIVORCIADO</option>
                                            <option <?php echo ($persona->estado_civil=="CONVIVIENTE")?'selected':'';?> value="CONVIVIENTE">CONVIVIENTE</option>
                                        </select>
                                    </div>
                                    <!-- end col-2 -->
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-4">
                                        <label class="app-label telefono"><span></span>  Telefono:</label>
                                        <div class="div-create-telefono">
                                            <input name="telefono" class="app-form-control form-control  fadeInLeft animated" id="input-telefono" type="text" value="{{$persona->telefono}}" requiredd>    
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-4">
                                        <label class="app-label celular"><span></span>  Celular:</label>
                                        <div class="div-create-celular">
                                            <input name="celular" class="app-form-control form-control  fadeInLeft animated" id="input-celular" type="text" value="{{$persona->celular}}" requiredd>    
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label email"><span></span>  Email:</label>
                                        <div class="div-create-email">
                                            <input name="" class="app-form-control form-control  fadeInLeft animated" id="input-email" type="text" value="{{$persona->email}}">
                                        </div>
                                    </div>
                                     <!-- begin col-2 -->
                                     <div class="app-form-group form-group col-md-12">
                                        <label class="app-label telefono"><span>*</span>  Dirección Actual:</label>
                                        <div class="div-create-direccion">
                                            <input name="direccion" class="app-form-control form-control  fadeInLeft animated" id="input-direccion" type="text" value="{{$persona->direccion}}">    
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label apellido_conyugue"><span></span>  Apellido del Conyugue:</label>
                                        <div class="div-create-apellido_conyugue">
                                            <input name="apellido_conyugue" class="app-form-control form-control  fadeInLeft animated" id="input-apellido_conyugue" type="text" value="{{$persona->apellido_conyugue}}">
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label nombre_conyugue">Nombre conyugue:</label>
                                        <div class="div-create-nombre_conyugue">
                                            <input name="nombre_conyugue" class="app-form-control form-control  fadeInLeft animated" id="input-nombre_conyugue" type="text" value="{{$persona->nombre_conyugue}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <div  class="col-md-12 app-card style-card">
                                    <div  class="col-md-8">
                                        <!-- begin col-2 -->
                                        <div class="app-form-group form-group col-md-12" style="padding:0">
                                            <label class="app-label documento"><span>*</span>  Documento:</label>
                                            <div>
                                                <select name="id_tipo_doc_iden" id="select-tipo_doc_iden" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Documento de Identificación" requiredd>
                                                    <option value=""></option>
                                                    @foreach($tipo_doc_iden as $key => $value)
                                                    <option <?= ($value->id==$persona->id_tipo_doc_iden)?"selected":""?> value="{{$value->id}}">{{$value->tipo}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <!-- begin col-2 -->
                                        <div class="app-form-group form-group col-md-7" style="padding:0">
                                            <label class="app-label numero_documento"><span>*</span>  Nro doc.:</label>
                                            <input name="numero_documento" class="app-form-control form-control  fadeInLeft animated" id="input-numero_documento" type="text" requiredd="" value="{{$persona->numero_documento}}">
                                        </div>
                                        <!-- begin col-2 -->
                                        <div class="app-form-group form-group col-md-5" style="padding:0">
                                            <label class="app-label complemento"><span></span>  Complem.:</label>
                                            <div class="div-create-complemento">
                                                <input name="complemento" class="app-form-control form-control  fadeInLeft animated" id="input-complemento" type="text" value="{{$persona->complemento}}">    
                                            </div>
                                        </div>
                                        <!-- begin col-2 -->
                                        <div class="app-form-group form-group col-md-12" style="padding:0">
                                            <label class="app-label expedido"><span>*</span>  Expedido:</label>
                                            <div>
                                                <select name="id_departamento" id="select-tipo_doc_iden" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Documento de Identificación" required>
                                                    <option value=""></option>
                                                    @foreach($departamento as $key => $value)
                                                    <option <?= ($value->id==$persona->id_departamento)?"selected":""?> value="{{$value->id}}">{{$value->abrev1}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 text-center" style="padding:0">
                                        <img src="{{$persona->foto}}" alt="" width="100%" id="img-foto">
                                        
                                    </div>
                                    
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label col-md-12">Fecha nacimiento:</label>
                                        <div class="col-md-4" style="padding:0">
                                        <select name="dia_nac" id="dia" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Día">
                                            <option value=""></option>
                                            @for($i=1; $i<=31;$i++)
                                            <option <?= ($i==((int) date("d",strtotime($persona->fecha_nacimiento))))?"selected":""?> value="{{$i}}">{{$i}}</option>
                                            @endfor
                                        </select>
                                        </div>
                                        <div class="col-md-4"  style="padding:0">
                                            <select name="mes_nac" id="mes" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="mes">
                                                <option value=""></option>
                                                @foreach($mes as $key => $value)
                                                <option <?= ($value->id==((int) date("m",strtotime($persona->fecha_nacimiento))))?"selected":""?> value="{{$value->id}}">{{$value->mes}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-4"  style="padding:0">
                                            <select name="anio_nac" id="anio" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Año">
                                                <option value=""></option>
                                                @for($i=date("Y")-15; $i>=date("Y")-80;$i--)
                                                <option <?= ($i==date("Y",strtotime($persona->fecha_nacimiento)))?"selected":""?> value="{{$i}}">{{$i}}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label nacionalidad"><span>*</span>  Nacionalidad:</label>
                                        <div>
                                            <select name="id_nacion_nac" id="select-nacion_nac" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Nacionalidad" required>
                                                <option value=""></option>
                                                @foreach($catalogo_nacion as $key => $value)
                                                <option <?= ($value->id==$persona->id_nacion_nac)?"selected":""?> value="{{$value->id}}">{{$value->nacionalidad}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label"><span>*</span> Departamento donde nacio:</label>
                                        <div>
                                            <select name="id_departamento_nac" id="select-id_departamento" class="app-form-control form-control chosen-select" data-rel="chosen" data-parsley-group="" data-placeholder="Departamento" required>
                                                <option value=""></option>
                                                @foreach($departamento as $key => $value)
                                                <option <?= ($value->id==$persona->id_departamento_nac)?"selected":""?> value="{{$value->id}}">{{$value->departamento}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="col-md-3 control-label">Genero</label>
                                        <div class="col-md-9">
                                            <label class="radio-inline">
                                                <input type="radio" 
                                                <?=($persona->genero=="MASCULINO")?"checked":""?>
                                                name="genero" value="MASCULINO">
                                                MASCULINO
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" 
                                                <?=($persona->genero=="FEMENINO")?"checked":""?>
                                                name="genero" value="FEMENINO">
                                                FEMENINO
                                            </label>
                                        </div>
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="col-md-5 control-label">Servicio Militar</label>
                                        <div class="col-md-7">
                                            <label class="radio-inline">
                                                <input type="radio" name="libreta_militar" value="1"
                                                <?=($persona->libreta_militar==1)?"checked":""?>>
                                                SI
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="libreta_militar" value="0"
                                                <?=($persona->libreta_militar==0)?"checked":""?>>
                                                NO
                                            </label>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- end col-5 -->
                            
                            
                        </div>
                        <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <h5>II. DATOS DEL USUARIO</h5>
                            </div>
                            <div class="col-md-12">
                                <div  class="col-md-12 app-card style-card">
                                    <input name="id_persona" type="hidden" value="{{$persona->id}}">
                                    
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label email"><span>*</span>  Correo electronico:</label>
                                        <div class="div-create-email">
                                            <input name="email" value="{{old('email')}}" class="app-form-control form-control  fadeInLeft animated" id="input-email" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('email'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('email')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label password"><span>*</span>  Clave:</label>
                                        <div class="div-create-password">
                                            <input name="password" value="{{old('password')}}" class="app-form-control form-control  fadeInLeft animated" id="input-password" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('password'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('password')}}</div>
                                        @endif
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
        $(".datos-persona .form-control").prop( "disabled", true );
        $(".datos-persona input").prop( "disabled", true );
        $(".datos-persona .chosen-select").attr('disabled', true).trigger("chosen:updated")
    });
    
</script>
@endsection