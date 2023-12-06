<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/generate-cod', 'AngularController@index');

/*Route::get('/', function () {
    return redirect('/login');
    //return view('welcome');
});*/

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/perfil-usuario', 'UsuarioController@miPerfil');
Route::post('/usuario-modificar-perfil', 'UsuarioController@modificarMiPerfil');

/*Table*/
Route::get("table/{nombre_tabla}", "TableController@index");
Route::get("table/create/{nombre_tabla}", "TableController@create");
Route::post("table/{nombre_tabla}", "TableController@store");
Route::get("table/{nombre_tabla}/{id_tabla}", "TableController@show");
Route::get("table/{nombre_tabla}/{id_tabla}/edit", "TableController@edit");
Route::put("table/{nombre_tabla}/{id_tabla}", "TableController@update");
Route::get("table/{nombre_tabla}/{id_tabla}/delete", "TableController@delete");
Route::delete("table/{nombre_tabla}/{id_tabla}", "TableController@destroy");

Route::get("configuracion", "ConfiguracionController@modificar")
    ->middleware('has.role:administrador');
Route::post("configuracion-registrar-modificacion", "ConfiguracionController@registrarModificacion")
    ->middleware('has.role:administrador');

Route::get("persona-nuevo", "PersonaController@nuevo")
    ->middleware('has.permission:menu.gestion.datos.personales.form.reg.persona');

Route::post("persona-nuevo-registrar", "PersonaController@registrarNuevo");
Route::get("persona-modificar/{id}", "PersonaController@modificar");
Route::post("persona-modificar-registrar/{id}", "PersonaController@registrarModificacion");

Route::get("admin-usuario-nuevo/{id_persona}", "UsuarioAdminController@nuevo");
Route::post("admin-usuario-nuevo-registrar", "UsuarioAdminController@registrarNuevo");
Route::get("admin-usuario-modificar/{id}", "UsuarioAdminController@modificar");
Route::post("admin-usuario-modificar-registrar/{id}", "UsuarioAdminController@registrarModificacion");
Route::get("admin-usuario-asignar-roles/{id}", "UsuarioAdminController@roles");
Route::post("admin-usuario-asignar-roles-registrar/{id}", "UsuarioAdminController@asignarRoles");

Route::get("usuario-nuevo", "UsuarioController@create");
Route::post("usuario-nuevo-registrar", "UsuarioController@store");
Route::get("usuario-modificar/{id}", "UsuarioController@edit");
Route::post("usuario-modificar-registrar/{id}", "UsuarioController@update");
Route::get("usuario-form-buscar", "UsuarioController@index");
Route::post("usuario-buscar", "UsuarioController@buscar");
Route::get("usuario-ver/{id}", "UsuarioController@show");
Route::get("usuario-eliminar/{id}", "UsuarioController@delete");

Route::get("roles", "RoleController@index")
    ->middleware('has.permission:menu.roles');
Route::get("roles-nuevo", "RoleController@nuevo");
Route::post("roles-nuevo-registrar", "RoleController@registrarNuevo");
Route::get("roles-modificar/{id}", "RoleController@modificar");
Route::post("roles-modificar-registrar/{id}", "RoleController@registrarModificacion");
Route::post("roles-eliminar/{id}", "RoleController@destroy");
Route::get("roles-asignar-permisos/{id}", "RoleController@permisos");
Route::post("roles-asignar-permisos-registrar/{id}", "RoleController@asignarPermisos");

Route::get("permisos", "PermisoController@index")
    ->middleware('has.permission:menu.permisos');

Route::get("permisos-nuevo", "PermisoController@nuevo")
    ->middleware('has.permission:menu.gestionss.datos.personales.form.reg.persona');

Route::post("permisos-nuevo-registrar", "PermisoController@registrarNuevo");
Route::get("permisos-modificar/{id}", "PermisoController@modificar");
Route::post("permisos-modificar-registrar/{id}", "PermisoController@registrarModificacion");

Route::get("persona-form-buscar", "PersonaController@formularioBuscar")
    ->middleware('has.permission:menu.gestion.datos.personales.form.buscar.persona');

Route::post("persona-buscar", "PersonaController@buscar");


Route::get("admin-usuario-form-buscar", "UsuarioAdminController@formularioBuscar")
    ->middleware('has.permission:menu.form.buscar.usuario');

Route::post("admin-usuario-buscar-por-carnet", "UsuarioAdminController@buscarByCarnet");

// Route::get("persona-reporte", "PersonaReporteController@reporteListado");
// Route::get("persona-reporte/{id_persona}", "PersonaReporteController@reporte");

Route::get("roles-reporte/{id_rol}", "ReportePermisosPorRolController@reporte");
Route::get("usuario-reporte/{id_usuario}", "ReporteRolesYPermisosPorUsuarioController@reporte");

/* Nuevas rutas */
Route::get("paciente-nuevo", "PacienteController@create")
    ->middleware('has.permission:administrar.pacientes');
Route::post("paciente-nuevo-registrar", "PacienteController@store")
    ->middleware('has.permission:administrar.pacientes');
Route::get("paciente-modificar/{id}", "PacienteController@edit")
    ->middleware('has.permission:administrar.pacientes');
Route::post("paciente-modificar-registrar/{id}", "PacienteController@update")
    ->middleware('has.permission:administrar.pacientes');
Route::get("paciente-form-buscar", "PacienteController@index")
    ->middleware('has.permission:administrar.pacientes');
Route::post("paciente-buscar", "PacienteController@buscar")
    ->middleware('has.permission:administrar.pacientes');
Route::get("paciente-ver/{id}", "PacienteController@show")
    ->middleware('has.permission:administrar.pacientes');
Route::get("paciente-eliminar/{id}", "PacienteController@delete")
    ->middleware('has.permission:administrar.pacientes');

Route::get("asignacion-especialidad-nuevo", "AsignacionEspecialidadController@create")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::post("asignacion-especialidad-nuevo-registrar", "AsignacionEspecialidadController@store")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::get("asignacion-especialidad-modificar/{id}", "AsignacionEspecialidadController@edit")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::post("asignacion-especialidad-modificar-registrar/{id}", "AsignacionEspecialidadController@update")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::get("asignacion-especialidad-form-buscar", "AsignacionEspecialidadController@index")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::post("asignacion-especialidad-buscar", "AsignacionEspecialidadController@buscar")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::get("asignacion-especialidad-ver/{id}", "AsignacionEspecialidadController@show")
    ->middleware('has.permission:administrar.asignacion.especialidad');
Route::get("asignacion-especialidad-eliminar/{id}", "AsignacionEspecialidadController@delete")
    ->middleware('has.permission:administrar.asignacion.especialidad');

Route::get("historial-clinico-nuevo", "HistorialClinicoController@create")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::post("historial-clinico-nuevo-registrar", "HistorialClinicoController@store")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::get("historial-clinico-modificar/{id}", "HistorialClinicoController@edit")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::post("historial-clinico-modificar-registrar/{id}", "HistorialClinicoController@update")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::get("historial-clinico-form-buscar", "HistorialClinicoController@index")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::post("historial-clinico-buscar", "HistorialClinicoController@buscar")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::get("historial-clinico-ver/{id}", "HistorialClinicoController@show")
    ->middleware('has.permission:administrar.historiales.clinicos');
Route::get("historial-clinico-eliminar/{id}", "HistorialClinicoController@delete")
    ->middleware('has.permission:administrar.historiales.clinicos');

Route::get("seguimiento-nuevo", "SeguimientoController@create")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::post("seguimiento-nuevo-registrar", "SeguimientoController@store")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::get("seguimiento-modificar/{id}", "SeguimientoController@edit")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::post("seguimiento-modificar-registrar/{id}", "SeguimientoController@update")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::get("seguimiento-form-buscar", "SeguimientoController@index")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::post("seguimiento-buscar", "SeguimientoController@buscar")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::get("seguimiento-ver/{id}", "SeguimientoController@show")
    ->middleware('has.permission:administrar.seguimiento.control');
Route::get("seguimiento-eliminar/{id}", "SeguimientoController@delete")
    ->middleware('has.permission:administrar.seguimiento.control');

Route::get("cita-medica-nuevo", "CitaMedicaController@create");
Route::post("cita-medica-nuevo-registrar", "CitaMedicaController@store");
Route::get("cita-medica-modificar/{id}", "CitaMedicaController@edit");
Route::post("cita-medica-modificar-registrar/{id}", "CitaMedicaController@update");
Route::get("cita-medica-form-buscar", "CitaMedicaController@index");
Route::post("cita-medica-buscar", "CitaMedicaController@buscar");
Route::get("cita-medica-ver/{id}", "CitaMedicaController@show");
Route::get("cita-medica-eliminar/{id}", "CitaMedicaController@delete");
Route::get("cita-medica-get-hora-por-fecha/{fecha}/{id_especialidad}", "CitaMedicaController@getHorasByFecha");

Route::get("cita-medica-atender/{id}", "CitaMedicaController@atender");
Route::get("cita-medica-cancelar/{id}", "CitaMedicaController@cancelar");
Route::get("/cita-medica-buscar-por-fecha/{fecha}", "CitaMedicaController@buscarPorFecha");

Route::get("cita-medica-recordatorio", "CitaMedicaController@enviarRecordatorio");

Route::get("test-hora", function () {
    $fecha_actual = date('Y-m-d H:i:s');
    $fecha_24horas = date("Y-m-d H:i:s", strtotime('+24 hour', strtotime($fecha_actual)));
    echo $fecha_actual . " ---------" . substr($fecha_24horas, 0, 13);
});


Route::get("factura-nuevo", "FacturaController@create");
Route::post("factura-nuevo-registrar", "FacturaController@store");
Route::get("factura-modificar/{id}", "FacturaController@edit");
Route::post("factura-modificar-registrar/{id}", "FacturaController@update");
Route::get("factura-form-buscar", "FacturaController@index");
Route::post("factura-buscar", "FacturaController@buscar");
Route::get("factura-ver/{id}", "FacturaController@show");
Route::get("factura-eliminar/{id}", "FacturaController@delete");
Route::get("/factura-buscar-por-fecha/{fecha}", "FacturaController@buscarPorFecha");
Route::get("factura-reporte/{id}", "FacturaController@reporteFactura");



Route::get("vista-reporte-usuarios", "ReporteController@usuarios")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-usuarios", "ReporteController@reporteUsuarios")
    ->middleware('has.permission:generar.reportes');

Route::get("vista-reporte-historial-clinico", "ReporteController@historialClinico")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-historial-clinico", "ReporteController@reporteHistorialClinico");

Route::get("vista-reporte-seguimiento-control", "ReporteController@seguimientoControl")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-seguimiento-control", "ReporteController@reporteSeguimientoControl");

Route::get("vista-reporte-paciente", "ReporteController@paciente")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-paciente", "ReporteController@reportePaciente")
    ->middleware('has.permission:generar.reportes');

Route::get("vista-reporte-cantidad-paciente", "ReporteController@cantidadPaciente")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-cantidad-paciente", "ReporteController@reporteCantidadPaciente")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-html-cantidad-paciente", "ReporteController@reporteHtmlCantidadPaciente")
    ->middleware('has.permission:generar.reportes');

Route::get("vista-reporte-cita-medica", "ReporteController@citaMedica")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-cita-medica", "ReporteController@reporteCitaMedica")
    ->middleware('has.permission:generar.reportes');

Route::get("vista-reporte-factura", "ReporteController@factura")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-factura", "ReporteController@reporteFactura")
    ->middleware('has.permission:generar.reportes');

Route::get("vista-reporte-grafico-pagos", "ReporteController@graficoPagos")
    ->middleware('has.permission:generar.reportes');
Route::get("reporte-grafico-pagos", "ReporteController@infoGraficoPagos")
    ->middleware('has.permission:generar.reportes')->name("reporte.grafico_pagos");

Route::get("paciente-reporte/{id}", "PacienteController@reportePaciente");
Route::get("paciente-datos-registro", "PacienteController@reportePacienteDatosRegistro");

Route::get("historial-clinico-reporte/{id}", "HistorialClinicoController@reporte");
Route::get("seguimiento-reporte/{id}", "SeguimientoController@reporte");
Route::get("seguimiento-reporte-receta/{id}", "SeguimientoController@reporteReceta");

Route::get("historial-get-paciente-by-id-especialidad/{id}", "PacienteController@historialGetPacienteByIdEspecialidad");
Route::get("seguimiento-get-paciente-by-id-especialidad/{id}", "PacienteController@SeguimientoGetPacienteByIdEspecialidad");

Route::get("test-exp-numeros", function () {
    $string = '9215936 LP';
    $int = (int) filter_var($string, FILTER_SANITIZE_NUMBER_INT);
    echo ("The extracted numbers are: $int \n");
});

// CONCEPTOS
Route::get("/conceptos/get_concepto", "ConceptoController@get_concepto")->name("conceptos.get_concepto");
Route::get("/conceptos/por_especialidad", "ConceptoController@por_especialidad")->name("conceptos.por_especialidad");
Route::resource("conceptos", "ConceptoController");

// CALENDARIO ATENCIONS
Route::get("/calendario_atencions/{usuario}", "CalendarioAtencionController@show")->name("calendario_atencions.show");
Route::post("/calendario_atencions/{usuario}", "CalendarioAtencionController@store")->name("calendario_atencions.store");
Route::delete("/calendario_atencions/{calendario_atencion}", "CalendarioAtencionController@destroy")->name("calendario_atencions.destroy");

// BOT TELEGRAM
Route::post("/bot_telegram", "BotTelegramController@index");
Route::post("/prueba", "BotTelegramController@prueba");
Route::get("/bot_telegram", "BotTelegramController@prueba");

// backup
Route::get("/backup", "BackupController@index")->name("backup.index");
Route::get("/backup/descargar", "BackupController@descargar")->name("backup.descargar");

// fin backup

Route::get("/", "WebController@index");
Route::get("/nosotros", "WebController@nosotros");
Route::get("/quienes-somos", "WebController@quienesSomos");
Route::get("/servicios", "WebController@servicios");
Route::get("/registrarme", "WebController@registrarme");
Route::post("/registrarme-guardar", "WebController@registrarmeGuardar");


Route::get("doctor_horarios/show/{usuario}", "DoctorHorarioController@show")->name("doctor_horarios.show");
Route::post("doctor_horarios/update/{usuario}", "DoctorHorarioController@update")->name("doctor_horarios.update");
Route::resource("doctor_horarios", "DoctorHorarioController", [
    "names" => [
        "index" => "doctor_horarios.index",
        "create" => "doctor_horarios.create",
        "store" => "doctor_horarios.store",
        "edit" => "doctor_horarios.edit",
        "destroy" => "doctor_horarios.destroy",
    ]
])->except(["show", "update"]);

Route::get('work-schedule', function () {
    set_time_limit(0);
    Artisan::call('schedule:work');
});

Route::get('run-schedule', function () {
    Artisan::call('schedule:run');
    return '<h1>Schedule Run </h1>';
});

Route::get('test-rol', function () {
    echo "hola";
})->middleware('has.role:administrador');
Route::get('test-permiso', function () {
    echo "hola permiso";
    $auth = auth()->user();
    $permisos = array();
    $permisos[] = $auth->hasPermissionTo('menu.gestion.datos.personales.form.buscar.persona');
    dd($permisos);
})->middleware('has.permission:menu.gestion.datos.personales.form.buscar.persona');

Route::get('/cache-clear', function () {
    $exitCode1 = Artisan::call('cache:clear');
    $exitCode2 = Artisan::call('route:clear');
    $exitCode3 = Artisan::call('view:clear');
    $exitCode4 = Artisan::call('config:cache');
    return '<h1>Cache cleared </h1>';
});
