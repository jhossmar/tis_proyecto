@extends('master')
@section('titulo')
@if($condicional == false)
hola si  realizo la condicional
@else
no hola
@endif
@stop
@section('subtitulo')
prueba de master tamplate
@stop
@section('contenido')
<table border="1">
<tr>
<td>
hola
</td>
<td>
hola 2
</td>
</tr>
</table>
@stop