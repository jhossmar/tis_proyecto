<!DOCTYPE> 
<html lang="es">
<head>
  <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
  <title>indice_ayuda</title>
  <style type="text/css">
  
  .modalmask {
	position: fixed;
	font-family: Arial, sans-serif;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	background: rgba(0,0,0,0.8);
	z-index: 99999;
	opacity:0;
	-webkit-transition: opacity 400ms ease-in;
	-moz-transition: opacity 400ms ease-in;
	transition: opacity 400ms ease-in;
	pointer-events: none;
}
.modalmask:target {
	opacity:1;
	pointer-events: auto;
}
.modalbox{
	width: 800px;
	position: relative;
	padding: 5px 20px 13px 20px;
	background: #fff;
	border-radius:3px;
	-webkit-transition: all 500ms ease-in;
	-moz-transition: all 500ms ease-in;
	transition: all 500ms ease-in;
	
}

.movedown {
	margin: 0 auto;
}
.rotate {
	margin: 10% auto;
	-webkit-transform: scale(-5,-5); 
	transform: scale(-5,-5);
}
.resize {
	margin: 10% auto;
	width:0;
	height:0;

}
.modalmask:target .movedown{		
	margin:10% auto;
}
.modalmask:target .rotate{		
	transform: rotate(360deg) scale(1,1);
    -webkit-transform: rotate(360deg) scale(1,1);
}

.modalmask:target .resize{
	width:400px;
	height:200px;
}



.close {
	background: #606061;
	color: #FFFFFF;
	line-height: 25px;
	position: absolute;
	right: 1px;
	text-align: center;
	top: 1px;
	width: 24px;
	text-decoration: none;
	font-weight: bold;
	border-radius:3px;
	font-size:16px;
}

.close:hover { 
	background: #FAAC58; 
	color:#222;
}
  	
  	
  	div#menu{
  		width: 450px;
  		margin-top 20px;
  		//background-color:red;
  	 }
  	 div#menu ul {
  	 	list-style: none ;
  	 }
  	 
  	 div#menu ul li {
  	 	margin-top: 15px;
  	 	font-family: tahoma;
  	 	font-size: 18 px;
  	 	background-color: #F4F4F4;
  	 	width :450 px;
  	 	padding-top:10px;
  	 	//padding-botton: 10px;
  	 	border-radius:0px 20px 20px 0px;
  	    padding-left:20px;
  	    box-shadow: 5px 0px 10px #939393;
  	 -webkit-transition: padding-left 0.6s;
  	 color: white;
  	 } 
  	 
  	 div#menu ul li:hover{
  	 	padding-left: 100px;
        color: black;
  	 }
  	 
  	 .nsc{
	position:absolute;
	bottom:40%;
	right:0;
}
  	 
  
</style>
 </head>
  
<body> 
	<div id = "menu">
		<ul>
			<li><a href="indice_ayuda.php?nom_arch=002#modal1">INTRODUCCION</a></li>
			<li><a href="indice_ayuda.php?nom_arch=003#modal1">VISTA PRINCIPAL</a></li>
			<li><a href="indice_ayuda.php?nom_arch=004#modal1">FUNCIONES DEL ADMINISTRADOR</a></li>
			<li><a href="indice_ayuda.php?nom_arch=005#modal1">FUNCIONES DEL CONSULTOR TIS</a></li>
            <li><a href="indice_ayuda.php?nom_arch=007#modal1">FUNCIONES DEL GRUPO EMPRESA</a></li>		
		    <li><a href="indice_ayuda.php?nom_arch=008#modal1">FUNCIONES DE LOS INTEGRANTES</a></li>
		    <li><a href="indice_ayuda.php?nom_arch=009#modal1">FUNCIONES ADICIONALES</a></li>
		</ul>
		
	</div>
	
	<div class="center">
	
		<a href="#modal1">DESLIZAR</a></li>
		
	
	<div id="modal1" class="modalmask">
		<div class="modalbox movedown">
			<a href="#close" title="Close" class="close">X</a>
		
		<?php
			error_reporting(E_ALL ^ E_NOTICE); //para que no muestre el error la primera vez que se ingrese a ayuda
			
			$id=$_GET['nom_arch'];
			//echo($id);
			echo "<h2>".$id."</h2>";
			echo "<embed src='archivos/".$id.".pdf' width=780 height=500 />";
			
	  	?>
		
		
			<!--<embed src='archivos/004.pdf' width=800 height=500 />-->
		
		
		 </div>
	</div>
	
	</div>	
	
	
  </body>
</html>
