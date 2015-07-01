<?php

header("content-type: image/png");


$avance=$_GET['avance'];// representa el avance



/**Lienzo de la imagen*/
$imagen= imagecreatetruecolor(100,50);
$negro=imagecolorallocate($imagen, 100, 100,100); 
imagefilltoborder($imagen, 0, 0, $negro, $negro);

/*porcentage de avance*/
$verde=imagecolorallocate($imagen, 0, 255, 0);
imagefilledrectangle($imagen, 0, 0, $avance, 50, $verde);
$rojo = imagecolorallocate($imagen, 255, 0, 0);
imagestring($imagen, 400, 30,15 , "".$avance."%", $rojo);



imagepng($imagen);
imagedestroy($imagen);

?>