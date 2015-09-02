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
              <tr>
              @if(count($archivos)>0)
                @foreach ($archivos as $file) 
                <td>{{$file->cantidad}}</td>
                <td>{{$file->archivo}}</td>
                <td>{{$file->fecha_archivo}}</td>
                <td>{{$file->size_archivo }} KB</td>
                <td style="text-align:center;">
                  <label class="radio">
                    <input type="radio" name="archivo" value={{$file->$archivo}} />
                   </label>
                </td>
              
                  @endforeach
                 @endif 
              </tr>
            </tbody>
            </table></br>
          <button class="btn btn-success btn-setting"><i class="icon-backward"></i> Restaurar</button>  <button class="btn btn-primary btn-setting2" id="enviar_3"><i class="icon-plus"></i> Nuevo archivo de respaldo</button> <a href="javascript:history.back();" class="btn"><i class="icon-arrow-left"></i> Volver Atras</a>
          <div class="modal hide fade" id="myModal">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Restaurar Base de Datos</h3>
            </div>
            <div class="modal-body">
               <p>Usted va ha realizar la restauraci&oacute;n de la base de datos. La base de datos seleccionada puede no contener la informaci&oacute;n mas reciente del sistema.<br> <b>Nota:</b> Esta operaci&oacute;n no puede deshacerce.</p>
            </div>
            <div class="modal-footer">
              <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</a>
              <button type="submit" name="aceptar" value="aceptar" class="btn btn-primary"><i class="icon-ok"></i> Aceptar</button>
            </div>
          </div>
          <div class="modal hide fade" id="myModal2">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">×</button>
              <h3>Crear nuevo archivo de Respaldo</h3>
            </div>
            <div class="modal-header">
              @if($cantidadCambios>0)
               <p>Se ha registrado {{$cantidadCambios}} cambio(s) en la base de datos desde las 12:00 a.m. del d&iacute;a de hoy.</br>
                  Est&aacute; de acuerdo con generar un nuevo archivo de respaldo de la base de datos actual.</br>
               <b>Presione en Aceptar si usted desea crear una nueva copia de seguridad de la base de datos actual.</b></p>
              @else
               <p>No se ha registrado nig&uacute;n cambio en la base de datos desde las 12:00 a.m. del d&iacute;a de hoy.</br>
                  Un archivo de respaldo ser&aacute; de utilidad si ocurre alg&uacute;n error con el sistema.<br>
               <b>Presione en Aceptar si usted desea crear una nueva copia de seguridad de la base de datos actual.</b>
              @endif
            </div>
          <div class="modal-footer">
             <a href="#" class="btn" data-dismiss="modal"><i class="icon-remove"></i> Cancelar</a>
             <button type="submit" name="nuevo" value="nuevo" class="btn btn-primary"><i class="icon-ok"></i> Aceptar</button>
          </div>
   
       </div>
     </div>
    </div><!--/span-->
</div><!--/row-->

@stop