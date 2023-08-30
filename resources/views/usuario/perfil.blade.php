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
                    
                    <form action="{{url('usuario-modificar-perfil')}}" method="post" accept-charset="utf-8" id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        
                        <div class="row">
                            <div class="col-md-9" style="">
                                <h2>Mi perfil</h2>
                            </div>
                            <div class="form-group" style="">
                                <h2></h2>
                                <input type="submit" value="Actualizar contraseña" name="guardar" class="btn btn-success fadeInLeft animated">
                            </div>
                            <div class="col-md-12">
                                @if (Session::has('mensaje')) 
                                <div class="alert alert-{{Session::get('class-alert')}} fade in m-b-15" style="margin-bottom:0">
                                    {{Session::get('mensaje')}}
                                    <span class="close" data-dismiss="alert">×</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- end row -->
                        <div class="row">
                            
                            <div class="col-md-12">
                                <div  class="col-md-6">
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <?php $email=(!empty(old('email')))?old('email'):(((!empty($usuario->email))?$usuario->email:''))?>
                                        <label class="app-label email"><span></span>  Usuario:</label>
                                        <div class="div-create-email">
                                            <input name="email" value="{{$usuario->name}}" class="app-form-control form-control  fadeInLeft animated" id="input-email" type="text" disabled>
                                        </div>
                                        @if ($errors->has('email'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('email')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label password_old"><span>*</span>  Clave Actual:</label>
                                        <div class="div-create-password_old">
                                            <input name="password_old" value="" class="app-form-control form-control  fadeInLeft animated" id="input-password_old" type="password" autocomplete="off">
                                        </div>
                                        @if ($errors->has('password_old'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('password_old')}}</div>
                                        @endif
                                    </div>

                                    <!-- begin col-2 -->
                                    <div class="app-form-group form-group col-md-12">
                                        <label class="app-label password"><span>*</span>  Clave Nueva:</label>
                                        <div class="div-create-password">
                                            <input name="password" value="" class="app-form-control form-control  fadeInLeft animated" id="input-password" type="password" autocomplete="off">
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
            console.log(212)
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
        //$(".datos-persona input").prop( "disabled", true );
        $(".datos-persona .chosen-select").attr('disabled', true).trigger("chosen:updated")
    });
    
</script>
@endsection