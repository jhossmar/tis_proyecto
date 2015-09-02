@extends('header')

@section('contenido')
<div>
  <ul class="breadcrumb">
	<li>
	  <a href="index">Inicio</a>
      <span class="divider">/</span>
	</li>
	<li>
	  <a href="administrar_mensajes">Administrar Espacio de Discuci&oacute;n</a>
	</li>
  </ul>
</div>
<center><h3>Administrar Espacio de Discuci&oacute;n</h3></center>
<div class="row-fluid">
  <div class="box span12">
   <div class="box-header well" data-original-title>
   <h2><i class="icon-user"></i> Administrar Espacio de Discuci&oacute;n</h2>
   </div>
  <div class="box-content">
  @if($num_mensajes>0)
     <form method="post" action="conexion/admin_msg.php" accept-charset="utf-8">
	  <table class="table table-striped table-bordered  datatable">
        <thead>
           <tr>
           <th><center>Comentarios Disponibles</center></th>
           </tr>
        </thead> 
		<tbody>
  @else
     <div align="center">
       <h4><i class="icon-info-sign"></i>
        No existe ninguna Publicacion</h4>
     </div>
  @endif
   </div>
  </div><!--/span-->
</div>

@stop