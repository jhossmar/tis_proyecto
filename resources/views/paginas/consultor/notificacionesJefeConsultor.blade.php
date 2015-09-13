@extends('header')
@section('contenido')
<div>
  <ul class="breadcrumb">
    <li>
      <a href={{url("index")}}>Inicio</a>
      <span class="divider">/</span>
    </li>
    <li>
      <a href={{url("notificaciones")}}>Notificaciones</a>
    </li>
  </ul>
</div>
<center><h3>Notificaciones</h3></center>
<div class="row-fluid">
  <div class="box span12">
    <div class="box-header well">
      <h2><i class="icon-check"></i> {{"Notificaciones de la Gesti&oacute;n :".$gestion['nombre_gestion'] }}</h2>
    </div>
    <div class="box-content alerts">
      @if($gestion['gestion_valida'])
        @if($num>0)
          <form method="post" action={{url("administrar_notificacion")}} accept-charset="utf-8">
            <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
            <input type="hidden" name="id_usuario" value={{$id_usuario}}>
            <input type="hidden" name="numero" value={{$num}}>
            <table class="table table-striped table-bordered  datatable">
              <thead>
                <tr><th><center>Notificaciones no le&iacute;das de la gesti&oacute;n actual</center></th></tr>
              </thead>              
              <tbody>
                @foreach($notificaciones as $notificacion)
                  <tr>
                    <td>
                      <div class="alert alert-info">
                        <span style="float: right" >Leido: <input type="hidden" id={{"a".$contador}} name={{"a".$contador}} value={{$notificacion->id_notificacion}}>                                                 
                        @if($notificacion->leido==1)
                          <input type="checkbox" id={{"c".$contador}} name={{"c".$contador}} checked>                          
                        @else
                          <input type="checkbox" id={{"c".$contador}} name={{"c".$contador}}>
                        @endif
                        </span>                                                  
                        <h4>Por : {{$nombres[$contador]}} </h4>
                        <div class="letra_aviso">{{$notificacion->descripcion}}<br></div>
                        <div class="pie_aviso">
                          <span style=" text-align:left">{{$tipos_usuarios[$contador]}}</span>
                          <span style="float:right">{{"Fecha ".$notificacion->fecha}}</span>
                        </div>
                      </div>                      
                    </td>
                  </tr>                  
                  <!--{{$contador++}}-->
                @endforeach
              </tbody>
            </table>
            <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar cambios</button>                      
          </form>          
        @else
          <div align="center">
            <h4><i class="icon-info-sign"></i>
              Usted no tiene ninguna notificaci&oacute;n.</h4>
          </div>
        @endif            
      @else
        <div align="center">
          <h4><i class="icon-info-sign"></i>
            La gesti&oacute;n no est&aacute; disponible, contacte con el administrador del sistema.</h4>
        </div>
      @endif
    </div>
  </div>
</div>
@stop