@extends('master')
@section('titulo')
{{ $variable or 'por defecto' }}
@stop
@section('contenido')

    {{$resultado[0]->gestion." "." hola"}} 
    <br>
 <?php
foreach ($resultado as $user) {
    echo $user->fecha_ini_gestion;
    echo'<br>';
}
?>
@stop