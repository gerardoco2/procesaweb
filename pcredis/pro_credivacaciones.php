<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
header('Content-Type: text/html; charset=UTF-8');

global $app, $_SERVER;
// retrieve user instance
$my =& JFactory::getUser();

$ced = ($my->id) ? $my->username : ""; // usuario de la sesion activa
$nom = ($my->id) ? $my->name : "No identificado"; // usuario de la sesion activa

////////////////////////////////////

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');
require_once("lib_credivacaciones.php");
$ver = new Libcredivacaciones();

$bot = (isset($_REQUEST["bot"])) ? $_REQUEST["bot"] : "";
$raiz = "/srv/www/htdocs";
$rdir = "/";

switch ( $bot )
{
case 'lnk':
  {
	$npr = (isset($_REQUEST["npr"])) ? $_REQUEST["npr"] : "";
	$ver->respdf ($ced, $npr);
  }
  break;

case 'ace':
  {
        $url = JURI::getInstance()->toString();
//        $ver->mostraryfinalizar($url, $ced, $npr);
        $ver->aceptaryprocesar($ced, $raiz, $rdir, $url, $docr);
  }
  break;

case 'cal':
  {
	$nom = (isset($_REQUEST["nom"])) ? $_REQUEST["nom"] : "";
	$ema = (isset($_REQUEST["ema"])) ? $_REQUEST["ema"] : "";
	$tel = (isset($_REQUEST["tel"])) ? $_REQUEST["tel"] : "";
	$tip = (isset($_REQUEST["tip"])) ? $_REQUEST["tip"] : "";
	$cue = (isset($_REQUEST["cue"])) ? $_REQUEST["cue"] : "";
	$est = (isset($_REQUEST["est"])) ? $_REQUEST["est"] : "";
	$sta = (isset($_REQUEST["sta"])) ? $_REQUEST["sta"] : "";
	$aso = (isset($_REQUEST["aso"])) ? $_REQUEST["aso"] : 0;
	$apt = (isset($_REQUEST["apt"])) ? $_REQUEST["apt"] : 0;
	$das = (isset($_REQUEST["das"])) ? $_REQUEST["das"] : 0;
	$dpt = (isset($_REQUEST["dpt"])) ? $_REQUEST["dpt"] : 0;
	$p80 = (isset($_REQUEST["p80"])) ? $_REQUEST["p80"] : 0;
	$deu = (isset($_REQUEST["deu"])) ? $_REQUEST["deu"] : 0;
	$tpr = (isset($_REQUEST["tpr"])) ? $_REQUEST["tpr"] : 0;
	$cap = (isset($_REQUEST["cap"])) ? $_REQUEST["cap"] : 0;
	$taf = (isset($_REQUEST["taf"])) ? $_REQUEST["taf"] : 0;
	$caa = (isset($_REQUEST["caa"])) ? $_REQUEST["caa"] : 0;
	$dpm = (isset($_REQUEST["dpm"])) ? $_REQUEST["dpm"] : 0;
	$dpd = (isset($_REQUEST["dpd"])) ? $_REQUEST["dpd"] : "";
	$fec = (isset($_REQUEST["fec"])) ? $_REQUEST["fec"] : "";
	$jpm = (isset($_REQUEST["jpm"])) ? $_REQUEST["jpm"] : 0;
	$jpd = (isset($_REQUEST["jpd"])) ? $_REQUEST["jpd"] : "";
	$cpr = (isset($_REQUEST["cpr"])) ? $_REQUEST["cpr"] : "";
	$npr = (isset($_REQUEST["npr"])) ? $_REQUEST["npr"] : "";
	$afi = (isset($_REQUEST["afi"])) ? $_REQUEST["afi"] : 0;
	$ads = (isset($_REQUEST["ads"])) ? $_REQUEST["ads"] : "";
	$ads = $ver->str_to_utf8( urldecode($ads) );
	$mon = (isset($_REQUEST["mon"])) ? $_REQUEST["mon"] : 0;
	$opc = (isset($_REQUEST["opc"])) ? $_REQUEST["opc"] : 0;
	switch ($opc) {
	        case 1: $opago = "ordinarias";  break;
	        case 2: $opago = "especiales";  break;
	        case 3: $opago = "combinado";  break;
	}

	$file_socio = $raiz . $rdir . "PRE_CALCULO_" . $ver->getCredito() . ".TXT";

	$contenido = $ced . PHP_EOL . $dpm . PHP_EOL . $tip . PHP_EOL . $opc . PHP_EOL . $mon . PHP_EOL;
	$contenido .= ($ver->validaemail( $ema ) ? $ema : $my->email) . PHP_EOL;
	$contenido .= $ver->cumpleanos( $my->id );

	escribir_archivo($file_socio, $contenido);

	$ejec = exec($raiz . $rdir . "ejec_pvx_" . $ver->getEjecpvx() . " calculo 2>&1");

	$filas = $raiz . $rdir . $ced . "_CALCULO_" . $ver->getCredito() . ".TXT";

	$cn = file_get_contents( trim($filas) );
        $ln = explode("\n", $cn);

	$ver->verhtml($ced, $nom, $ema, $tel, $cue, $tip, $est, $sta, 
		$fec, $aso, $apt, $das, $dpt, $p80, $deu, $tpr, $cap,
		$taf, $caa, $dpm, $jpm, $dpd, $jpd, $cpr, $npr, $app, $mon, $opc, $ads, 'Recalcular');

	if ( file_exists($filas) && count($ln) > 0 )
	{
//		unlink( $filas );
		$url = JURI::getInstance()->toString();
		$nco = 10;
		$ms1 = $nco . ' CUOTAS QUINCELANES';
		$nce = 1;
		$ms2 = $nce . ' CUOTA ESPECIAL';
		if (substr($tip,0,1) == 'O') {
			$nco = 25;
			$ms1 = $nco . ' CUOTAS SEMANALES';
//			$nce = 2;
//			$ms2 = $nce . ' CUOTAS ESPECIALES';
		}
		$mco = $mce = $afi = 0;
		$des = '';

                foreach ($ln as $tx)
                {
                        $tx = trim( $tx );
                        list($uno, $dos) = explode(";", $tx, 2);
                        $arr = explode(";", trim($dos));

                       switch ( $uno ) {
                        case '01':
                                switch ( $opc ) {
                                case 1:
                                        $mco = trim($arr[0]);
                                        break;
                                case 2:
                                        $mce = trim($arr[0]);
                                        break;
                                case 3:
                                        $mco = trim($arr[0]);
                                        $mce = trim($arr[1]);
                                        break;
                                }
                                break;
/*				$mco = trim($arr[0]);
				$mce = trim($arr[1]);
                                break;
*/
                        case '02':
                                $afi = trim($arr[0]);
                                $des = trim($arr[1]);
                                break;
                        }
		}

	        echo "
	        <table width=100% height=100% border=0 cellspacing=0>
	                <tr>
	                        <td align=center>
	                                <hr width=95%>
	        ";
                switch ($opc) {
                case 1:
                        echo "<h4>" . $ms1 . " POR: " . $mco . "</h4>";
                        break;
                case 2:
                        echo "<h4>" . $ms2 . " POR: " . $mce . "</h4>";
                        break;
                case 3:
                        echo "<h4>" . $ms1 . " POR: " . $mco . "</h4>";
                        echo "<h4>" . $ms2 . " POR: " . $mce . "</h4>";
                        break;
                }
                if (floatval(str_replace(",","",$afi)) > 0 && !empty($des)) {
                        echo "<h5>" . $des . " " . $afi . "<h5>";
                }
                echo "<h4>";
                if ($ads != '0') {
                        echo "ADSCRIPCION: " . $ads;
                        $ads = urlencode( $ads );
                }
                else echo "Seleccione la adscripción para continuar...";
                echo "                  </h4>
                        	        <hr width=95%>
                	        </td>
        	        </tr>
	        </table>
	        <form id='fact' method=post action='".JRoute::_($url)."' onsubmit=''>
	        <table width=100% height=100% border=0 cellspacing=0>
	                <tr>
	                        <td>
				<span>Al hacer click en el bot&oacute;n aceptar, confirma su participaci&oacute;n</span>
				<br>
				<p class='text-center'>
				<input type=hidden name=ced value='$ced'>
				<input type=hidden name=nom value='$nom'>
				<input type=hidden name=ema value='$ema'>
				<input type=hidden name=tel value='$tel'>
				<input type=hidden name=cue value='$cue'>
				<input type=hidden name=tip value='$tip'>
				<input type=hidden name=est value='$est'>
				<input type=hidden name=aso value='$aso'>
				<input type=hidden name=apt value='$apt'>
				<input type=hidden name=das value='$das'>
				<input type=hidden name=dpt value='$dpt'>
				<input type=hidden name=p80 value='$p80'>
				<input type=hidden name=deu value='$deu'>
				<input type=hidden name=tpr value='$tpr'>
				<input type=hidden name=taf value='$taf'>
				<input type=hidden name=dpm value='$dpm'>
				<input type=hidden name=dpd value='$dpd'>
				<input type=hidden name=fec value='$fec'>
				<input type=hidden name=jpm value='$jpm'>
				<input type=hidden name=jpd value='$jpd'>
				<input type=hidden name=cpr value='$cpr'>
				<input type=hidden name=cap value='$cap'>
				<input type=hidden name=npr value='$npr'>
				<input type=hidden name=caa value='$caa'>
				<input type=hidden name=mon value='$mon'>
				<input type=hidden name=opc value='$opc'>
				<input type=hidden name=nco value='$nco'>
				<input type=hidden name=nce value='$nce'>
				<input type=hidden name=mco value='$mco'>
				<input type=hidden name=mce value='$mce'>
				<input type=hidden name=afi value='$afi'>
				<input type=hidden name=ads value='$ads'>
				<input type=hidden name=bot value='ace'>
				<input type=submit name=ace value='ACEPTAR Y PROCESAR' ".(($mon>0 && $opc>0 && $ads!='0')?'':'disabled').">
				</p>
                        </td>
                </tr>
	        </table>
	        </form>
        	";
	}
	else {
		echo "<p align=justify>Existe un <b><i>error en el cálculo de la jornada</i></b>.
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}
  }
  break;

default:
  if ( !empty($ced) )
  {
	$file_socio = $raiz . $rdir . "DISPONIBILIDAD_" . $ver->getCredito() . ".TXT";

	escribir_archivo($file_socio, $ced);

	$ejec = exec($raiz . $rdir . "ejec_pvx_" . $ver->getEjecpvx() . " disponibilidad 2>&1");

//	echo "paso... " . $s;
	$filas = $raiz . $rdir . $ced . "_DISPONIBILIDAD_" . $ver->getCredito() . ".TXT";

	$cn = file_get_contents( trim($filas) );
	$ln = explode("\n", $cn);
//var_dump($ln);

	if ( file_exists($filas) && count($ln) > 0 )
	{
//		unlink( $filas );
		$cedula = $nombre = $correo = $telefo = '';
		$cuenta = $tipper = $status = $estado = $fecact = '';
		$ahoaso = $ahopat = $deuaso = $deupat = $porc80 = 0;
		$deupre = $totpre = $totafi = $dpmont = $jpmont = 0;
		$dpdesc = $jpdesc = $codpro = $nompro = $desact = '';
		$nropre = $nroafi = $activo = 0;

		foreach ($ln as $tx)
		{
			$tx = trim( $tx );
			list($uno, $dos) = explode(";", $tx, 2);
			$arr = explode(";", trim($dos));

			if ( $uno == '01' ) {
				$cedula = $arr[0];
			}
//echo "dat: $uno - $arr[0] <br>";
			switch ( $uno ) {
			case '02':
				$nombre = $arr[0];
				break;
			case '03':
				$correo = $arr[0];
				break;
			case '04':
				$telefo = $arr[0];
				break;
			case '05':
				$cuenta = $arr[0];
				break;
			case '06':
				$tipper = $arr[0];
				break;
			case '07':
				$status = $arr[0];
				switch ($status) {
					case 'A':  $estado = 'ACTIVO';      break;
					case 'J':  $estado = 'JUBILADO';    break;
					default:   $estado = 'NO DEFINIDO'; break;
				}
				break;
			case '08':
				$ahoaso = $arr[0];
				break;
			case '09':
				$ahopat = $arr[0];
				break;
			case '10':
				$deuaso = $arr[0];
				break;
			case '11':
				$deupat = $arr[0];
				break;
			case '12':
				$porc80 = $arr[0];
				break;
			case '13':
				$deupre = $arr[0];
				break;
			case '14':
				$totpre = trim($arr[0]);
				$nropre = trim($arr[1]);
				break;
			case '15':
				$totafi = trim($arr[0]);
				$nroafi = trim($arr[1]);
				break;
			case '16':
				$dpmont = trim($arr[0]);
				$dpdesc = str_replace('<', '', $arr[1]);
				$dpdesc = str_replace('>', '', $dpdesc);
				$dpdesc = trim($dpdesc);
				break;
			case '17':
				$fecact = $arr[0];
				break;
			case '18':
				$jpmont = trim($arr[0]);
				$jpdesc = str_replace('<', '', $arr[1]);
				$jpdesc = str_replace('>', '', $jpdesc);
				$jpdesc = trim($jpdesc);
				break;
			case '19':
				$codpro = trim($arr[0]);
				$nompro = trim($arr[1]);
				break;
			case '20':
				$activo = trim($arr[0]);
				$desact = trim($arr[1]);
				break;
			}
		}
//echo $activo ."-".$desact;

                $adhesion = $ver->contratoadhesion($cedula);
//echo "test: " .$adhesion;
                if ( $adhesion == 1 ) {

			if ( $activo == 1 && empty($desact) ) {
				$ver->verhtml($cedula, $nombre, $correo, $telefo, $cuenta, $tipper, $status, $estado, 
					$fecact, $ahoaso, $ahopat, $deuaso, $deupat, $porc80, $deupre, $totpre, 
					$nropre, $totafi, $nroafi, $dpmont, $jpmont, $dpdesc, $jpdesc, 
					$codpro, $nompro, $app);
			}
			else {
				echo "<p align=justify style='font-size:150%; line-height: 24px;'>
				Hola, <span style='font-weight:bold; text-transform: uppercase;'>" . $nombre . " (C.I.: " . $ced . ")</span>;<br>
				usted no puede efectuar el proceso de pre-préstamo debido a la siguiente descripci&oacute;n:
				<br><br>" . $desact . "</p>";
				$ver->respdf ($cedula, $nompro);
			}
                }
                else {
                        echo "<p align=left style='font-size:150%; line-height: 24px;'>
                        Estimad@, <span style='font-weight:bold; text-transform: uppercase;'>" . $nom . " (C.I.: " . $ced . ")</span>;<br>
                        favor actualizar en su perfil de usuario la aceptación de los t&eacute;rminos y condiciones 
                        del contrato de adhesión para poder continuar con su solicitud de pr&eacute;stamo en l&iacute;nea.
                        <br>
                        <br>
                        <br>Si no recuerda la ruta de acceso para actualizar sus datos personales, haga 
                        <a href='" . JURI::base() . "index.php/cb-profile-edit' target='_self'>clic aqu&iacute;</a>.</p>";
                }
	}
	else {
		echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>,
		a fin de generar sus estados de cuenta como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}
  }
  break;
}

?>
