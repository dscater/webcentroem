@extends('layouts.admin')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css" rel="stylesheet" />
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

.condicion--list{
    background: #daf1ff;
}

.condicion--text{
    font-size: 20px;
    color: #24485f;
}

.correccion-light{
    font-size: 20px;
    background: #88e8a1;
    color: #031d0c;
}
.correccion-dark{
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
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                    <h4 class="panel-title">Panel</h4>
                </div>
                
                <div class="panel-body">
                    
                    <form action="{{url('reporte-historial-clinico')}}" method="get" target="blank" accept-charset="utf-8" id="formulario-create" >
                        <div class="row">
                            <div class="col-md-9 text-center" style="">
                                <h2 style="margin-bottom:0">VALIDACIÓN</h2>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h5>Mensaje del sistema</h5>
                            </div>
                            <div class="col-md-12">
                                <div class="app-form-group form-group col-md-12">
                                    
                                    @if (!empty($errors))
                                    @foreach($errors as $key => $value)
                                    <div class="app-alert alert alert-danger">{{$value}}</div>
                                    @endforeach
                                    @endif
                                </div>
                                
                            </div>
                            
                            
                        </div>
                        <!-- end row -->
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


@endsection

@section("script_3")
<script>
    
</script>
@endsection

