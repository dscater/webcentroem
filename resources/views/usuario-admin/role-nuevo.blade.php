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
                    
                    <form action="{{url('roles-nuevo-registrar')}}" method="post" accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
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
                                <h2>Formulario de Registro de Rol</h2>
                            </div>
                            <div class="form-group" style="">
                                <h2></h2>
                                <input type="submit" value="Registrar" name="guardar" class="btn btn-success fadeInLeft animated">
                            </div>
                        </div>
                        
                        <!-- end row -->
                        <div class="row">
                            <div class="col-md-12">
                                <div  class="col-md-12 app-card style-card">
                                    
                                    
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label name"><span>*</span>  Nombre de Rol:</label>
                                        <div class="div-create-name">
                                            <input name="name" value="{{old('name')}}" class="app-form-control form-control  fadeInLeft animated" id="input-name" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('name'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('name')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-6">
                                        <label class="app-label slug"><span>*</span>  Slug:</label>
                                        <div class="div-create-slug">
                                            <input name="slug" value="{{old('slug')}}" class="app-form-control form-control  fadeInLeft animated" id="input-slug" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('slug'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('slug')}}</div>
                                        @endif
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label description"><span>*</span>  Descripción:</label>
                                        <div class="div-create-description">
                                            <input name="description" value="{{old('description')}}" class="app-form-control form-control  fadeInLeft animated" id="input-description" type="text" requiredd="">
                                        </div>
                                        @if ($errors->has('description'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('description')}}</div>
                                        @endif
                                    </div>
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="col-md-5 control-label">Especial</label>
                                        <div class="col-md-7">
                                            <label class="radio-inline">
                                                <input type="radio" name="special" value="all-access"
                                                <?=(old("special")=="all-access")?"checked":""?>>
                                                Acceso total
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="special" value="no-access"
                                                <?=(old("special")=="no-access")?"checked":""?>>
                                                Denegación de Acceso total
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="special" value=""
                                                <?=(old('special')=="")?"checked":""?>>
                                                Ninguno
                                            </label>
                                        </div>
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
        $("#menu-roles").addClass("active");
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