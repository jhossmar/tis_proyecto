@extends('header')

@section('contenido')
<div>
     <ul class="breadcrumb">
     <li>
       <a href="index.php">Inicio</a>
       <span class="divider">/</span>
   </li>
   <li>
     <a href="bitacoras_usuario.php">Bit&aacute;coras de usuario</a>
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
          <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
      <div class="row-fluid">
        <div class="span4">
           <div class="control-group">
              <label class="control-label" >Desde: </label>
              <div class="controls">
                <input type="text" class="datepicker" name="fecha_ini" data-date-format="dd/mm/yyyy"  etitable="false" placeholder="Mostrar desde" value={{$ini_filtro}}>
              </div>
           </div>
           <div class="control-group">
                <label class="control-label" >Hasta: </label>
              <div class="controls">
                <input type="text" class="datepicker" name="fecha_fin"  data-date-format="dd/mm/yyyy" etitable="false" placeholder="Mostrar hasta" value={{$fin_filtro}}>
              </div>
           </div>
        </div>
          <div class="span5">
            <div class="control-group">
                  <label class="control-label" >Gesti&oacute;n: </label>
                  <div class="controls">
                    <select name="gestion" data-rel="chosen">
                      <option value="-1">-- Todas las Gestiones --</option>
                      @foreach($listaDeGestiones as $gest)
                              <option value= {{$gest->id_gestion}}>{{$gest->gestion}}</option>  
                      @endforeach
                    </select>
                  </div>
              </div>
           <div class="control-group">
                  <label class="control-label" >Tipo de usuario: </label>
                  <div class="controls">
                    <select name="usuario" data-rel="chosen">
                    <option value="-1">-- Todos los usuarios --</option>
                    @foreach($listaDeUsuarios as $usr)
                           <option value= {{$usr->id_tipo_usuario}}>{{$usr->descripcion}}</option>  
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
      </form>
         <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th>ID Bit&aacute;cora</th>
                  <th>Nombre de usuario</th>
                  <th>Tipo de usuario</th>
                  <th>Fecha del evento</th>
                  <th>Evento</th>
                  <th>Gesti&oacute;n</th>
                </tr>
              </thead>   
              <tbody>
              @if( count($datos_bitacora1)>0)
                @foreach ($datos_bitacora1 as $dato_bitacora)
                 <tr>
                  <td>{{$dato_bitacora->id_bitacora_sesion}}</td>
                  <td>{{$dato_bitacora->nombre_usuario}}</td>
                  <td>{{$dato_bitacora->descripcion}}</td>
                  <td>{{$dato_bitacora->fecha_hora}}</td>
                  @if($dato_bitacora->operacion==0)
                  <td>Ingreso al sistema</td>
                  @else
                  <td>Salio del sistema</td>
                  @endif
                  <td >{{$dato_bitacora->gestion}}</td> 
                 </tr>
                @endforeach
               @endif  
              </tbody>
            </table>            
          </div>
        </div>
      </div>

      <div class="row-fluid" id="bitacora2">   
        <div class="box span12">
          <div class="box-header well" data-original-title>
            <h2><i class="icon-user"></i> Bit&aacute;coras de (algun nombre)</h2>
          </div>
          <div class="box-content">
          <form class="form-inline" name="form-data" method="POST" id="form" action="bitacoras_usuario#bitacora2" accept-charset="utf-8">
           <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
          <div class="row-fluid">
            <div class="span4">
              <div class="control-group">
                  <label class="control-label" >Desde: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_ini_2" placeholder="Mostrar desde" value="<?php echo $ini_filtro_2; ?>">
                  </div>
              </div>
              <div class="control-group">
                  <label class="control-label" >Hasta: </label>
                  <div class="controls">
                  <input type="text" class="datepicker" name="fecha_fin_2" placeholder="Mostrar hasta" value="<?php echo $fin_filtro_2; ?>">
                  </div>
              </div>
            </div>
          <div class="span5">
            <div class="control-group">
                  <label class="control-label" >Gesti&oacute;n: </label>
                  <div class="controls">
                    <select name="gestion_2" data-rel="chosen">
                      <option value="-1">-- Todas las Gestiones --</option>
                       @foreach($listaDeGestiones as $gest)
                         <option value= {{$gest->id_gestion}}>{{$gest->gestion}}</option>  
                        @endforeach
                    </select>
                  </div>
              </div>
           <div class="control-group">
                  <label class="control-label" >Tipo de usuario: </label>
                  <div class="controls">
                    <select name="usuario_2" data-rel="chosen">
                    <option value="-1">-- Todos los usuarios --</option>
                    @foreach($listaDeUsuarios as $usr)
                      <option value= {{$usr->id_tipo_usuario}}>{{$usr->descripcion}}</option>  
                    @endforeach
                  </select>
                  </div>
              </div>
          </div>
          <div class="span3">
            <div class="control-group">
                <label class="control-label" ></label>
                  <div class="controls">
                   <button type="submit" name="filtrar_2" value="Filtrar_2" class="btn btn-primary"><i class="icon-search"></i> Filtrar resultados</button>
                  </div>
            </div>
            <div class="control-group">
               <label class="error">{{$error_fecha_ini2}}</label>
                <label class="error">{{$error_fecha_fin2}}</label>
            </div>
          </div>
        </div>
        </form>
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr>
                  <th>ID Bit&aacute;cora</th>
                  <th>Nombre de usuario</th>
                  <th>Tipo de usuario</th>
                  <th>Fecha del evento</th>
                  <th>Evento</th>
                  <th>Tabla afectada</th>
                  <th>Gesti&oacute;n</th>
                </tr>
              </thead>   
              <tbody>
              @if( count($datos_bitacora2)>0)
               @foreach ($datos_bitacora2 as $dato_bitacora2)    
                 <tr>
                   <td>{{$dato_bitacora2->id_bitacora}}</td>
                   <td>{{$dato_bitacora2->nombre_usuario}}</td>
                   <td>{{$dato_bitacora2->descripcion}}</td>
                   <td>{{$dato_bitacora2->fecha_hora}}</td>          
                 @if(is_null($dato_bitacora2->viejo))
                   <td>Inserci&oacute;n</td>
                 @else
                   @if (!is_null($dato_bitacora2->viejo) && !is_null($dato_bitacora2->nuevo))
                   <td>Modificaci&oacute;n</td>
                   @else
                   <td>Eliminaci&oacute;n</td>
                   @endif
                 @endif   
                   <td >{{$dato_bitacora2->tabla}}</td>
                   <td >{{$dato_bitacora2->gestion}}</td>     
                </tr>
           @endforeach
         @endif
              </tbody>
            </table>            
          </div>
        </div><!--/span-->
      </div><!--/row-->



@stop
