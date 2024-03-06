<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
header('Content-Type: text/html; charset=UTF-8');

global $mainframe, $_SERVER;
// retrieve user instance
$my =& JFactory::getUser();

$ced = ($my->id) ? $my->username : ""; // usuario de la sesion activa
$nom = ($my->id) ? $my->name : "No identificado"; // usuario de la sesion activa

////////////////////////////////////

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/media/gestarchivo.php');
$bot = (isset($_REQUEST["bot"])) ? $_REQUEST["bot"] : "";
$raiz = "/srv/www/htdocs";
$rdir = "/";

switch ( $bot ) 
{
case 'lnk':
  {
	$npr = (isset($_REQUEST["npr"])) ? $_REQUEST["npr"] : "";
	respdf ($ced, $npr);
/*
	$updf = $docr . "/media/pdf_vacaciones/" . $ced . ".pdf";
//echo $pdf; exit;

	$pdf = JURI::base() . "media/pdf_vacaciones/" . $ced . ".pdf";
	if ( file_exists($updf) ) { }

	echo "
		<table width=100% height=100% border=0 cellspacing=0>
		  <tr>
			<td width=25% align=center>
				<img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
			</td>
			<td width=50% align=center>
			  <b>GRACIAS POR PARTICIPAR EN EL PROGRAMA <br>" . $npr . "</b>
			</td>
			<td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
			  <br>" . date("h:i:s a") . "
			</td>
		  </tr>
		</table>

		  <br>
                <center>
                        <object width='640' height='480' internalinstanceid='25' type='application/pdf' data='" . $pdf . "'>
<iframe src='" . $pdf . "' style='border: none;' height='100%' width='100%'>
Este navegador no soporta lector de PDF. Por favor descargue el archivo mediante: <a href='http://www.capunefm.com.ve/media/pdf_vacaciones/" . $ced . ".pdf'>AQUI</a>
</iframe>
                        </object>
                        <br><br>
                        <a href='index.php?option=com_comprofiler&task=logout'>
                                <input type=button name=sesion value='Cerrar sesión'>
                        </a>
                </center>
	";
*/
  }
  break;

case 'ace':
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
	$taf = (isset($_REQUEST["taf"])) ? $_REQUEST["taf"] : 0;
	$dpm = (isset($_REQUEST["dpm"])) ? $_REQUEST["dpm"] : 0;
	$dpd = (isset($_REQUEST["dpd"])) ? $_REQUEST["dpd"] : "";
	$fec = (isset($_REQUEST["fec"])) ? $_REQUEST["fec"] : "";
	$jpm = (isset($_REQUEST["jpm"])) ? $_REQUEST["jpm"] : 0;
	$jpd = (isset($_REQUEST["jpd"])) ? $_REQUEST["jpd"] : "";
	$cpr = (isset($_REQUEST["cpr"])) ? $_REQUEST["cpr"] : "";
	$npr = (isset($_REQUEST["npr"])) ? $_REQUEST["npr"] : "";
	$mon = (isset($_REQUEST["mon"])) ? $_REQUEST["mon"] : 0;
	$opc = (isset($_REQUEST["opc"])) ? $_REQUEST["opc"] : 0;
	$nco = (isset($_REQUEST["nco"])) ? $_REQUEST["nco"] : 0;
	$nce = (isset($_REQUEST["nce"])) ? $_REQUEST["nce"] : 0;
	$mco = (isset($_REQUEST["mco"])) ? $_REQUEST["mco"] : 0;
	$mce = (isset($_REQUEST["mce"])) ? $_REQUEST["mce"] : 0;
	$afi = (isset($_REQUEST["afi"])) ? $_REQUEST["afi"] : 0;
	$ads = (isset($_REQUEST["ads"])) ? urldecode($_REQUEST["ads"]) : "";

	$file_socio = $raiz . $rdir . "DEFINITIVO.TXT";
//echo $file_socio . "<br>";

	$contenido = $ced . PHP_EOL;
	$contenido .= $nom . PHP_EOL;
	$contenido .= $dpm . PHP_EOL;
	$contenido .= $mon . PHP_EOL;
	$contenido .= $nco . PHP_EOL;
	$contenido .= $mco . PHP_EOL;
	$contenido .= $nce . PHP_EOL;
	$contenido .= $mce . PHP_EOL;
	$contenido .= $aso . PHP_EOL;
	$contenido .= $apt . PHP_EOL;
	$contenido .= $p80 . PHP_EOL;
	$contenido .= $tpr . PHP_EOL;
	$contenido .= $fec . PHP_EOL;
	$contenido .= $tip . PHP_EOL;
	$contenido .= $das . PHP_EOL;
	$contenido .= $dpt . PHP_EOL;
	$contenido .= $deu . PHP_EOL;
	$contenido .= $opc . PHP_EOL;
	$contenido .= $jpm . PHP_EOL;
	$contenido .= $ads;

	escribir_archivo($file_socio, $contenido);

	$ejec = exec($raiz . $rdir . "ejec_pvx_censo definitivo 2>&1");
//echo "ejecutando definitivo <br>";

	$searches = planillas( $ced );
//	$afi = str_replace(",","",$afi);
        if (floatval(str_replace(",","",$afi)) > 0) {
                $searches[] = "/home/pvx/PLANILLA_AFIANZADORA.pdf";
        }
	$fpdf = '';
	foreach ($searches AS $sea) {
		if ( file_exists($sea) ) {
			$fpdf .= $sea . " ";
		}
	}

//echo "serie: " . $fpdf . "<br>";
	if ( !empty($fpdf) ) {
		$pdff = $docr . "/media/pdf_vacaciones/" . $ced . ".pdf";
//echo "unido: " . $pdff . "<br>";
		$ejec = exec("/usr/bin/gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=" . $pdff . " " . $fpdf);
//		$ejec = exec("/usr/bin/convert " . $fpdf . " " . $pdff);
		if ( file_exists($pdff) ) {
                        $searches = planillas( $ced );
			foreach ($searches AS $sea) { unlink( $sea ); }
		}
	}

//	$updf = JURI::base(). "media/pdf_vacaciones/" . $ced . ".pdf";
	echo "
	        <form id='fdef' method=post action='".JRoute::_($url)."' onsubmit=''>
		<table width=100% height=100% border=0 cellspacing=0>
		  <tr>
			<td width=25% align=center>
				<img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
			</td>
			<td width=50% align=center>
			  <b>SE HA REGISTRADO EXITOSAMENTE EN EL PROGRAMA<br />
			  (" . $npr . ")</b>
			</td>
			<td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
			  <br>" . date("h:i:s a") . "
			</td>
		  </tr>
		  <tr>
			<td colspan=3 align=center>
			<hr width=95%>
			<h4>
				IMPRIMIR DOS(2) EJEMPLARES, ANEXAR COPIA DE NOMINA, C.I. Y RIF
				<br><br>
				ESPERAR JORNADA DE RECOLECCION DE SOLICITUDES EN EL AREA 
				CORRESPONDIENTE SEGUN CRONOGRAMA PUBLICADO PREVIAMENTE
				<br><br>
<!--				<a href='$updf' target='_new'>Ver planillas</a>-->
				<input type=hidden name=ced value='$ced'>
				<input type=hidden name=npr value='$npr'>
				<input type=hidden name=bot value='lnk'>
				<input type=submit name=ace value='MOSTRAR PLANILLAS Y FINALIZAR'>
			</h4>
			<hr width=95%>
			</td>
		  </tr>
		</table>
	        </form>

	";
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
	$ads = (isset($_REQUEST["ads"])) ? urldecode($_REQUEST["ads"]) : "";
	$mon = (isset($_REQUEST["mon"])) ? $_REQUEST["mon"] : 0;
	$opc = (isset($_REQUEST["opc"])) ? $_REQUEST["opc"] : 0;
	switch ($opc) {
	        case 1: $opago = "ordinarias";  break;
	        case 2: $opago = "especiales";  break;
	        case 3: $opago = "combinado";  break;
	}

	$query = "SELECT cb_fecnac FROM #__comprofiler WHERE id = '" . $my->id . "' LIMIT 1";
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	$cumple = $db->loadResult();

	$file_socio = $raiz . $rdir . "PRE_CALCULO.TXT";

	$contenido = $ced . PHP_EOL . $dpm . PHP_EOL . $tip . PHP_EOL . $opc . PHP_EOL . $mon . PHP_EOL;
	$contenido .= (validaemail( $ema ) ? $ema : $my->email) . PHP_EOL;
	$contenido .= $cumple;

	escribir_archivo($file_socio, $contenido);

	$ejec = exec($raiz . $rdir . "ejec_pvx_censo calculo 2>&1");

	$filas = $raiz . $rdir . $ced . "_CALCULO.TXT";

	$cn = file_get_contents( trim($filas) );
//	$ln = explode(";", $cn);
        $ln = explode("\n", $cn);
//	var_dump($cn);

	verhtml($ced, $nom, $ema, $tel, $cue, $tip, $est, $sta, 
		$fec, $aso, $apt, $das, $dpt, $p80, $deu, $tpr, $cap,
		$taf, $caa, $dpm, $jpm, $dpd, $jpd, $cpr, $npr, $mainframe, $mon, $opc, $ads, 'Recalcular');

	if ( file_exists($filas) && count($ln) > 0 )
	{
//		unlink( $filas );
		$url = JURI::getInstance()->toString();
		$nco = 12;
		$ms1 = $nco . ' CUOTAS QUINCELANES';
		$nce = 1;
		$ms2 = $nce . ' CUOTA ESPECIAL';
		if (substr($tip,0,1) == 'O') {
			$nco = 24;
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
	                        <td align=center>
				<span>Al hacer click en el bot&oacute;n aceptar, confirma su participaci&oacute;n</span>
				<br><br>
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
		Favor, póngase en contacto con la administración de " . $mainframe->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $mainframe->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}
  }
  break;

default:
  if ( !empty($ced) )
  {
	$file_socio = $raiz . $rdir . "DISPONIBILIDAD.TXT";

	escribir_archivo($file_socio, $ced);

	$ejec = exec($raiz . $rdir . "ejec_pvx_censo disponibilidad 2>&1");

//	echo "paso... " . $s;
	$filas = $raiz . $rdir . $ced . "_DISPONIBILIDAD.TXT"; // archivo resultante de la info sistema procesa

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
		if ( $activo == 1 && empty($desact) ) {
			verhtml($cedula, $nombre, $correo, $telefo, $cuenta, $tipper, $status, $estado, 
				$fecact, $ahoaso, $ahopat, $deuaso, $deupat, $porc80, $deupre, $totpre, 
				$nropre, $totafi, $nroafi, $dpmont, $jpmont, $dpdesc, $jpdesc, 
				$codpro, $nompro, $mainframe);
		}
		else {
			echo "<p align=justify style='font-size:150%; line-height: 24px;'>
			Hola, <span style='font-weight:bold; text-transform: uppercase;'>" . $nom . " (C.I.: " . $ced . ")</span>;<br>
			usted no puede efectuar el proceso de pre-préstamo debido a la siguiente descripci&oacute;n:
			<br><br>" . $desact . "</p>";
			respdf ($cedula, $nompro);
		}
	}
	else {
		echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>,
		a fin de generar sus estados de cuenta como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $mainframe->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $mainframe->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}
  }
  break;
}

function verhtml($cedula, $nombre, $correo, $telefo, $cuenta, $tipper, $status, $estado, 
		$fecact, $ahoaso, $ahopat, $deuaso, $deupat, $porc80, $deupre, $totpre, 
		$nropre, $totafi, $nroafi, $dpmont, $jpmont, $dpdesc, $jpdesc, 
		$codpro, $nompro, $mainframe, $val = 0, $sel = 0, $aad = '0', $txtbot = 'Calcular')
{
		$bgc = 'bgcolor=#E6E6E6';
		$url = JURI::getInstance()->toString();

			echo "
<script>
function getHttpRequest() {
    var x;
    if (window.XMLHttpRequest) {
        x = new XMLHttpRequest();
    } else {// code for IE6, IE5
        x = new ActiveXObject('Microsoft.XMLHTTP');
    }
    return x;
}
function verOPC() {
//	var mo = document.getElementById('mon').value;
//	var op = document.getElementById('opc');
	var mo = document.getElementsByName('mon');
	var op = document.getElementsByName('opc');
	var ad = document.getElementsByName('ads');
	var ck = cm = false;
	var ca = (ad.options[ad.selectedIndex].value > 0) ? 1 : 0;

	for (var i = 0; i < mo.length; i++) {
	    if(mo[i].checked) {
	        cm = true;
	        break;
	    }
	}
	for (var i = 0; i < op.length; i++) {
	    if(op[i].checked) {
	        ck = true;
	        break;
	    }
	}
	aprob = false;
	if( !ck ) alert('Verifique el modo de pago seleccionado...');
	if( !cm ) alert('Seleccione el monto a solicitar...');
	if( !ca ) alert('Favor elija un área de adscripción...');
	if (ck == true && cm == true && ca == 1) { aprob = true; }
	return aprob;
}
function calculo(fe) {
/*    if (fe.ced.length == 0) { 
        document.getElementById('respuesta').innerHTML = '';
        return;
    } else 
*/
	if ( verOPC() ) {
	fe.submit();
/*
        var req = getHttpRequest();
        req.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
		fe.bot.value = 'Recalcular';
                document.getElementById('respuesta').innerHTML = this.responseText;
            }
        };
	req.open (fe.method, fe.action, true);
	req.send (new FormData(fe));
*/
    }
}
</script>

				<table width=100% height=100% border=0 cellspacing=0>
				  <tr>
					<td width=25% align=center>
						<img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
					</td>
					<td width=50% align=center>
					  <b>" . strtoupper( $mainframe->getCfg('MetaDesc') ) . "<br />
					  (" . strtoupper( $mainframe->getCfg('MetaKeys') ) . ")</b>
					  </td>
					<td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
					  <br>" . date("h:i:s a") . "
					</td>
				  </tr>
				  <tr>
					<td colspan=3 align=center>
					<hr width=95%>
					<h3>PROGRAMA: $nompro</h3>
					<hr width=95%>
					</td>
				  </tr>
				</table>
			
				<table width=90% height=100% border=0 cellspacing=0 align=center>
				  <tr>
					<td align=left>ASOCIADO: <b>" . number_format($cedula, -2, "," ,".") . "</b></td>
					<td align=left>$nombre</td>
					<td align=left>ESTADO:</td>
					<td align=left>$estado</td>
				  </tr>
				  <tr $bgc>
					<td align=left>CORREO ELECTRÓNICO:</td>
					<td align=left>$correo</td>
					<td align=left>TIPO DE PERSONAL: </td>
					<td align=left>$tipper</td>
				  </tr>
				  <tr>
					<td align=left>CUENTA BANCO:</td>
					<td align=left>$cuenta</td>
					<td align=left>FECHA ACTUAL:</td>
					<td align=left>$fecact</td>
				  </tr>
				  <tr $bgc>
					<td align=left>AHORRO ASOCIADO:</td>
					<td align=left>" . $ahoaso . "</td>
					<td align=left>AHORRO PATRONO:</td>
					<td align=left>" . $ahopat . "</td>
				  </tr>
				  <tr>
					<td align=left>DEUDA APORTE ASOCIADO:</td>
					<td align=left>" . $deuaso . "</td>
					<td align=left>DEUDA APORTE PATRONO:</td>
					<td align=left>" . $deupat . "</td>
				  </tr>
				  <tr $bgc>
					<td align=left>80% DISPONIBILIDAD:</td>
					<td align=left>" . $porc80 . "</td>
					<td align=left>DEUDA DE PRESTAMOS:</td>
					<td align=left>" . $deupre . "</td>
				  </tr>
				  <tr>
					<td align=left>TOTAL PRESTAMOS:</td>
					<td align=left>" . $totpre . " (" . $nropre . ")</td>
					<td align=left>TOTAL AFIANZAMIENTO:</td>
					<td align=left>" . $totafi . " (" . $nroafi . ")</td>
				  </tr>
				  <tr $bgc>
					<td align=left>DISPONE PRESTAMOS:</td>
					<td align=left>" . $dpmont . "</td>
					<td align=left>MAXIMO DE JORNADA:</td>
					<td align=left>" . $jpmont . "</td>
				  </tr>
				  <tr>
					<td align=left>CONDICION PRESTAMOS:</td>
					<td align=left>" . $dpdesc . "</td>
					<td align=left>ESTADO PARA JORNADA:</td>
					<td align=left>" . $jpdesc . "</td>
				  </tr>
				</table>
				";

				echo "
		<form id='fcal' method='post' action='".JRoute::_($url)."' onsubmit='return calculo(this);'>

		<table width=100% height=100% border=0 cellspacing=0 align=center>
		  <tr>
			<td align=center>
					<hr width=95%>
					<h5>AREA DE ADSCRIPCION:</h5>
			  <select name=ads id=ads>
				<option value=0" . (($aad=='0')?' selected': '') . ">- Seleccione -</option>
";
$j = 0;
foreach (buscadscripciones() as $row) {
	echo "<option " . ((strcmp($row[0],$aad)==0)?'selected':'') . " value=" . urlencode($row[0]) . ">" . $row[0] . "</option>";
}
echo "
			  </select>
			</td>
		  </tr>
		</table>
				<table width=100% height=100% border=0 cellspacing=0>
				  <tr>
					<td align=center>
					<hr width=95%>
					<h4>FORMA DE PAGO</h4>
					<span>" . ((substr($tipper,0,1)== 'O') ? '24 cuotas ordinarias semanales' : '12 cuotas ordinarias 
quincenales') . " y 1 especial</span>
					<hr width=95%>
					</td>
				  </tr>
				</table>
			  <input type=hidden name=nom value='" . $nombre . "'>
			  <input type=hidden name=ema value='" . $correo . "'>
			  <input type=hidden name=tel value='" . $telefo . "'>
			  <input type=hidden name=cue value='" . $cuenta . "'>
			  <input type=hidden name=tip value='" . $tipper . "'>
			  <input type=hidden name=est value='" . $status . "'>
			  <input type=hidden name=sta value='" . $estado . "'>
			  <input type=hidden name=aso value='" . $ahoaso . "'>
			  <input type=hidden name=apt value='" . $ahopat . "'>
			  <input type=hidden name=das value='" . $deuaso . "'>
			  <input type=hidden name=dpt value='" . $deupat . "'>
			  <input type=hidden name=p80 value='" . $porc80 . "'>
			  <input type=hidden name=deu value='" . $deupre . "'>
			  <input type=hidden name=tpr value='" . $totpre . "'>
			  <input type=hidden name=cap value='" . $nropre . "'>
			  <input type=hidden name=taf value='" . $totafi . "'>
			  <input type=hidden name=caa value='" . $nroafi . "'>
			  <input type=hidden name=dpm value='" . $dpmont . "'>
			  <input type=hidden name=dpd value='" . $dpdesc . "'>
			  <input type=hidden name=fec value='" . $fecact . "'>
			  <input type=hidden name=jpm value='" . $jpmont . "'>
			  <input type=hidden name=jpd value='" . $jpdesc . "'>
			  <input type=hidden name=cpr value='" . $codpro . "'>
			  <input type=hidden name=npr value='" . $nompro . "'>
			  <input type=hidden name=bot value='cal'>

		<table width=90% height=100% border=0 cellspacing=0 align=center>
		  <tr>
			<td align=center width=50%>
			MONTO REQUERIDO <br>
<!--
			  <input type=text name=mon id=mon value='" . $val . "' placeholder='Sólo digitos' style='width:80%'>
-->
<!--
			  <p><input type=radio name=mon value=30000 ". (($val == 30000)?'checked':'') ."/>30.000,00</p>
-->
			  <p><input type=radio name=mon value=75000 ". (($val == 75000)?'checked':'') ."/>75.000,00</p>
			  <p><input type=radio name=mon value=100000 ". (($val == 100000)?'checked':'') ."/>100.000,00</p>
			</td>
			<td align=center>
			MODO DE PAGO <br>
			  <p align=left><input type=radio name=opc value=1 ". (($sel == 1)?'checked':'') ."/>SOLO CUOTAS ORDINARIAS</p>
			  <p align=left><input type=radio name=opc value=2 ". (($sel == 2)?'checked':'') ."/>SOLO ESPECIALES</p>
			  <p align=left><input type=radio name=opc value=3 ". (($sel == 3)?'checked':'') ."/>COMBINADAS: 40% 
ordinarias + 60% 
especiales</p>
<!--
			  <select name=opc id=opc>
				<option ". (($sel == 0)?'selected':'') ." value=0>- Seleccione -</option>
				<option ". (($sel == 1)?'selected':'') ." value=1>SOLO CUOTAS ORDINARIAS</option>
				<option ". (($sel == 2)?'selected':'') ." value=2>SOLO ESPECIALES</option>
				<option ". (($sel == 3)?'selected':'') ." value=3>COMBINADAS: 40% ordinarias + 60% especiales</option>
			  </select>
-->
			</td>
		  </tr>
		  <tr>
			<td $bgc align=center colspan=2>
			  <input type=submit name=env value='" . $txtbot . "'>
			</td>
		  </tr>
		</table>
		</form>
		";
}

function validaemail($ema) {
        $ema = filter_var($ema, FILTER_SANITIZE_EMAIL);
        return (filter_var($ema, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
}

function planillas($ced) {
	$fpdf = "/home/pvx/" . $ced . "_";
	$searches = array(
		$fpdf . "PP.pdf",
		$fpdf . "RA.pdf",
		$fpdf . "TA_ANUA.pdf",
		$fpdf . "TA_QNAL.pdf",
		$fpdf . "TA_25EE.pdf",
		$fpdf . "ET.pdf"
	);
	return $searches;
}

function buscadscripciones() {
	$query = "SELECT B.fieldtitle FROM #__comprofiler_fields A, #__comprofiler_field_values B ";
	$query .= "WHERE A.fieldid = B.fieldid AND A.name = 'cb_localidad' ORDER BY B.ordering ASC";
	$db =& JFactory::getDBO();
	$db->setQuery($query);
	return $db->loadRowList();
}

function respdf ($ced, $npr) {
        $updf = "/home/web/ycapunefm/media/pdf_vacaciones/" . $ced . ".pdf";

        $pdf = JURI::base() . "media/pdf_vacaciones/" . $ced . ".pdf";

        if ( file_exists($updf) ) {

                        echo "
                <table width=100% height=100% border=0 cellspacing=0>
                  <tr>
                        <td width=25% align=center>
                                <img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
                        </td>
                        <td width=50% align=center>
                          <b>GRACIAS POR PARTICIPAR EN EL PROGRAMA <br>" . $npr . "</b>
                        </td>
                        <td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
                          <br>" . date("h:i:s a") . "
                        </td>
                  </tr>
                </table>

                  <br>
                <center>
                        <object width='640' height='480' internalinstanceid='25' type='application/pdf' data='" . $pdf . "'>
<iframe src='" . $pdf . "' style='border: none;' height='100%' width='100%'>
Este navegador no soporta lector de PDF. Por favor descargue el archivo mediante: <a href='http://www.capunefm.com.ve/media/pdf_vacaciones/" . $ced . ".pdf'>AQUI</a>
</iframe>
                        </object>
                        <br><br>
                        <a href='index.php?option=com_comprofiler&task=logout'>
                                <input type=button name=sesion value='Cerrar sesión'>
                        </a>
                </center>
                        ";
        }
}

?>
