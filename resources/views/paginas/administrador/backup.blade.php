@extends('header')

@section('contenido')
<div>
  <ul class="breadcrumb">
	 <li>
		<a href="index">Inicio</a>
	    <span class="divider">/</span>
	 </li>
     <li>
		<a href="backup">Respaldo y Restauraci&oacute;n de la Base de Datos</a>
	 </li>
  </ul>
</div>
<center><h3>Respaldo y Restauraci&oacute;n de la Base de Datos</h3></center>
 {{$mensaje}}	
 <div class="row-fluid">
        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-book"></i> Archivos de Restauraci&oacute;n de la Base de Datos disponibles</h2>
          </div>
          <div class="box-content">
	    <form name="form-data" method="POST" id="form_8" action="backup.php" accept-charset="utf-8">
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th>N&uacute;mero</th>
                  <th>Nombre del archivo</th>
                  <th>Fecha de creaci&oacute;n</th>
                  <th>Tama&ntilde;o del archivo</th>
                  <th style="text-align:center;">Restaurar Base de Datos</th>
                </tr>
              </thead>
              <tbody>




@stop