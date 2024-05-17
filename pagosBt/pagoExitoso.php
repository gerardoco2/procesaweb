<?php 
   if(isset($_POST)){
    $data = file_get_contents("php://input");
    $update = json_encode($data);
    echo $update;


    $raiz = "/srv/www/htdocs";
    $rdir = "/";

    $filas = $raiz . $rdir . $ced . "_RECHAZOS.TXT";
    $arreglo_lineas = file($filas);

    

   }
?>