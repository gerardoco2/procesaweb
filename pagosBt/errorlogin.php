<?php 
    $docr = $_SERVER['DOCUMENT_ROOT'];
    require_once($docr . '/phps/gestarchivo.php');



   if(isset($_POST)){
    $data = file_get_contents("php://input");
    $datos = json_decode($data);
    $error = $datos->{"errormsg"};


    $raiz = "/srv/www/htdocs";
    $rdir = "/";

    //del archivo de rechazoos obtener un arreglo con las lineas
    $archivo = $raiz . $rdir . $ced . date("Y-m-d h:i:s") . "_BTN_ERROR.TXT";
   
	if ( file_exists($archivo) ){
      unlink( $archivo );
	}
	touch($archivo);
   
	escribir_archivo($archivo, $error ); // guardar linea con datos del error
   

    // el mensaje
    $msg = $error;
    $msg = wordwrap($msg,70);

    // send email
    mail("infocapunefm@gmail.com","Error en registro de pago online",$msg);

   }else {
      echo '<h1> Por favor selecciona otr opcion del menu</h1>';
   }
?>