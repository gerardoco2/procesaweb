<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;

// retrieve user instance
$my =& JFactory::getUser();

$ced = $_REQUEST["ced"]; // usuario de la consulta
$tip = $my->usertype; // tipo de usuario de la sesion activa

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');

////////////////////////////////////

if ( $tip === "Registered" || $tip === "Guest" ) 
{
        echo "No tiene permiso para visualizar est información. 
              Favor contactar a un Autor, Editor, Publicador, Gestor o Administrador de la plataforma Web";
        die;
}


	$dirw = "/home/web/jcapunefm/pdfs/";
	$raiz = "/srv/www/htdocs";
	$rdir = "/";


	$ejec = exec($raiz . $rdir . "ejec_pvx_sfunera_reporte 2>&1");

    $file = $raiz . $rdir . "REPORTE_FUNERA_AFIBENE.pdf";

	if ( file_exists($file) )
	{
    
		copy($file, $dirw . "REPORTE.pdf");
             $updf = JURI::base() . "pdfs/REPORTE.pdf";
                echo "<center>
                        <object width='100%' height='600' internalinstanceid='25' type='application/pdf' 
                                data='" . $updf . "'>
            <iframe src='" . $updf . "' style='border: none;' height='100%' width='100%'>
            Este navegador no soporta lector de PDF. Por favor descargue el estado de cuenta mediante: <a href='" . $updf . "'>Descargar PDF</a>
            </iframe>
			</object>
		</center>
		";

		remover_antiguos($file);
		remover_antiguos($updf);
	}
	else
	{
		echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}



?>
