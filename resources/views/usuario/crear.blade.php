@extends('layouts.admin')

@section('link')
<link href="{{url('')}}/assets/plugins/DataTables/media/css/dataTables.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Buttons/css/buttons.bootstrap.min.css" rel="stylesheet" />
<link href="{{url('')}}/assets/plugins/DataTables/extensions/Responsive/css/responsive.bootstrap.min.css"
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
                    <form action="{{url('usuario-nuevo-registrar')}}" method="post" accept-charset="utf-8"
                        id="formulario-create" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <h2 class="col-md-8 col-md-offset-2" id="titulo">
                           Nuevo Usuario</h2>
                        <div class="row">
                            <div class="col-md-6 col-md-offset-2 form-group" style="">
                                <input type="submit" value="Guardar" name="guardar" class="btn btn-success">
                                <a href="{{url('usuario-form-buscar')}}" class="btn btn-success">Cancelar</a>
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
                        <div class="row">
                            <div class="col-md-12">
                                <h5>DATOS PERSONALES</h5>
                            </div>
                            <div class="col-md-7">
                                <div  class="col-md-12">
                               
                            
                            
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-12">
                                        <label class="app-label nombre"><span>*</span>  Nombres:</label>
                                        <div class="div-create-nombre">
                                            <input name="nombre" value="{{old('nombre')}}" class="app-form-control form-control  fadeInLeft animated" id="input-nombre" type="text" required>
                                            @if ($errors->has('nombre'))
                                            <div class="app-alert alert alert-danger">{{$errors->first('nombre')}}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-12">
                                        <label class="app-label paterno"><span></span>  Ap.Paterno:</label>
                                        <div class="div-create-paterno">
                                            <input name="paterno" value="{{old('paterno')}}" class="app-form-control form-control  fadeInLeft animated" id="input-paterno" type="text">
                                        </div>
                                        @if ($errors->has('paterno'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('paterno')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-12">
                                        <label class="app-label materno"><span></span>  Ap.Materno:</label>
                                        <div class="div-create-materno">
                                            <input name="materno" value="{{old('materno')}}" class="app-form-control form-control  fadeInLeft animated" id="input-materno" type="text">
                                        </div>
                                        @if ($errors->has('materno'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('materno')}}</div>
                                        @endif
                                    </div>
                                    
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-6">
                                        <label class="app-label telefono"><span>*</span>  Teléfono:</label>
                                        <div class="div-create-telefono">
                                            <input name="telefono" value="{{old('telefono')}}" class="app-form-control form-control  fadeInLeft animated" id="input-telefono" type="number" required>    
                                        </div>
                                        @if ($errors->has('telefono'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('telefono')}}</div>
                                        @endif
                                    </div>
                                    <!-- begin col-2 -->
                                    <div class="form-group col-md-6">
                                        <label class="app-label celular"><span>*</span>  Celular:</label>
                                        <div class="div-create-celular">
                                            <input name="celular" value="{{old('celular')}}" class="app-form-control form-control  fadeInLeft animated" id="input-celular" type="number" required>    
                                        </div>
                                        @if ($errors->has('celular'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('celular')}}</div>
                                        @endif
                                    </div>
                                    
                                     <!-- begin col-2 -->
                                     <div class="form-group col-md-12">
                                        <label class="app-label direccion"><span>*</span>  Dirección:</label>
                                        <div class="div-create-direccion">
                                            <input name="direccion" value="{{old('direccion')}}" class="app-form-control form-control  fadeInLeft animated" id="input-direccion" type="text" required>
                                        </div>
                                        @if ($errors->has('direccion'))
                                        <div class="app-alert alert alert-danger">{{$errors->first('direccion')}}</div>
                                        @endif
                                    </div>
                                    
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <div  class="col-md-12">
                                    <div  class="col-md-8">
                                        <!-- begin col-2 -->
                                        <div class="form-group col-md-12" style="padding:0">
                                            <label class="app-label ci"><span>*</span> CI:</label>
                                            <input name="ci" value="{{old('ci')}}" class="app-form-control form-control  fadeInLeft animated" id="input-ci" type="text" required="">
                                            @if ($errors->has('ci'))
                                            <div class="app-alert alert alert-danger">{{$errors->first('ci')}}</div>
                                            @endif
                                        </div>
                                        <!-- begin col-2 -->
                                        <div class="form-group col-md-12" style="padding:0">
                                            <label class="app-label email"><span></span> Email:</label>
                                            <input name="email" value="{{old('email')}}" class="app-form-control form-control  fadeInLeft animated" id="input-email" type="text" requiredD="">
                                            @if ($errors->has('email'))
                                            <div class="app-alert alert alert-danger">{{$errors->first('email')}}</div>
                                            @endif
                                        </div>
                                        
                                        
                                    </div>
                                    <div class="col-md-4 text-center" style="padding:0">
                                        <img src="{{url('img/user-avatar.png')}}" alt="" width="100%" id="img-foto">
                                        @if ($errors->has('foto'))
                                        <div class="app-alert alert alert-danger">Requerido</div>
                                        @endif
                                        <button class="btn btn-primary btn-xs m-r-5" type="button" id="btn-foto">Subir Foto</button>
                                        <input type="file" name="foto" value="{{old('foto')}}" style="display:none" id="input-foto" accept="image/*">
                                    </div>
                                    
                                    
                                    
                                    
                                    <div  class="col-12">
                                        <div class="form-group col-md-12">
                                            <label class="app-label"><span>*</span> Tipo de Usuario:</label>
                                            <div class="div-create-id_role">
                                                <select name="id_role" id="id_role" class="form-control " placeholder="Seleccionar" required>
                                                    <option value="">Seleccionar</option>
                                                    @if(!empty($roles))
                                                    @foreach($roles as $key => $value)
                                                    <option value="{{$value->id}}" <?php echo ($value->id==old("id_role"))?"selected":""?>>{{$value->name}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('id_role'))
                                            <div class="app-alert alert alert-danger">{{$errors->first('id_role')}}</div>
                                            @endif
                                        </div>                                 
                                    </div>

                                    <div  class="col-12" style="display:none" id="div-especialidad">
                                        <div class="app-form-group form-group col-md-12">
                                            <label class="app-label"><span>*</span> Asignar Especialidad:</label>
                                            <div class="div-create-id_especialidad">
                                                <select name="id_especialidad" id="id_especialidad" class="form-control chosen-select" data-rel="chosen" placeholder="Seleccionar" requiredd>
                                                    <option value="">Seleccionar</option>
                                                    @if(!empty($especialidad))
                                                    @foreach($especialidad as $key => $value)
                                                    <option value="{{$value->id}}" <?php echo ($value->id==old("id_especialidad"))?"selected":""?>>{{$value->especialidad}}</option>
                                                    @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                            @if ($errors->has('id_especialidad'))
                                            <div class="app-alert alert alert-danger">{{$errors->first('id_especialidad')}}</div>
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
</div>
@endsection

@section("script_3")
<script>
    $('document').ready(function () {
        $("#menu-administracion-usuario").addClass("active");
        $("#menu-usuario-nuevo").addClass("active");
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

        $("#id_role").on("change", function(){
            $("#div-especialidad").css("display","none");
            var id = $("#id_role").val();
            if(id==3){
                $("#div-especialidad").css("display","block");
                $("#id_especialidad").trigger("chosen:updated");
                $("#id_especialidad_chosen").css("width","100%");
            }
        })

        
            
        var id = $("#id_role").val();
        if(id==3){
            $("#div-especialidad").css("display","block");
            $("#id_especialidad").trigger("chosen:updated");
            $("#id_especialidad_chosen").css("width","100%");
        }
    });
    
</script>
@endsection

