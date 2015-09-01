@extends('header')
@section('contenido')
<div>
  <ul class="breadcrumb">
    <li>
      <a href="{{url('index')}}">Inicio</a>
      <span class="divider">/</span>
    </li>
    <li>
      <a href={{url("administrar_grupo")}}>Administrar Grupo Empresas</a>
      <span class="divider">/</span>
    </li>
    <li>
      <a href={{url("habilitar_integrantes/".$id_grupo)}}>Habilitar Integrantes</a>
    </li>
  </ul>
</div>
<center><h3>Habilitar Integrantes</h3></center>
<div class="row-fluid">
  <div class="box span12" id="print">
    <div class="box-header well" data-original-title>
      <h2><i class="icon-check"></i> Integrantes de la Empresa {{$nombre_grupo}}</h2>
    </div>
    <div class="box-content">
      @if($gestion['gestion_valida'])
        @if($cantidad > 0)                
          <form name="form-data" class="form-horizontal cmxform" method="POST" action={{url("validar_habilitar_integrante")}} accept-charset="utf-8">
            <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
            <input type="hidden" id="grupo" name="grupo" value={{$id_grupo}}></input>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Apellido</th>
                  <th>Tel&eacute;fono</th>
                  <th>Correo Electr&oacute;nico</th>
                  <th>C&oacute;digo SIS</th>
                  <th><center>Habilitado</center></th>
                </tr>
              </thead>
              <tbody>                                   
                @foreach($integrantes as $integrante)
                <tr>
                  <td><input type="hidden" id={{"a".$contador}} name={{"a".$contador}} value={{$integrante->id_usuario}}>{{$integrante->nombre}}</td>
                  <td>{{$integrante->apellido}}</td>
                  <td>{{$integrante->telefono}}</td>
                  <td>{{$integrante->email}}</td>
                  <td>{{$integrante->codigo_sis}}</td>                                    
                  @if($integrante->habilitado=="1")
                    <td ><center> <input type="checkbox" id={{"b".$contador}} name={{"b".$contador}}  checked ></center></td>
                  @else
                    <td><center> <input type="checkbox" id={{"b".$contador}} name={{"b".$contador}}></center></td>
                  @endif
                </tr>                     
                <!--{{$contador++}}-->
                @endforeach                
              </tbody>
            </table>
            <div class = "control-group">
              <button name="enviar"type="submit" class="btn btn-primary" id="enviar"><i class="icon-ok"></i> Guardar Cambios</button>
              <a href={{url("habilitar_integrantes/".$id_grupo)}} rel="activi"><button type="button" class="btn" ><i class="icon-remove"></i> Restablecer</button></a>
            </div>
          </form>           
        @else
          <div align="center">
            <h4><i class="icon-info-sign"></i>
              La Grupo Empresa no tiene registrado m&aacute;s integrantes.</h4>
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