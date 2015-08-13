<?php

Route::get('/','PrincipalController@inicio');
Route::get('index','PrincipalController@inicio');
Route::get('login_administrador','PrincipalController@loginAdministrador');
Route::post('login_administrador','PrincipalController@verificarAdministrador');
Route::get('iniciar_sesion','PrincipalController@iniciarSesion');
Route::post('iniciar_sesion', 'PrincipalController@verificarUsuario');

Route::get('home_jefe_consultor','JefeConsultorController@homeJefeConsultor');
Route::get('informacion_jefe_consultor','JefeConsultorController@informacionJefeConsultor');
Route::get('modificar_registro_jefe_consultor','JefeConsultorController@modificarJefeConsultor');
Route::post('modificar_registro_jefe_consultor','JefeConsultorController@validarCambiosJefeConsultor');
Route::get('subir_consultor_jefe','JefeConsultorController@subirJefeConsultor');
Route::post('subir_consultor_jefe','JefeConsultorController@validarAvisoJefeConsultor');
Route::get('subir_contrato','JefeConsultorController@subirContrato');
Route::post('subir_contrato','JefeConsultorController@validarContrato');

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

