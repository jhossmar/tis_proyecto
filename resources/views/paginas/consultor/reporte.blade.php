<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>{{ $titulo or 'sistema de apoyo tis' }}</title>
	{!! Html::style('css/bootstrap-cerulean.css') !!}
	{!! Html::style('/css/bootstrap-responsive.css')!!}
  {!! Html::style('/css/letras.css')!!}
</head>
<body>
<div class="container-fluid">
  <div class="row-fluid">        
    <div class="span12">
      <img src={{asset("img/umss.png")}} height="100px" width="95px" />    	        
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;      
      <strong> <font color="#3f3f3f" face="arial" size="5">Sistema de Apoyo a la Empresa TIS </font></strong>
      &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
      <img src={{asset("img/fcyt.jpg")}} height="70px" width="90px" />
    </div>
  </div>
  <div class="row-fluid">
    <div class="span12">      
      <br>
      <br>
      <h4><font color="#3f3f3f" face="arial" size="3">
      Consultor TIS: {{$consultor}}</font></h4>
      <h4><font color="#3f3f3f" face="arial" size="3">
      Grupo Empresa: {{$nombreGrupo}}</font></h4>
      <h4><font color="#3f3f3f" face="arial" size="3">
      Fecha: {{date("d-m-y")}}</font></h4>      
    </div>        
  </div>
  <div class="row-fluid">
    <div class="span12">
      <br>
      <br>
      <h4><font color="#3f3f3f" face="arial" size="4"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; 1.- Información de la Grupo Empresa</font></h4>
    </div>
  </div>
  <div class="row-fluid">
     <div class="span9">
      <br>     
      <h4><font color="#696969" face="arial" size="3"> 1.1.- Subsistemas de la Grupo Empresa</font></h4>
      <br>
      <table style="font-size: 17px;border-color:#009999;" class="table table-bordered">
        <tr>
          <th style="text-align:center">Descripción</th>
          <th style="text-align:center">Inicio</th>
          <th style="text-align:center">Fin</th>
          <th style="text-align:center">Pago Establecido</th>
          <th style="text-align:center">Pago Recibido</th>
        </tr>
        @foreach($entregas as $entrega)
        <tr>         
          <td>{{$entrega->descripcion}}</td>
          <td>{{$entrega->fecha_inicio}}</td>
          <td>{{$entrega->fecha_fin}}</td>
          <td>{{$entrega->pago_establecido}}</td>
          <td>{{$entrega->pago_recibido}}</td>
        </tr>
        @endforeach
      </table>
     </div>
  </div>
  <div class="row-fluid">
    <div class="span9">
      <br>     
      <h4><font color="#696969" face="arial" size="3">1.2.- Actividades de todos los Subsistemas</font></h4>    
      <br>
      <table style="font-size: 17px;border-color:#009999;" class="table table-bordered">
        <tr>
          <th style="text-align:center">Entrega</th>
          <th style="text-align:center">Descripción</th>
          <th style="text-align:center">Inicio</th>
          <th style="text-align:center">Fin</th>
          <th style="text-align:center">Pocetaje completado (%)</th>          
        </tr>
        @foreach($actividades as $actividad)
        @foreach($actividad as $act)
        <tr>
          <td>{{$entregas[$contador]->descripcion}}</td>
          <td>{{$act->descripcion}}</td>
          <td>{{$act->fecha_inicio}}</td>
          <td>{{$act->fecha_fin}}</td>          
          <td>{{$act->porcentaje_completado}}</td>
        </tr>        
        @endforeach
        <!--{{$contador++}}-->
        @endforeach
      </table>
    </div>
  </div>
  <div class="row-fluid">
     <div class="span9">
      <br>     
      <h4><font color="#696969" face="arial" size="4"> &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp;2.- Información de los Integrantes de la Grupo Empresa</font></h4>
      <br>
      <h4><font color="#696969" face="arial" size="3">2.1.- Lista de Integrantes de la Grupo Empresa</h4>
      <br>
      <table style="font-size: 17px;border-color:#009999;" witdh="90%" height="50%" border="2" cellpadding="8">
        <tr>    
          <th style="text-align:center">Nombre</th>
          <th style="text-align:center">Código SIS</th>
          <th style="text-align:center">Correo</th>
          <th style="text-align:center">Teléfono</th>
          <th style="text-align:center">Carrera</th>          
        </tr>
        @foreach($integrantes as $integrante)
        <tr>
          <td>{{$integrante->nombre." ".$integrante->apellido}}</td>
          <td>{{$integrante->codigo_sis}}</td>
          <td>{{$integrante->email}}</td>
          <td>{{$integrante->telefono}}</td>          
          <td>{{$integrante->nombre_carrera}}</td>
        </tr>        
        @endforeach
      </table>
    </div>
  </div>
</div>      
</body>
</html>