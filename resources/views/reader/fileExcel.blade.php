
@extends('layouts.admin')

@section("content")

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
                    <h2 class="col-md-12" id="titulo">Importar Recintos</h2>
                    <div class="col-md-12">
                    <form action="<?php echo url('')?>/importar-recinto" method="post" accept-charset="utf-8" enctype="multipart/form-data">
                        <?php echo csrf_field();?>
                        <div class="form-group">
                            <label class="col-md-3 control-label">Opciones</label>
                            <div class="col-md-9">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="vaciar_recinto" value="true">
                                        Vaciar Recinto
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="vaciar_mesa" value="true">
                                        Vaciar Mesa
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="vaciar_voto" value="true">
                                        Vaciar Votos
                                    </label>
                                </div>
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="registrar_mesa" value="true">
                                        Registrar Mesas de los Recintos insertados
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div>
                            <input type="file" name="archivo">
                        </div>
                        <div style="margin-top:10px">
                            <input type="submit" value="importar" class="btn btn-success">
                        </div>                        
                    </form>
                    @if (session('status')==200)
                    <div class="alert alert-success">
                        Se registro correctamente
                    </div>
                    @elseif (session('status')==409)
                    <div class="alert alert-danger">
                        @if (!empty(session('lista')))
                        <h5>Se recomienda resolver los errores del archivo excel de abajo hacia arriba segun los errores mostrados.</h5>
                        <ul>
                            @foreach(session('lista') as $key=>$value)
                            <li>{{$value}}</li>
                            @endforeach
                        </ul>
                        @endif
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section("script_3")
<script>
    $("#menu-gestion").addClass("active");
    $("#importar-recinto").addClass("active");
</script>
@endsection

