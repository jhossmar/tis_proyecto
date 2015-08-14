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



Route::get('home_jefe_consultor','PrincipalController@homeJefeConsultor');
Route::get('informacion_jefe_consultor','PrincipalController@informacionJefeConsultor');
Route::get('modificar_registro_jefe_consultor','PrincipalController@modificarJefeConsultor');
Route::post('modificar_registro_jefe_consultor','PrincipalController@validarCambiosJefeConsultor');


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

