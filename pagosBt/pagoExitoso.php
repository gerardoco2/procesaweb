<?php 
   if(isset($_POST)){
    $data = file_get_contents("php://input");
    $datos = json_decode($data);
    $ced = $datos->{"cedula"};
    $num_linea = $datos->{"lineaCuota"};
    $referencia = $datos->{"referencia"};

    $raiz = "/srv/www/htdocs";
    $rdir = "/";

    //del archivo de rechazoos obtener un arreglo con las lineas
    //---$filas = $raiz . $rdir . $ced . "_RECHAZOS.TXT";
    /// ---$arreglo_lineas = file($filas);

    // obtener la linea en la posicion especificada
    //---$linea_a_pagar = $arreglo_lineas[$num_linea];

   // escribir un archivo ced_cuota_a_pagar.txt
   // ---$file_cuota = $raiz . $rdir . "CUOTA_A_PAGAR.TXT";

	// --- if ( file_exists($file_cuota) ){
	// ---	unlink( $file_cuota );
	// ---}
	// ---touch ($file_cuota);

	// ---escribir_archivo($file_cuota, $linea_a_pagar . '"\n'. $refenecia .'"'); // guardar linea con datos de cuota para su lectura por procesa
   
   //ejecutar script de procesa que hace el asiento


   // eliminar archivo ced_cuota_A_pagar
   //unlink( $file_cuota );
    

   }
?>