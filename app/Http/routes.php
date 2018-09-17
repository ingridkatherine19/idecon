<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::any('/', [ 'uses' => 'HomeController@index']);

Route::get('/logout', array(//Logout del usuario del sistema
		'as' => 'account-sign-out',
		'uses' => 'LoginController@logout'
	));


//USUARIO
Route::get('usuario/create', [ 'uses' => 'UsuarioController@create']);
Route::get('usuario/createevento', [ 'uses' => 'UsuarioController@createEvento']);
Route::get('usuario/all', [ 'uses' => 'UsuarioController@allUser']);
Route::get('usuario/update', [ 'uses' => 'UsuarioController@update']);
Route::get('usuario/delete', [ 'uses' => 'UsuarioController@delete']);
Route::get('usuario/reestablecer', [ 'uses' => 'UsuarioController@Reestablecer']);
Route::get('usuario/changepassword', [ 'uses' => 'UsuarioController@cambiarcontrasena']);
Route::get('usuario/cambiarswitch', [ 'uses' => 'UsuarioController@CambiarSwitch']);



//EMPRESA
Route::get('empresa/all', [ 'uses' => 'EmpresaController@all']);
Route::get('empresa/alldepartamento', [ 'uses' => 'EmpresaController@allDepartamento']);
Route::get('empresa/create', [ 'uses' => 'EmpresaController@create']);
Route::get('empresa/update', [ 'uses' => 'EmpresaController@update']);
Route::get('empresa/delete', [ 'uses' => 'EmpresaController@delete']);
Route::get('empresa/reportempresa', [ 'uses' => 'EmpresaController@ReporteEmpresa']);


//DEPARTAMENTO
Route::get('departamento/all', [ 'uses' => 'DepartamentoController@all']);
Route::get('departamento/buscar', [ 'uses' => 'DepartamentoController@Buscar']);


//DASHBOARD
Route::get('dashboard/act', [ 'uses' => 'DashboardController@all']);
Route::get('dashboard/alldepartamento', [ 'uses' => 'DashboardController@allDepartamento']);

Route::get('actividad/evento', [ 'uses' => 'DashboardController@ActividadesAll']);

//REGION
Route::get('region/all', [ 'uses' => 'RegionController@all']);


//CIUDAD
Route::get('ciudad/all', [ 'uses' => 'CiudadController@all']);

//GENERO
Route::get('genero/all', [ 'uses' => 'GeneroController@all']);
Route::get('genero/create', [ 'uses' => 'GeneroController@Create']);


//EVENTO
Route::get('evento/all', [ 'uses' => 'EventoController@all']);
Route::get('evento/alldepartamento', [ 'uses' => 'EventoController@allDepartamento']);
Route::get('evento/create', [ 'uses' => 'EventoController@create']);
Route::any('evento/create', [ 'uses' => 'EventoController@create' , 'as' => 'evento_create']);
Route::get('evento/delete', [ 'uses' => 'EventoController@delete']);
Route::get('evento/inicio', [ 'uses' => 'EventoController@EventoInicio']);
Route::get('evento/fin', [ 'uses' => 'EventoController@EventoFin']);
Route::get('evento/send', [ 'uses' => 'EventoController@send']);
Route::get('evento/update', [ 'uses' => 'EventoController@Update']);
Route::get('evento/find', [ 'uses' => 'EventoController@find']);
Route::get('evento/total', [ 'uses' => 'EventoController@totales']);
Route::get('evento/totaldep', [ 'uses' => 'EventoController@totalesDep']);
Route::post('evento/guardarimagen', [ 'uses' => 'EventoController@guardarImagen' , 'as' => 'guardarImagen']);
Route::get('evento/reportetipo', [ 'uses' => 'EventoController@Reportetipo']);

//CONSUMO
Route::get('consumo/all', [ 'uses' => 'ConsumoController@all']);
Route::get('consumo/insertpalco', [ 'uses' => 'ConsumoController@createPalco']);
Route::get('consumo/actpalco', [ 'uses' => 'ConsumoController@updatePalco']);
Route::get('consumo/deletepalco', [ 'uses' => 'ConsumoController@deletePalco']);
Route::get('consumo/insertcalle', [ 'uses' => 'ConsumoController@createCalle']);
Route::get('consumo/actcalle', [ 'uses' => 'ConsumoController@updateCalle']);
Route::get('consumo/deletecalle', [ 'uses' => 'ConsumoController@deleteCalle']);
Route::get('consumo/insertorganico', [ 'uses' => 'ConsumoController@createOrganico']);
Route::get('consumo/actorganico', [ 'uses' => 'ConsumoController@updateOrganico']);
Route::get('consumo/deleteorganico', [ 'uses' => 'ConsumoController@deleteOrganico']);
Route::get('consumo/actmaterial', [ 'uses' => 'ConsumoController@actMaterial']);
Route::get('consumo/actbeneficio', [ 'uses' => 'ConsumoController@actBeneficio']);
Route::get('consumo/dashboard', [ 'uses' => 'ConsumoController@dashboard']);
Route::get('consumo/dashboarddesp', [ 'uses' => 'ConsumoController@dashboardDepartamento']);



//resumen App
Route::get('evento/inicioempresa', [ 'uses' => 'ResumenAppController@inicioEmpresa']);
Route::get('evento/inicioagrupacion', [ 'uses' => 'ResumenAppController@inicioAgrupacion']);
Route::get('evento/inicioparticipante', [ 'uses' => 'ResumenAppController@inicioParticipante']);
Route::get('evento/iniciopublico', [ 'uses' => 'ResumenAppController@inicioPublico']);

//evento app
Route::get('evento/iniciodetalle', [ 'uses' => 'EventoAppController@EventoInicio']);
Route::get('evento/hotel', [ 'uses' => 'EventoAppController@AllHoteles']);
Route::get('evento/restaurante', [ 'uses' => 'EventoAppController@AllRestaurantes']);
Route::get('evento/lugar', [ 'uses' => 'EventoAppController@AllLugares']);
Route::get('evento/info', [ 'uses' => 'EventoAppController@AllInfo']);
Route::get('evento/junta', [ 'uses' => 'EventoAppController@AllJunta']);
Route::get('evento/empresap', [ 'uses' => 'EventoAppController@AllEmpresasP']);
Route::get('evento/empresac', [ 'uses' => 'EventoAppController@AllEmpresasC']);
Route::get('evento/actividad', [ 'uses' => 'EventoAppController@AllActividades']);
Route::get('evento/interese', [ 'uses' => 'EventoAppController@InteresEmpresa']);
Route::get('evento/interesa', [ 'uses' => 'EventoAppController@InteresAgrupacion']);
Route::get('evento/interesp', [ 'uses' => 'EventoAppController@InteresParticipante']);
Route::get('interes/create', [ 'uses' => 'EventoAppController@CreateInfo']);
Route::get('interes/delete', [ 'uses' => 'EventoAppController@DeleteInfo']);

//poblacion
Route::get('pobla/buscar', [ 'uses' => 'EventoController@buscarPoblacion']);
Route::get('pobla/create', [ 'uses' => 'EventoController@createPoblacion']);
Route::get('pobla/update', [ 'uses' => 'EventoController@updatePoblacion']);

//JUNTA
Route::get('junta/all', [ 'uses' => 'JuntaController@all']);
Route::get('junta/create', [ 'uses' => 'JuntaController@create']);
Route::get('junta/update', [ 'uses' => 'JuntaController@update']);
Route::get('junta/delete', [ 'uses' => 'JuntaController@delete']);
Route::get('cargo/create', [ 'uses' => 'JuntaController@createCargo']);
Route::get('junta/count', [ 'uses' => 'JuntaController@count']);

//Actividad 
Route::get('actividad/create', [ 'uses' => 'ActividadController@Create']);
Route::get('actividad/calendario', [ 'uses' => 'ActividadController@actCalendario']);
Route::get('actividad/subact', [ 'uses' => 'ActividadController@subActividades']);
Route::get('actividad/createsub', [ 'uses' => 'ActividadController@createSub']);
Route::get('actividad/all', [ 'uses' => 'ActividadController@all']);
Route::get('actividad/delete', [ 'uses' => 'ActividadController@DeleteAct']);
Route::get('sub/delete', [ 'uses' => 'ActividadController@DeleteSub']);
Route::get('act/reporte', [ 'uses' => 'ActividadController@reporte']);
Route::get('act/update', [ 'uses' => 'ActividadController@Update']);
Route::get('sub/update', [ 'uses' => 'ActividadController@UpdateSub']);
Route::get('act/deletepalco', [ 'uses' => 'ActividadController@DeletePalco']);
Route::get('sub/deletepalco', [ 'uses' => 'ActividadController@DeletePalcoSub']);
Route::get('act/deletepremio', [ 'uses' => 'ActividadController@DeletePremio']);
Route::get('act/palco', [ 'uses' => 'ActividadController@AgregarPalco']);
Route::get('sub/palco', [ 'uses' => 'ActividadController@AgregarPalcoSub']);

//PARTICIPANTE
Route::get('participante/all
', [ 'uses' => 'ParticipanteController@all']);
Route::get('participante/alldepartamento
', [ 'uses' => 'ParticipanteController@allDepartamento']);
Route::get('participante/create
', [ 'uses' => 'ParticipanteController@Create']);
Route::get('participante/delete
', [ 'uses' => 'ParticipanteController@Delete']);
Route::get('participante/tipo
', [ 'uses' => 'ParticipanteController@Tipo']);
Route::get('participante/reporteP
', [ 'uses' => 'ParticipanteController@reporteParticipante']);
Route::get('participante/update', [ 'uses' => 'ParticipanteController@update']);



// PRESUPUESTO
Route::get('presupuesto/all', [ 'uses' => 'PresupuestoController@all']);
Route::get('costo/create', [ 'uses' => 'PresupuestoController@createCosto']);
Route::get('costo/update', [ 'uses' => 'PresupuestoController@updateCosto']);
Route::get('costo/delete', [ 'uses' => 'PresupuestoController@deleteCosto']);
Route::get('ingreso/create', [ 'uses' => 'PresupuestoController@createIngreso']);
Route::get('ingreso/update', [ 'uses' => 'PresupuestoController@updateIngreso']);
Route::get('ingreso/delete', [ 'uses' => 'PresupuestoController@deleteIngreso']);
Route::get('presupuesto/tipoall', [ 'uses' => 'PresupuestoController@allTipo']);
Route::get('presupuesto/tipocreate', [ 'uses' => 'PresupuestoController@createTipo']);
Route::get('costoa/all', [ 'uses' => 'PresupuestoController@allCostoActividad']);
Route::get('costoa/create', [ 'uses' => 'PresupuestoController@createCostoActividad']);
Route::get('costoa/delete', [ 'uses' => 'PresupuestoController@deleteCostoActividad']);

//REAL
Route::get('real/all', [ 'uses' => 'PresupuestoRealController@all']);

//COSTO PROVEE
Route::get('costoprovee/all', [ 'uses' => 'PresupuestoRealController@allCosto']);
Route::get('costoprovee/create', [ 'uses' => 'PresupuestoRealController@createCosto']);
Route::get('costoprovee/update', [ 'uses' => 'PresupuestoRealController@updateCosto']);
Route::get('costoprovee/delete', [ 'uses' => 'PresupuestoRealController@deleteCosto']);

//INGRESO CONSUME
Route::get('ingresoconsume/all', [ 'uses' => 'PresupuestoRealController@allIngreso']);
Route::get('ingresoconsume/create', [ 'uses' => 'PresupuestoRealController@createIngreso']);
Route::get('ingresoconsume/delete', [ 'uses' => 'PresupuestoRealController@deleteIngreso']);

//ACTIVIDADES PALCO
Route::get('actpalco/all', [ 'uses' => 'PresupuestoRealController@allActividad']);
Route::get('actpalco/update', [ 'uses' => 'PresupuestoRealController@updateActividad']);
Route::get('actcosto/update', [ 'uses' => 'PresupuestoRealController@updateCosto']);

//REPORTE
Route::get('poblacion/reporte', [ 'uses' => 'ReporteController@allPoblacion']);
Route::get('junta/reporte', [ 'uses' => 'ReporteController@allJunta']);
Route::get('actividad/reporte', [ 'uses' => 'ReporteController@allActividad']);
Route::get('socio/reporte', [ 'uses' => 'ReporteController@allSocio']);
Route::get('cultural/reporte', [ 'uses' => 'ReporteController@allCultural']);
Route::get('consumo/reporte', [ 'uses' => 'ReporteController@allConsumo']);
Route::get('empresas/colaboradoras', [ 'uses' => 'ReporteController@EmpresasColaboradoras']);

//AGRUPACIONES

Route::get('agrupacion/all', [ 'uses' => 'AgrupacionController@all']);
Route::get('agrupacion/alldepartamento', [ 'uses' => 'AgrupacionController@allDepartamento']);
Route::get('agrupacion/create', [ 'uses' => 'AgrupacionController@create']);
Route::get('agrupacion/update', [ 'uses' => 'AgrupacionController@update']);
Route::get('agrupacion/delete', [ 'uses' => 'AgrupacionController@delete']);
Route::get('agrupacion/reportegrupo', [ 'uses' => 'AgrupacionController@ReporteGrupo']);

//HOTEL

Route::get('hotel/all', [ 'uses' => 'HotelController@all']);
Route::get('hotel/alldepartamento', [ 'uses' => 'HotelController@allDepartamento']);
Route::get('hotel/create', [ 'uses' => 'HotelController@Create']);
Route::get('hotel/update', [ 'uses' => 'HotelController@Update']);
Route::get('hotel/delete', [ 'uses' => 'HotelController@Delete']);

//RESTAURANTE
Route::get('restaurante/all', [ 'uses' => 'RestauranteController@all']);
Route::get('restaurante/alldepartamento', [ 'uses' => 'RestauranteController@allDepartamento']);
Route::get('restaurante/create', [ 'uses' => 'RestauranteController@Create']);
Route::get('restaurante/update', [ 'uses' => 'RestauranteController@Update']);
Route::get('restaurante/delete', [ 'uses' => 'RestauranteController@Delete']);
Route::get('restaurante/reporteR', [ 'uses' => 'RestauranteController@reporteRestaurante']);
Route::get('restaurante/buscar', [ 'uses' => 'RestauranteController@Buscar']);


//Invitacion
Route::get('invitacion/listado', [ 'uses' => 'InvitacionController@Listado']);
Route::get('invitacion/guardar', [ 'uses' => 'InvitacionController@Create']);
Route::get('invitacion/estado', [ 'uses' => 'InvitacionController@EstadoInvitacion']);
Route::get('invitacion/guardarmensaje
', [ 'uses' => 'InvitacionController@CrearMensaje']);
Route::get('mensaje/all
', [ 'uses' => 'InvitacionController@AllMensajes']);
Route::get('mensaje/delete
', [ 'uses' => 'InvitacionController@DeleteMensaje']);
Route::get('invitacion/actualizarmensaje', [ 'uses' => 'InvitacionController@actualizarMensaje']);


//ENCUESTA
Route::get('encuesta/create', [ 'uses' => 'EncuestaController@create']);
Route::get('encuesta/reporte', [ 'uses' => 'EncuestaController@reporte']);
Route::get('pregunta/create', [ 'uses' => 'EncuestaController@preguntaCreate']);
Route::get('pregunta/update', [ 'uses' => 'EncuestaController@Update']);
Route::get('pregunta/all', [ 'uses' => 'EncuestaController@preguntaAll']);
Route::get('pregunta/delete', [ 'uses' => 'EncuestaController@preguntaDelete']);
Route::get('reporte/encuesta2', [ 'uses' => 'EncuestaController@reporteEncuesta2']);
Route::get('buscar/encuesta', [ 'uses' => 'EncuestaController@buscar']);

//Asociacion 
Route::get('asociacion/all', [ 'uses' => 'AsociacionController@all']);
Route::get('asociar/all2', [ 'uses' => 'AsociacionController@all2']);
Route::get('asociacion/guardar', [ 'uses' => 'AsociacionController@Asociar']);
Route::get('asociacion/Allsub', [ 'uses' => 'AsociacionController@Allsub']);
Route::get('asociacion/delete
', [ 'uses' => 'AsociacionController@delete']);
Route::get('buscar/asociar', [ 'uses' => 'AsociacionController@buscarAsociar']);
Route::get('nuevo/asociar', [ 'uses' => 'AsociacionController@nuevoAsociar']);
Route::get('nuevo/desasociar', [ 'uses' => 'AsociacionController@desasociar']);
Route::get('buscar/premio', [ 'uses' => 'AsociacionController@buscarPremio']);
Route::get('buscar/premiado', [ 'uses' => 'AsociacionController@buscarPremiado']);
Route::get('guardar/premiado', [ 'uses' => 'AsociacionController@guardarPremiado']);


//LUGARES
Route::get('lugar/all', [ 'uses' => 'LugarController@all']);
Route::get('lugar/alldepartamento', [ 'uses' => 'LugarController@allDepartamento']);
Route::get('lugar/create', [ 'uses' => 'LugarController@create']);
Route::get('lugar/update', [ 'uses' => 'LugarController@update']);
Route::get('lugar/delete
', [ 'uses' => 'LugarController@delete']);
Route::get('lugar/reporte
', [ 'uses' => 'LugarController@ReporteLugar']);


//LOGINUSUARIO
Route::get('usuarioapp/login', [ 'uses' => 'LoginAppController@index']);
Route::get('usuarioapp/logout', [ 'uses' => 'LoginAppController@logout']);

//VALORACION
Route::get('add/valoracion', [ 'uses' => 'ValoracionController@Create']);
Route::get('valoracion/buscar', [ 'uses' => 'ValoracionController@Buscar']);
Route::get('valoracion/promedio', [ 'uses' => 'ValoracionController@Promedio']);


//PerfilApp
Route::get('perfil/empresa', [ 'uses' => 'PerfilAppController@perfilEmpresa']);
Route::get('perfil/agrupacion', [ 'uses' => 'PerfilAppController@perfilAgrupacion']);
Route::get('perfil/participante', [ 'uses' => 'PerfilAppController@perfilParticipante']);

//RegistroApp
Route::get('registroapp/empresa', [ 'uses' => 'RegistroAppController@empresa']);
Route::get('registroapp/agrupacion', [ 'uses' => 'RegistroAppController@agrupacion']);
Route::get('registroapp/participante', [ 'uses' => 'RegistroAppController@participante']);
Route::get('registroapp/existente', [ 'uses' => 'RegistroAppController@usuarioExistente']);

//PRUEBATOKEN
Route::get('prueba/token', [ 'uses' => 'UsuarioController@Prueba']);
