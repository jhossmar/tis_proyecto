

//------- Switch Sectores (Ocultar o Mostrar Sectores de Codigo HTML) --------

function switchSector(indice){
  var link_mostrar = document.getElementById("link_mostrar_"+indice);
  var sector = document.getElementById("sector_"+indice);
  var link_ocultar = document.getElementById("link_ocultar_"+indice);
  if( sector.style.visibility == "visible" ){
	sector.style.visibility = "hidden";
	sector.style.position = "absolute";
	link_mostrar.style.visibility = "visible";
	link_mostrar.style.position = "relative";
	link_ocultar.style.visibility = "hidden";
	link_ocultar.style.position = "absolute";
   }
   else{
	link_mostrar.style.visibility = "hidden";
	link_mostrar.style.position = "absolute";
	sector.style.visibility = "visible";
	sector.style.position = "relative";
	link_ocultar.style.visibility = "visible";
	link_ocultar.style.position = "relative";
   }
}

//********************************************************************************************
//------------------------------ Para los avisos del index -----------------------------------
//********************************************************************************************
var tamAvisos = 0;   //Tamaño por defecto para todos los avisos, sera cambiado como la primera accion
var numAvisos = 0;     //El numero de avisos tiene la pagina
var pos = 0;           //Posicion para la rotacion  
var tamAviso = 0;    //El tamaño maximo que puede tener un aviso      
var avisos_mostrados;     //Un arreglo para los nombres de los avisos existentes

var ultimoAviso;    //Una cadena con el nombre del ultimo aviso
var avisoCola;      //Es el nombre del aviso que ira a la cola del arreglo, para simular el arreglo circular
var tiempoEspera;   //El tiempo de espera que se realize la siguiente iteracion
var tiempoPausa;    //El tiempo que se espera cuando existe una pausa
var tiempoRotacion; //El tiempo que se espera para el movimiento de los avisos
var incrementoPos   //El incremento o decremento para acelerar el movimiento de los avisos

var nombre_img;     //El nombre del elemento HTML IMG que se hace menos opaco
var nombre_img_salir;   //El nombre del elemento HTML IMG que se hace mas opaco, hasta su punto inicial
var sin_control;      //Booleano que me indica si se esta ejerciendo algun control sobre la animacion o no
var arriba;         //Boolean que me indica el sentido de la rotacion, por defecto arriba
var ciclo;         //Variable que me sirve para identificar la llamada al ciclo de rotacion
var firefox         // Booleano que me sirva para saber si se esta usando navegador firefox o no



function initAvisos_mostrados(){
    for(i=0; i<numAvisos; i++ )
        avisos_mostrados[i] = "aviso"+i;

    tiempoEspera = 200;
}

function setNumAvisos( num ){
  numAvisos = num;
  avisos_mostrados = new Array( numAvisos );
  tiempoRotacion = 70;
  tiempoPausa = 5000;
  sin_control = true;
  incrementoPos = 1;
  arriba = true;
  firefox = false;
  detectBrowser();
  initAvisos_mostrados();
}

function setTamAviso( tam ){
    //alert(screen.height);
    //alert(screen.width);
  tamAviso = tam;
  tamAvisos = tamAviso*3;       //Mostrare 3 avisos como maximo
}

function moverAvisos(){  
   if( numAvisos > 3 ){ 
   if( pos == 0 || pos == (tamAviso*(-1)))
        tiempoEspera = tiempoRotacion;
   
   if( arriba ){
      pos-= incrementoPos;      
      if( pos < (tamAviso*(-1))) {
        pos = 0;
      avisoCola = avisos_mostrados[0];
      for(j=0; j<numAvisos-1; j++)
        avisos_mostrados[j] = avisos_mostrados[j+1];
      avisos_mostrados[numAvisos-1] = avisoCola;
      if(sin_control)
        tiempoEspera = tiempoPausa;
      }
   }
   else {
      pos+= incrementoPos;
      if( pos > 0 ){
        pos = (tamAviso*(-1));        
        avisoCabeza = avisos_mostrados[numAvisos-1];
        for(j=numAvisos; j>0; j--)
          avisos_mostrados[j] = avisos_mostrados[j-1];
        avisos_mostrados[0] = avisoCabeza; 
        if(sin_control)
          tiempoEspera = tiempoPausa;
      }
   }
   for(i=0; i<numAvisos; i++){
     var aviso = document.getElementById( avisos_mostrados[i] );
     aviso.style.position = "absolute";
     aviso.style.top = (pos+tamAviso*i)+"px";
   }
    ciclo = setTimeout("moverAvisos()", tiempoEspera);
   }
 }
 

function control_aviso(img){    
    if( img != null ) {
        cambiar_velocidad(img);
        salir_todos();
        nombre_img = img;   
        if(ciclo > 0) {
          clearTimeout(ciclo);    
          ciclo = -1;
          moverAvisos();
        }
    }
    sin_control = false;
    
    var aviso_img = document.getElementById( nombre_img );
    if( firefox ) {
      aviso_img.style.opacity = ( Number(aviso_img.style.opacity)+0.1);        
    }
    else { 
      //document.getElementById( "pos" ).value = Number ( aviso_img.style.filter.substring(14, 16) );
      if(  Number ( aviso_img.style.filter.substring(14, 16)) + 10 < 99 ) 
          aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) +10 )+")";
      else 
          aviso_img.style.filter = "alpha(opacity=99)";
    }
    if( firefox ) {
      if( aviso_img.style.opacity < 1){        
          setTimeout("control_aviso()", 50);        
      }    
    } else {
        if( Number ( aviso_img.style.filter.substring(14, 16)) < 99 ){
          setTimeout("control_aviso()", 50);           
        } else {
          aviso_img.style.filter = "alpha(opacity=99)";
          //document.getElementById( "pos" ).value = "***********";
        }
    }
}

function control_salir_aviso(img){
    if( img != null ) {
        nombre_img_salir = img;
        if(ciclo > 0){
          clearTimeout(ciclo);        
          ciclo = -1;
          moverAvisos();
        }
    }
    sin_control = true;
    var aviso_img = document.getElementById( nombre_img_salir );
    if ( firefox ){
    aviso_img.style.opacity = ( Number(aviso_img.style.opacity)-0.1);    
    } else { 
      //document.getElementById( "pos" ).value = Number ( aviso_img.style.filter.substring(14, 16) );
      aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) -10 )+")";
    }
    if ( firefox ) {
      if( aviso_img.style.opacity > 0.3) { 
          setTimeout("control_salir_aviso()", 50);
      }
      else {
          aviso_img.style.opacity = 0.3;
      }        
    } else {
        if( Number ( aviso_img.style.filter.substring(14, 16)) > 29 ){
          setTimeout("control_salir_aviso()", 50);           
        } else {
            aviso_img.style.filter = "alpha(opacity=29)";
            //document.getElementById( "pos" ).value = "***********";
        }            
    }
}

function cambiar_velocidad( imagen ){    
switch (imagen) {
    case "masarriba": 
        tiempoRotacion = 10;
        incrementoPos = 4;
        arriba = true;
        break;
    case "arriba": 
        tiempoRotacion = 30;
        incrementoPos = 2;
        arriba = true;
        break;
    case "alto": 
        incrementoPos = 0;
        arriba = true;
        break;
    case "abajo": 
        tiempoRotacion = 30;
        incrementoPos = 2;
        arriba = false;
        break;        
    case "masabajo": 
        tiempoRotacion = 10;
        incrementoPos = 4;
        arriba = false;
        break;
    case "normal": 
        tiempoRotacion = 70;
        tiempoEspera = 70;
        tiempoPausa = 5000;
        incrementoPos = 1;
        arriba = true;
        break;
    default:
        tiempoRotacion = 70;
        tiempoEspera = 70;
        tiempoPausa = 5000;
        incrementoPos = 1;
        arriba = true;        
        break;
}
}

function normal(){
    cambiar_velocidad("normal");    
    if(document.getElementById( "masarriba" ) != null)
      salir_todos();    
}
                            
function salir_todos(){
    sin_control = true;
    var aviso_img = document.getElementById( "masarriba" );
    if( firefox ) {
      while( aviso_img.style.opacity > 0.3) { 
        aviso_img.style.opacity = ( Number(aviso_img.style.opacity)-0.001);                
      }
    } else { 
      while ( Number ( aviso_img.style.filter.substring(14, 16)) > 29 ) {  
        aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) -1 )+")";
      }
    }
    aviso_img = document.getElementById( "arriba" );
    if( firefox ){
      while( aviso_img.style.opacity > 0.3) { 
        aviso_img.style.opacity = ( Number(aviso_img.style.opacity)-0.001);                
      }
    } else { 
      while ( Number ( aviso_img.style.filter.substring(14, 16)) > 29 ) {  
        aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) -1 )+")";
      }
    }
    aviso_img = document.getElementById( "alto" );
    if( firefox ) {
      while( aviso_img.style.opacity > 0.3) { 
        aviso_img.style.opacity = ( Number(aviso_img.style.opacity)-0.001);                
      }
    } else { 
      while ( Number ( aviso_img.style.filter.substring(14, 16)) > 29 ) {  
        aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) -1 )+")";
      }
    }
    aviso_img = document.getElementById( "abajo" );
    if( firefox ){
      while( aviso_img.style.opacity > 0.3) { 
        aviso_img.style.opacity = ( Number(aviso_img.style.opacity)-0.001);                
      }
    } else { 
      while ( Number ( aviso_img.style.filter.substring(14, 16)) > 29 ) {  
        aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) -1 )+")";
      }
    }
    aviso_img = document.getElementById( "masabajo" );
    if( firefox ){ 
      while( aviso_img.style.opacity > 0.3) { 
        aviso_img.style.opacity = ( Number(aviso_img.style.opacity)-0.001);                
      }    
    } else { 
      while ( Number ( aviso_img.style.filter.substring(14, 16)) > 29 ) {  
        aviso_img.style.filter = "alpha(opacity="+ ( Number ( aviso_img.style.filter.substring(14, 16)) -1 )+")";
      }
    }
}
function detectBrowser() {
  var browser=navigator.appName;
  var b_version=navigator.appVersion;
  var version=parseFloat(b_version);
  //alert("br: "+browser+" ver: "+version);
  if(browser=="Netscape")
      firefox = true;
  /*if ((browser=="Netscape"||browser=="Microsoft Internet Explorer") && (version>=4) ) {
    alert("Your browser is good enough!");
  } else {
    alert("It's time to upgrade your browser!");
  }*/
}


 


