<?php
$id_user = auth()->user()->id;
$persona = \DB::select("SELECT * from persona where id_user=$id_user")[0];
$nombre = $persona->nombre . ' ' . $persona->paterno . ' ' . $persona->materno . ' ';
if (!empty($persona->foto)) {
    $persona->foto = url('fotoPersona/' . $persona->foto);
} else {
    $persona->foto = url('img/user-avatar.png');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8" />
    <title>MEDICOR</title>
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="{{ url('') }}/css/animate.css" rel="stylesheet" />
    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="../../../../fonts.googleapis.com/cssff98.css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/jquery-ui/themes/base/minified/jquery-ui.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/css/animate.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/css/style.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/css/style-responsive.min.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/css/theme/default.css" rel="stylesheet" id="theme" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="{{ url('') }}/assets/plugins/jquery-jvectormap/jquery-jvectormap.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css"
        rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />
    <link href="{{ url('') }}/assets/plugins/chosen/chosen.min.css" rel="stylesheet">
    <!-- ================== END PAGE LEVEL STYLE ================== -->
    @yield('link')
    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ url('') }}/assets/plugins/pace/pace.min.js"></script>
    <!-- ================== END BASE JS ================== -->
    <style>
        body {
            background: url(<?php echo url(''); ?>/img/fondo.jpeg) top 0 center no-repeat;
            background-attachment: fixed;
            background-size: 100% 100%;
        }

        .style-navbar {
            background: linear-gradient(180deg, #AE81B8 0, #6E237E 70%) !important;

        }
    </style>
</head>

<body>
    <!-- begin #page-loader -->
    <div id="page-loader" class="fade in"><span class="spinner"></span></div>
    <!-- end #page-loader -->

    <!-- begin #page-container -->
    <div id="page-container" class="fade page-sidebar-fixed page-header-fixed">
        <!-- begin #header -->
        <div id="header" class="header navbar navbar-default navbar-fixed-top style-navbar">
            <!-- begin container-fluid -->
            <div class="container-fluid">
                <!-- begin mobile sidebar expand / collapse button -->
                <div class="navbar-header">
                    <a href="javascript::" class="navbar-brand" data-click="sidebar-minify"><span
                            class="navbar-logo"></span> <span style="font-size:15px;color:#fff">MEDICOR</span></a>
                    <button type="button" class="navbar-toggle" data-click="sidebar-toggled">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- end mobile sidebar expand / collapse button -->

                <!-- begin header navigation right -->
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown navbar-user">
                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">

                            <img src="{{ url($persona->foto) }}" alt="" />
                            <span class="hidden-xs text-white">{{ $nombre }}</span> <b
                                class="caret  text-white"></b>
                        </a>
                        <ul class="dropdown-menu animated fadeInLeft">
                            <li class="arrow"></li>
                            <li class="text-center"><a href="{{ url('perfil-usuario') }}"><span
                                        class="fa fa-cog fa-spin"></span> Ajustes de usuario</a></li>
                            <!--li><a href="javascript:;"><span class="badge badge-danger pull-right">2</span> Inbox</a></li-->

                            <li class="divider"></li>
                            <li class="text-center">
                                <a href="{{ url('/logout') }}"
                                    onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();"><span
                                        class="fa fa-power-off"></span>
                                    Cerrar Sessión
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>

                        </ul>
                    </li>
                </ul>
                <!-- end header navigation right -->
            </div>
            <!-- end container-fluid -->
        </div>
        <!-- end #header -->

        <!-- begin #sidebar -->
        <div id="sidebar" class="sidebar">
            <!-- begin sidebar scrollbar -->
            <div data-scrollbar="true" data-height="100%">
                <!-- begin sidebar user -->
                <ul class="nav">
                    <li class="nav-profile">
                        <div class="">
                            <a href="javascript:;">
                                <!--img src="{{ url($persona->foto) }}" alt="" class="img-responsive"/>-->
                                <!--img  src="{{ url('') }}/img/1552151905_New-Sac-Kings-Logo-3.0.jpg" alt="" class="img-responsive"/-->
                            </a>
                        </div>
                        <!--div class="info text-center">
       
       <small style="font-size:15px;color:white" class="text-center">Rol: Administrador</small>
      </div-->
                    </li>
                </ul>
                <!-- end sidebar user -->
                <!-- begin sidebar nav -->
                <ul class="nav">

                    <li class="nav-header" style="color:#fff">Menu</li>

                    <li id="menu-inicio"><a href="{{ url('home') }}"><i class="fa fa-university"></i> Inicio</a>
                    </li>
                    @if (auth()->user()->hasRole('administrador'))
                        <li id="menu-configuracion"><a href="{{ url('configuracion') }}"><i
                                    class="fa fa-cog fa-spin"></i> Configuración</a></li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('menu.catalogos'))
                        <!--li id="menu-parametros" class="has-sub">
      <a href="javascript:;">
       <b class="caret pull-right"></b>
       <i class="fa fa-laptop"></i>
       <span>Catalogos</span>
      </a>
      <ul class="sub-menu">
       <li id="menu-especialidad"><a href="{{ url('/table/especialidad') }}">Especialidades</a></li>
      </ul>
     </li-->
                        <li id="menu-especialidad"><a href="{{ url('/table/especialidad') }}"><i
                                    class="fa fa-book"></i> Especialidades</a></li>
                    @endif


                    @if (auth()->user()->hasRole('administrador'))
                        <li id="menu-administracion-usuario" class="has-sub">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                <i class="fa fa-laptop"></i>
                                <span>Administrar Usuarios</span>
                            </a>
                            <ul class="sub-menu">
                                <li id="menu-usuario-form-buscar"><a
                                        href="{{ url('/usuario-form-buscar') }}">Usuarios</a></li>
                                <li id="menu-usuario-nuevo"><a href="{{ url('/usuario-nuevo') }}">Nuevo Usuario</a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('administrar.asignacion.especialidad'))
                        <li id="menu-administracion-asignacion" class="has-sub">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                <i class="fa fa-laptop"></i>
                                <span>Administrar Asignación de Especialidades</span>
                            </a>
                            <ul class="sub-menu">
                                <li id="menu-asignacion-especialidad-form-buscar"><a
                                        href="{{ url('/asignacion-especialidad-form-buscar') }}">Lista Asignación de
                                        especialidad</a></li>
                                <li id="menu-asignacion-especialidad-nuevo"><a
                                        href="{{ url('/asignacion-especialidad-nuevo') }}">Nueva Asignación de
                                        especialidad</a></li>
                            </ul>
                        </li>
                    @endif

                    {{-- @if (auth()->user()->hasPermissionTo('administrar.historiales.clinicos'))
					<li id="menu-administracion-historial" class="has-sub">
						<a href="javascript:;">
							<b class="caret pull-right"></b>
							<i class="fa fa-laptop"></i>
							<span>Administrar Historiales Clínicos</span>
						</a>
						<ul class="sub-menu">
							<li id="menu-historial-clinico-form-buscar"><a href="{{url('/historial-clinico-form-buscar')}}">Lista Historial Clínico</a></li>
							@if (!auth()->user()->hasRole('secretaria'))
							<li id="menu-historial-clinico-nuevo"><a href="{{url('/historial-clinico-nuevo')}}">Nuevo Historial Clínico</a></li>
							@endif
						</ul>
					</li>
					@endif --}}

                    @if (auth()->user()->hasPermissionTo('administrar.pacientes'))
                        <li id="menu-administracion-paciente" class="has-sub">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                <i class="fa fa-laptop"></i>
                                <span>Administrar Pacientes</span>
                            </a>
                            <ul class="sub-menu">
                                <li id="menu-paciente-form-buscar"><a
                                        href="{{ url('/paciente-form-buscar') }}">Pacientes</a></li>
                                <li id="menu-paciente-nuevo"><a href="{{ url('/paciente-nuevo') }}">Nuevo
                                        Paciente</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('administrador') ||
                            auth()->user()->hasRole('secretaria'))
                        <li id="menu-administracion-factura" class="has-sub">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                <i class="fa fa-laptop"></i>
                                <span>Pagos</span>
                            </a>
                            <ul class="sub-menu">
                                <li id="menu-factura-form-buscar"><a
                                        href="{{ url('/factura-form-buscar') }}">Pagos</a></li>
                                <li id="menu-factura-nuevo"><a href="{{ url('/factura-nuevo') }}">Nuevo Pago</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasPermissionTo('generar.reportes'))
                        <li id="menu-reporte" class="has-sub">
                            <a href="javascript:;">
                                <b class="caret pull-right"></b>
                                <i class="fa fa-laptop"></i>
                                <span>Reportes</span>
                            </a>
                            <ul class="sub-menu">
                                @if (auth()->user()->hasRole('administrador'))
                                    <li id="menu-reporte-usuarios"><a
                                            href="{{ url('/vista-reporte-usuarios') }}">Usuarios</a></li>
                                @endif
                                <li id="menu-reporte-paciente"><a
                                        href="{{ url('/vista-reporte-paciente') }}">Pacientes</a></li>
                                <li id="menu-reporte-cantidad-paciente"><a
                                        href="{{ url('/vista-reporte-cantidad-paciente') }}">Cantidad de Pacientes Por
                                        Especialidad</a></li>
                                <li id="menu-reporte-cita-medica"><a
                                        href="{{ url('/vista-reporte-cita-medica') }}">Cita Médica</a></li>
                                <li id="menu-reporte-factura"><a href="{{ url('/vista-reporte-factura') }}">Pagos</a>
                                </li>
                                <li id="menu-reporte-factura"><a
                                        href="{{ url('/vista-reporte-grafico-pagos') }}">Gráfico de pagos</a></li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->hasRole('paciente'))
                        <li id=""><a href="{{ url('paciente-datos-registro') }}" target="blank">Datos de
                                Registro</a></li>
                        {{-- <li id=""><a href="{{ url('/reporte-historial-clinico') }}"
                                target="blank">Historial Clínico</a></li>
                        <li id=""><a href="{{ url('/reporte-seguimiento-control') }}"
                                target="blank">Seguimiento y Control</a></li> --}}
                    @endif
                    <li id="menu-cita-medico-form-buscar"><a href="{{ url('/cita-medica-form-buscar') }}">Cita
                            Médica</a></li>
                    <li id="menu-cita-medico-nuevo"><a href="{{ url('/cita-medica-nuevo') }}">Nueva Cita Médica</a>


                        @if (auth()->user()->hasRole('administrador'))
                    <li id=""><a href="{{ route('backup.index') }}">Backup</a></li>
                    @endif
                    </li>
                    @if (Auth::user()->roles->first()->name == 'DOCTOR')
                        <li id="menu-cita-medico-nuevo"><a
                                href="{{ route('doctor_horarios.show', Auth::user()->id) }}">Gestionar Horarios</a>
                        </li>
                    @endif
                    <!-- begin sidebar minify button -->
                    <li><a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"><i
                                class="fa fa-angle-double-left"></i></a></li>
                    <!-- end sidebar minify button -->

                </ul>
                <!-- end sidebar nav -->
            </div>
            <!-- end sidebar scrollbar -->
        </div>
        <div class="sidebar-bg"></div>
        <!-- end #sidebar -->

        @yield('content')



        <!-- begin scroll to top btn -->
        <a href="javascript:;" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade"
            data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        <!-- end scroll to top btn -->
    </div>
    <!-- end page container -->
    <audio id="audio-alert" src="{{ url('') }}/audio/alert.mp3" preload="auto"></audio>
    <audio id="audio-fail" src="{{ url('') }}/audio/fail.mp3" preload="auto"></audio>

    <!-- ================== BEGIN BASE JS ================== -->
    <script src="{{ url('') }}/assets/plugins/jquery/jquery-1.9.1.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/jquery/jquery-migrate-1.1.0.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/jquery-ui/ui/minified/jquery-ui.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!--[if lt IE 9]>
  <script src="{{ url('') }}/assets/crossbrowserjs/html5shiv.js"></script>
  <script src="{{ url('') }}/assets/crossbrowserjs/respond.min.js"></script>
  <script src="{{ url('') }}/assets/crossbrowserjs/excanvas.min.js"></script>
 <![endif]-->
    <script src="{{ url('') }}/assets/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
    <!-- ================== END BASE JS ================== -->

    <!-- ================== BEGIN PAGE LEVEL JS ================== -->
    @yield('script')
    @yield('script_1')
    <script src="{{ url('') }}/assets/plugins/gritter/js/jquery.gritter.js"></script>
    <script src="{{ url('') }}/assets/js/ui-modal-notification.demo.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/flot/jquery.flot.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/flot/jquery.flot.time.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/flot/jquery.flot.pie.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/sparkline/jquery.sparkline.js"></script>
    <script src="{{ url('') }}/assets/plugins/jquery-jvectormap/jquery-jvectormap.min.js"></script>
    <script src="{{ url('') }}/assets/plugins/jquery-jvectormap/jquery-jvectormap-world-mill-en.js"></script>
    <script src="{{ url('') }}/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script src="{{ url('') }}/assets/js/dashboard.min.js"></script>
    <script src="{{ url('') }}/assets/js/app.js"></script>
    <script src="{{ url('') }}/assets/plugins/chosen/chosen.jquery.min.js"></script>

    <!-- Highcharts -->
    <script src="{{ asset('assets/plugins/Highcharts/code/highcharts.js') }}"></script>
    <script src="{{ asset('assets/plugins/Highcharts/code/highcharts-3d.src.js') }}"></script>
    <script src="{{ asset('assets/plugins/Highcharts/code/modules/exporting.js') }}"></script>
    <script src="{{ asset('assets/plugins/Highcharts/code/modules/export-data.js') }}"></script>

    <!-- ================== END PAGE LEVEL JS ================== -->

    <script>
        $(document).ready(function() {
            App.init();
            $(".panel").addClass("bounce animated");
            $("input").addClass("fadeInLeft animated");
            $(".panel-title").on("mouseover", function() {
                $(".panel-title").addClass("bounce animated")
            })
            $(".panel-title").on("mouseout", function() {
                $(".panel-title").removeClass("bounce animated")
            })

            //Dashboard.init();
        });
    </script>

    @yield('script_2')
    @yield('script_3')
    <?php if(isset($accion))
	{?>
    @include('admin.script.' . $accion)
    <?php 
	}?>

    <script></script>
    <script type="text/javascript">
        $(".chosen-select").chosen();
        $(document).ready(function() {
            $(".buttons-print span").text("Imprimir");
            $(".buttons-copy span").text("Copiar");
            $(".buttons-print").css("display", "none");
            $(".buttons-copy").css("display", "none");
            $(".buttons-pdf").css("display", "none");
            $(".buttons-excel").css("display", "none");
            $(".buttons-csv").css("display", "none");

        });






        function playAudio(file) {
            if (file === 'alert')
                document.getElementById('audio-alert').play();

            if (file === 'fail')
                document.getElementById('audio-fail').play();
        }
    </script>

</body>

<!-- Mirrored from seantheme.com/color-admin-v2.2/admin/html/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Sat, 06 May 2017 02:15:03 GMT -->

</html>
