<?php

Route::get('/','PrincipalController@inicio');
Route::get('index','PrincipalController@inicio');
Route::get('login_administrador','PrincipalController@loginAdministrador');
Route::post('login_administrador','PrincipalController@verificarAdministrador');
Route::get('iniciar_sesion','PrincipalController@iniciarSesion');
Route::post('iniciar_sesion', 'PrincipalController@verificarUsuario');



Route::get('home_admin','adminController@home_admin');
Route::get('info_admin','adminController@info_admin');
Route::get('administrar_consultor','adminController@administrar_consultor');
Route::get('administrar_grupo_empresa','adminController@administrar_grupo_empresa');
Route::get('bitacoras_usuario','adminController@bitacoras_usuario');
Route::get('backup','adminController@backup');
Route::get('administrar_mensajes','adminController@administrar_mensajes');
Route::get('modificar_registro_admin','adminController@modificar_registro_admin');



Route::get('home_jefe_consultor','JefeConsultorController@homeJefeConsultor');
Route::get('informacion_jefe_consultor','JefeConsultorController@informacionJefeConsultor');
Route::get('modificar_registro_jefe_consultor','JefeConsultorController@modificarJefeConsultor');
Route::post('modificar_registro_jefe_consultor','JefeConsultorController@validarCambiosJefeConsultor');
Route::get('subir_consultor_jefe','JefeConsultorController@subirJefeConsultor');
Route::post('subir_consultor_jefe','JefeConsultorController@validarAvisoJefeConsultor');
Route::get('subir_contrato','JefeConsultorController@subirContrato');
Route::post('subir_contrato','JefeConsultorController@validarContrato');
Route::get('administrar_archivos','JefeConsultorController@administrarArchivos');
Route::post('administrar_archivos','JefeConsultorController@validarArchivos');
Route::get('planificacion_actividades','JefeConsultorController@planificarActividades');
Route::post('planificacion_actividades/{id}','JefeConsultorController@validarActividades');
Route::get('calificar_grupo_empresa','JefeConsultorController@calificarGrupoEmpresa');
Route::get('evaluar_grupo_empresa/{id}','JefeConsultorController@actualizarCalificacion');
Route::get('evaluar_grupo_empresa/{id}/{id_actividad}','JefeConsultorController@mostrarTareas');
Route::post('modificar_entrega_producto','JefeConsultorController@modificarEntregaProducto');
Route::post('actualizar_entrega_producto','JefeConsultorController@actualizarEntregaProducto');
Route::get('administrar_grupo','JefeConsultorController@administrarGrupo');
Route::post('administrar_grupo','JefeConsultorController@validarCambiosGrupo');
Route::get('reporte/{id_grupo}','JefeConsultorController@reporteGrupoEmpresa');
Route::get('habilitar_integrantes/{id_grupo}','JefeConsultorController@habilitarIntegrantes');
Route::post('validar_habilitar_integrante','JefeConsultorController@validarCambiosIntegrantes');
Route::get('notificaciones','JefeConsultorController@notificaciones');
Route::post('administrar_notificacion','JefeConsultorController@administrarNotificaciones');
Route::get('mensajes','JefeConsultorController@mensajes');
Route::post('insert','JefeConsultorController@insertarMensajes');



Route::get('home_grupo','GrupoEmpresaController@homeGrupo');
Route::get('formulario_entrega_producto','GrupoEmpresaController@entregaSubSistema');
Route::get('info_grupo','GrupoEmpresaController@informacionGrupo');


Route::get('salir',function(){
  // por ahora para borrar variables de session
   Session::flush();
  return redirect('/');
});


Route::get('contacto','WelcomeController@contacto');
Route::get('hola','PrincipalController@principal');
Route::get('tabla','PrincipalController@tabla');
Route::get('modelo','PrincipalController@modelo');
Route::get('padre','PrincipalController@padre');
Route::get('header','PrincipalController@header');
Route::get('paso/{id}','PrincipalController@mostrar');

