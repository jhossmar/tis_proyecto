@extends('header')

@section('contenido')

<h1>"Pagina de bitacoras"</h1>
	<div>
	   <ul class="breadcrumb">
		 <li>
	       <a href="index">Inicio</a>
		   <span class="divider">/</span>
		 </li>
	     <li>
			 <a href="bitacoras_usuario">Bit&aacute;coras de usuario</a>
		 </li>
	   </ul>
	</div>
    <center><h3>Bit&aacute;coras de usuario</h3></center>
    
     <div class="row-fluid" id="bitacora1">   
        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Bit&aacute;coras de sesi&oacute;n de usuario</h2>
          </div>
          <div class="box-content">
          <form class="form-inline" name="form-data" method="POST" id="form_8" action="bitacoras_usuario#bitacora1" accept-charset="utf-8">
          <div class="row-fluid">
            <div class="span4">
              <div class="control-group">
                  <label class="control-label" >Desde: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_ini" placeholder="Mostrar desde" value={{$ini_filtro}}>
                  </div>
              </div>
              <div class="control-group">
                  <label class="control-label" >Hasta: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_fin" placeholder="Mostrar hasta" value={{$fin_filtro}}>
                  </div>
              </div>
            </div>
       <div class="span5">
       	   <div class="control-group">
                  <label class="control-label" >Gesti&oacute;n: </label>
            <div class="controls">
               <select name="gestion" data-rel="chosen">
                  <option value="-1">-- Todas las Gestiones --</option>
                           @foreach($listaDeGestiones as $gestion)
                              <option value= {{$gestion->id_gestion}}>{{$gestion->gestion}}</option>  
                           @endforeach
                 </select>
              </div>
            </div>
           <div class="control-group">
              <label class="control-label" >Tipo de usuario: </label>
                 <div class="controls">
                    <select name="usuario" data-rel="chosen">
                    <option value="-1">-- Todos los usuarios --</option>
                        @foreach($listaDeUsuarios as $usuario)
                           <option value= {{$usuario->id_tipo_usuario}}>{{$usuario->descripcion}}</option>  
                         @endforeach
                </select>
              </div>
            </div>
         </div>
        <div class="span3">
            <div class="control-group">
                <label class="control-label" ></label>
                  <div class="controls">
                   <button type="submit" name="filtrar" value="Filtrar" class="btn btn-primary"><i class="icon-search"></i> Filtrar resultados</button>
                  </div>
            </div>
            <div class="control-group">
                <label class="error">{{ $error_fecha_ini}}</label>
                <label class="error">{{ $error_fecha_fin}}</label>
                
           </div>
         </div>
       </div>


















       </div>
      </div><!--/span-->
    </div><!--/row termina la primera bitacora-->  




@stop