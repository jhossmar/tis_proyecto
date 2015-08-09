<script src="js/noticias.js"></script>
<script language="JavaScript" type="text/javascript">
    var nume={{$datos['numdoc']}}
        setTamAviso( 130 );
        setNumAvisos( nume );
        timerID = setTimeout("moverAvisos()", 1000);
</script> 
@if($datos['numdoc'] == 0)     
  <div align="center">
    <h4><i class="icon-info-sign"></i>
        No existe ning&uacute;n aviso para esta gesti&oacute;n.</h4>
  </div>    
@else   
  @if($datos['numdoc'] < 4)
    <table style="position:relative; overflow:hidden; width:100%; max-height=390px">
      @foreach($datos['resultado_noticias'] as $row)
        <tr>
          <td>
            <div class="caja_aviso">
              <div class="subtitulo_aviso"><h4>Por : {{ $row->nombre.$row->apellido }}</h4>
                <h4>Asunto:{{ $row->nombre_documento }} <h4></div>
                  <div class="letra_aviso">{{ $row->descripsion_documento }}
                    <br>
                  </div>
                    <div class="pie_aviso">
                      @if(!empty($row->ruta_documento))                     
                        <a href={{asset($row->ruta_documento)}} style="float:left"> <i class="icon-download-alt"></i> Descargar</a></hr>
                      @endif
                      <p style="text-align:right">Publicado el  {{ $row->fecha_documento }}</p>
                    </div>
              </div>
            </div>
          </td>
        </tr>                
      @endforeach
    </table>
  @else
    <table width="100%" cellpadding="0" cellspacing="0">
      <tr>
        <td style="width: 96%" onmouseover="normal()">
          <div style="position:relative overflow:hidden width:100% height:390px">                                             
            @foreach($datos['resultado_noticias'] as $row)
              <div class="caja_aviso" align="center" style="position:absolute  width: 95% left: 2.5% margin-bottom:50px">
                <div class="subtitulo_aviso">
                  <h4>{{"Por : ".$row->nombre." ". $row->apellido }}</h4>
                  <h4>{{'Asunto: '. $row->nombre_documento }} </h4>
                </div>                 
                <div class="letra_aviso">{{ $row->descripsion_documento }}<br>
                </div>
                <div class="pie_aviso">
                  @if(!empty($row->ruta_documento))
                    <a href={{asset($row->ruta_documento)}} style="float:left"> <i class="icon-download-alt"></i> Descargar</a>
                  @endif
                  <p style="text-align:right">{{"Publicado el ".$row->fecha_documento }}</p> 
                </div>
              </div>                    
            @endforeach
          </div>
        </td>
        <td style="width: 2%">
          <table style="height: 390px" border="0" cellpadding="0" cellspacing="0">
            <tbody>
              <tr style="height: 20%"><td><img id="masarriba" alt="Arriba Rapido" src="img/masarriba.jpg" style="opacity:0.3 filter:alpha(opacity=29)" onmouseover="control_aviso(&#39 masarriba&#39)" onmousedown="control_aviso(&#39 masarriba&#39)" onmouseout="control_salir_aviso(&#39 masarriba&#39)"></td></tr>
              <tr style="height: 20%"><td><img id="arriba" alt="Arriba" src="img/arriba.jpg" style="opacity:0.3 filter:alpha(opacity=29)" onmouseover="control_aviso(&#39 arriba&#39)" onmousedown="control_aviso(&#39 arriba&#39 )" onmouseout="control_salir_aviso(&#39 arriba&#39)"></td></tr>
              <tr style="height: 20%"><td><img id="alto" alt="Detener" src="img/alto.jpg" style="opacity:0.3 filter:alpha(opacity=29)" onmouseover="control_aviso(&#39 alto&#39)" onmousedown="control_aviso(&#39 alto&#39 )" onmouseout="control_salir_aviso(&#39 alto&#39 )"></td></tr>
              <tr style="height: 20%"><td><img id="abajo" alt="Abajo" src="img/abajo.jpg" style="opacity:0.3 filter:alpha(opacity=29)" onmouseover="control_aviso(&#39 abajo&#39)" onmousedown="control_aviso(&#39 abajo&#39 )" onmouseout="control_salir_aviso(&#39 abajo&#39)"></td></tr>
              <tr style="height: 20%"><td><img id="masabajo" alt="Abajo Rapido" src="img/masabajo.jpg" style="opacity:0.3 filter:alpha(opacity=29)" onmouseover="control_aviso(&#39 masabajo&#39)" onmousedown="control_aviso(&#39 masabajo&#39 )" onmouseout="control_salir_aviso(&#39 masabajo&#39 )"></td></tr>
            </tbody>
          </table>
        </td>
      </tr>
    </table>
  @endif
@endif