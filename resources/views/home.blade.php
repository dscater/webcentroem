@extends('layouts.admin')

@section('content')
<div class="content">
    
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Inicio</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif

                        Bienvenido al Sistema
                        <div class="row">
                            
                            @if(auth()->user()->hasRole('administrador'))
							<div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('usuario-form-buscar')}}">
                                                <i class="fa fa-users" style="font-size:80px"></i>
                                                <h5>Usuarios</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif
							
                            @if(auth()->user()->hasPermissionTo('administrar.asignacion.especialidad'))
							<div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('asignacion-especialidad-form-buscar')}}">
                                                <i class="fa fa-book" style="font-size:80px"></i>
                                                <h5>Asignación de Especialidad</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							@endif
							
                            @if(auth()->user()->hasPermissionTo('administrar.pacientes'))
                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('paciente-form-buscar')}}">
                                                <i class="fa fa-product-hunt" style="font-size:80px"></i>
                                                <h5>Pacientes</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							@endif
							
                            {{-- @if(auth()->user()->hasPermissionTo('administrar.seguimiento.control'))
							<div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('seguimiento-form-buscar')}}">
                                                <i class="fa fa-file-text" style="font-size:80px"></i>
                                                <h5>Seguimiento</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
							@endif --}}
							
                            {{-- @if(auth()->user()->hasPermissionTo('administrar.historiales.clinicos'))
                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('historial-clinico-form-buscar')}}">
                                                <i class="fa fa-address-book" style="font-size:80px"></i>
                                                <h5>Historial Clínico</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif --}}

                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('cita-medica-form-buscar')}}">
                                                <i class="fa fa-address-book" style="font-size:80px"></i>
                                                <h5>Cita Médica</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            @if(auth()->user()->hasPermissionTo('generar.reportes'))
                            
                            @if(auth()->user()->hasRole('administrador'))
                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('vista-reporte-usuarios')}}">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Reporte de Usuarios</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif


                            {{-- <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('vista-reporte-historial-clinico')}}">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Reporte Historial Clínico</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('vista-reporte-seguimiento-control')}}">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Reporte Seguimiento y Control</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('vista-reporte-paciente')}}">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Reporte Pacientes</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('vista-reporte-cantidad-paciente')}}">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Reporte Cantidad de Pacientes por Especialidad</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                            @endif

                            @if(auth()->user()->hasRole('paciente'))
                            <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('paciente-datos-registro')}}"  target="blank">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Datos de Registro</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>

                            {{-- <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('reporte-historial-clinico')}}" target="blank">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Historial Clínico</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> --}}

                            {{-- <div class="col-md-4 col-12">
                                <div class="panel" style="border: 1px solid #ababab">
                                    <div class="panel-body">
                                        <div class="col-md-12 col-12 text-center">
                                            <a href="{{url('reporte-seguimiento-control')}}" target="blank">
                                                <i class="fa fa-print" style="font-size:80px"></i>
                                                <h5>Seguimiento y Control</h5>
                                            </a>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div> --}}
                            @endif
                            
                            
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>
@endsection

@section("script_3")
<script>
    $("#menu-inicio").addClass("active");
    
</script>
@endsection

