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

if ( !$ced )
{
//echo JURI::current();
	$uri =& JURI::getInstance();
	
  echo "<form name=f1 action=" . $uri->toString() . " method=post>
        <table width=100% height=100% border=0 cellspacing=0>
          <tr>
                <td width=25% align=center>
                        <img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
                </td>
                <td width=50% align=center>
                        <h3>CONSULTA DE ESTADO DE CUENTA</h3>
                        <br /> 
                        <b>ASOCIADO " . strtoupper( $app->getCfg('MetaKeys') ) . " </b>
                </td>
                <td width=25% valign=bottom align=right>
                " . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "<br>" . date("h:i:s a") . "
                </td>
          </tr>
          <tr>
                <td colspan=3 align=center>
                <hr width=95%>
                        ID: <input type=text name=ced size=20 value=''>&nbsp;&nbsp;<input type=submit name=enviar value='Consultar' size=12>
                <hr width=95%>
                </td>
          </tr>
        </table>
      </form>
  ";
}
else // ini - al consultar un asociado
{
	$dirw = "/home/web/jcapunefm/pdfs/";
	$raiz = "/srv/www/htdocs";
	$rdir = "/";
	$file_socio = $raiz . $rdir . "SOCIO.TXT";

	if ( file_exists($file_socio) ){
		unlink( $file_socio );
	}
	touch ($file_socio);

	escribir_archivo($file_socio, $ced); // guardar id usuario para su lectura por procesa

	$filas = $raiz . $rdir . $ced . "_EDOCTA.pdf"; // archivo resultante
	if ( file_exists($filas) ) {
		unlink( $filas );
	}

	$ejec = exec($raiz . $rdir . "ejec_pvx_estado 2>&1");

	if ( file_exists($filas) )
	{
		$hashced = substr(hash_hmac('sha256', $ced, md5(microtime())), 0, 32);
		copy($filas, $dirw . $hashced . ".pdf");
                $updf = JURI::base() . "pdfs/" . $hashced . ".pdf";
                unlink( $filas );
//		echo "{pdf=" . $updf . "|100%|500}";

                echo "<center>
                        <object width='100%' height='480' internalinstanceid='25' type='application/pdf' 
                                data='" . $updf . "'>
<iframe src='" . $updf . "' style='border: none;' height='100%' width='100%'>
Este navegador no soporta lector de PDF. Por favor descargue el estado de cuenta mediante: <a href='" . $updf . "'>Descargar PDF</a>
</iframe>
			</object>
		</center>
		";

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
