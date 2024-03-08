<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;

// retrieve user instance
$my =& JFactory::getUser();

$ced = ($my->id) ? $my->username : ""; // usuario de la sesion activa
$nom = ($my->id) ? $my->name : "No identificado"; // usuario de la sesion activa

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');

////////////////////////////////////

if ( !empty($ced) )
{
	$dirw = "/home/web/jcapunefm/pdfs/";
	$raiz = "/srv/www/htdocs";
	$rdir = "/";
	$file_socio = $raiz . $rdir . "SFUNERA.TXT";

	if ( file_exists($file_socio) ){
		unlink( $file_socio );
	}
	touch ($file_socio);

	escribir_archivo($file_socio, $ced); // guardar id usuario para su lectura por procesa

	$filas = $raiz . $rdir . $ced . "_SFUNERA.TXT"; // archivo resultante
	if ( file_exists($filas) ) {
		unlink( $filas );
	}

	$ejec = exec($raiz . $rdir . "ejec_pvx_sfunera 2>&1");

	if ( file_exists($filas) )
	{

			$benef_arr = file(trim($filas));

			foreach ( $benef_arr as $beneficiario )
			{
				echo $beneficiario . "<br>";
			}



                //$hashced = substr(hash_hmac('sha256', $ced, md5(microtime())), 0, 32);
                //copy($filas, $dirw . $hashced . ".pdf");
                //$updf = JURI::base() . "pdfs/" . $hashced . ".pdf";
				//unlink( $filas );
		
//                echo "{pdf=" . $updf . "|100%|500}";

            /*    echo "<center>
                        <object width='100%' height='480' internalinstanceid='25' type='application/pdf' 
                                data='" . $updf . "'>
							<iframe src='" . $updf . "' style='border: none;' height='100%' width='100%'>
							Este navegador no soporta lector de PDF. Por favor descargue el estado de cuenta mediante: <a href='" . $updf . "'>Descargar PDF</a>
							</iframe>
                        </object>
                </center>
                ";
*/
                remover_antiguos($dirw);
	}
	else
	{
		echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>,
		a fin de generar sus estados de cuenta como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}

} // fin - al consultar un asociado

?>
