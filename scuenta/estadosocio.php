<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe, $_SERVER;

// retrieve user instance
$my =& JFactory::getUser();

$ced = $_REQUEST["ced"]; // usuario de la consulta
$tip = $my->usertype; // tipo de usuario de la sesion activa

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
			<b>ASOCIADO " . strtoupper( $mainframe->getCfg('MetaKeys') ) . " </b>
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
	$raiz = "/srv/www/htdocs";
	$rdir = "/";
	$file_socio = $raiz . $rdir . "SOCIO.TXT";

	if ( file_exists($file_socio) ){
		unlink($file_socio);
	}

	touch ($file_socio);

	escribir_archivo($file_socio, $ced); // guardar id usuario para su lectura por procesa

	// mediante el id socio se consultan datos en procesa y se guarda en archivo texto

	$ejec = exec($raiz . $rdir . "ejec_pvx_nuevo 2>&1");

	//echo $s;

	$filas = $raiz . $rdir . $ced . ".TXT"; // archivo resultante de la info sistema procesa

	$cn = file_get_contents( trim($filas) );
	$ln = explode("\n", $cn);
//var_dump($ln);

	if ( file_exists($filas) && count($ln) > 0 )
	{
		unlink( $filas );
		$cedula = $nomape = $estaso = $tipper = $nroexp = $fecing = '';
		$ahoaso = $ahouni = $cuoaso = $cuouni = $p80aho = $ahovol = 0;
		$subhab = $cuovol = $deuaho = $deuuni = $tothab = $afianu = 0;
		$deupre = $facdeu = $monafi = $menfia = $monret = 0;
		$fecret = $notmor = $dispre = $disrph = '';
		$prestamo = array();
		$bgc = 'bgcolor=#E6E6E6';

		foreach ($ln as $tx)
		{
			$tx = trim( $tx );
			list($uno, $dos) = explode(";", $tx, 2);
			$arr = explode(";", $dos);

			if ( $uno == '01' ) {
				$cedula = $arr[0];
			}
//echo "dat: $uno - $arr[0] <br>";
			switch ( $uno ) {
			case '02':
				$nomape = $arr[0];
				break;
			case '03':
				$estaso = $arr[0];
				switch ($estaso) {
					case 'A':  $estaso = 'ACTIVO';      break;
					case 'J':  $estaso = 'JUBILADO';    break;
					default:   $estaso = 'NO DEFINIDO'; break;
				}
				break;
			case '04':
				$fecing = $arr[0];
				break;
			case '05':
				$ahoaso = $arr[0];
				break;
			case '06':
				$ahouni = $arr[0];
				break;
			case '07':
				$ahovol = $arr[0];
				break;
			case '08':
				$subhab = $arr[0];
				break;
			case '09':
				$deuaso = $arr[0];
				break;
			case '10':
				$deuuni = $arr[0];
				break;
			case '11':
				$tothab = $arr[0];
				break;
			case '12':
				$cuoaso = $arr[0];
				break;
			case '13':
				$cuouni = $arr[0];
				break;
			case '14':
				$cuovol = $arr[0];
				break;
			case '15':
				$tipper = $arr[0];
				break;
			case '16':
				$nroexp = $arr[0];
				break;
			case '17':
				$p80aho = $arr[0];
				break;
			case '18':
				$prestamo[] = $arr;
				break;
			case '19':
				$cuopre = $arr[0];
				break;
			case '20':
				$facdeu = $arr[0];
				break;
			case '21':
				$monafi = $arr[0];
				break;
			case '22':
				$menfia = $arr[0];
				break;
			case '23':
				$fecret = $arr[0];
				break;
			case '24':
				$monret = $arr[0];
				break;
			case '25':
				$notmor = $arr[0];
				break;
			case '26':
				$afianu = $arr[0];
				break;
			case '27':
				$dispre = $arr[0];
				break;
			case '28':
				$disrph = $arr[0];
				break;
			}
		}
		if ( !empty($cedula) && $cedula == $ced )
		{
			echo "
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
					<h3>ESTADO DE CUENTA</h3>
					<hr width=95%>
					</td>
				  </tr>
				</table>
			
				<table width=90% height=100% border=0 cellspacing=0 align=center>
				  <tr>
					<td align=left>ASOCIADO: <b>" . number_format($cedula, -2, "," ,".") . "</b>
					</td>
					<td align=left>$nomape</td>
					<td align=left>ESTADO:</td>
					<td align=left>$estaso</td>
				  </tr>
				  <tr $bgc>
					<td align=left>AHORRO ASOCIADO:</td>
					<td align=left>" . $ahoaso . "</td>
					<td align=left>APORTE ASOCIADO: </td>
					<td align=left>" . $cuoaso . "</td>
				  </tr>
				  <tr>
					<td align=left>AHORRO PATRONO:</td>
					<td align=left>" . $ahouni . "</td>
					<td align=left>APORTE PATRONAL: </td>
					<td align=left>" . $cuouni . "</td>
				  </tr>
				  <tr $bgc>
	                                <td>SUB-TOTAL HABERES: </td>
	                                <td align=left>" . $subhab . "</td>
	                                <td>FECHA DE INGRESO: </td>
	                                <td>" . $fecing . "</td>
        	                  </tr>
 				  <tr>
					<td align=left>(-) DEUDA AHORRO ASO.:</td>
					<td align=left>" . $deuaso . "</td>
					<td align=left>TIPO DE PERSONAL: </td>
					<td align=left>$tipper</td>
				  </tr>
				  <tr $bgc>
					<td align=left>(-) DEUDA APORTE PAT.:</td>
					<td align=left>" . $deuuni . "</td>
					<td align=left>NRO. EXPEDIENTE:</td>
					<td align=left>$nroexp</td>
				  </tr>
				  <tr>
					<td align=left>TOTAL HABERES:</td>
					<td align=left>" . $tothab . "</td>
					<td align=left>AHORRADO (80,00%):</td>
					<td align=left>" . $p80aho . "</td>
				  </tr>
				</table>
				";

				ver_prestamos($prestamo, $bgc);

				echo "
				<table width=95% height=100% border=0 cellspacing=0 align=center>
					<tr><td colspan=4 align=center><hr noshade></td></tr>
					<tr>
						<td width=36% align=right>(-) DEUDA CUOTAS DE PRESTAMOS UNEFM:</td>
						<td width=12% align=center>" . $cuopre . "</td>
						<td width=36% align=right>FACTOR DE ENDEUDAMIENTO:</td>
						<td width=12% align=center>" . $facdeu . "</td>
					  </tr>
				</table>
				";

				echo "
				<table width=95% height=100% border=0 cellspacing=0 align=center>
					<tr><td colspan=3 align=center><hr noshade></td></tr>
					<tr>
						<td width=60% align=right>AFIANZADO POR:</td>
						<td width=20% align=right>" . $monafi . "</td>
						<td width=20% align=center></td>
					</tr>
					<tr>
						<td width=60% align=right>MENOS FIANZA DE:</td>
						<td width=20% align=right>" . $menfia . "</td>
						<td width=20% align=center></td>
					</tr>
					<tr>
						<td width=60% align=right>FECHA ULTIMO RETIRO:</td>
						<td width=20% align=right>" . $fecret . "</td>
						<td width=20% align=center></td>
					</tr>
					<tr>
						<td width=60% align=right>MONTO ULTIMO RETIRO:</td>
						<td width=20% align=right>" . $monret . "</td>
						<td width=20% align=center></td>
					</tr>
					<tr><td colspan=3 align=center><hr noshade></td></tr>
				</table>
				";

				echo "
				<table width=95% height=100% border=0 cellspacing=0 align=center>
				";
				if ( !empty($notmor) ) {
				echo "
					<tr>
						<td align=center colspan=2>" . $notmor . "</td>
					</tr>
				";
				}
				echo "
					<tr>
						<td width=60% align=right>AFIANZADO POR AFIANAUCO:</td>
						<td width=40% align=right>" . $afianu . "</td>
					</tr>
					<tr>
						<td width=60% align=right>DISPONIBILIDAD PARA PRESTAMOS:</td>
						<td width=40% align=right>" . $dispre . "</td>
					</tr>
					<tr>
						<td width=60% align=right>DIPONIBILIDAD PARA RETIRO PARCIAL:</td>
						<td width=40% align=right>" . $disrph . "</td>
					</tr>
				</table>
				";
////			}
		}
		else
		{
			echo "<p align=justify>Existe un <b><i>error en la consulta</i></b> de sus datos básicos
			para generar sus estados de cuenta como asociado de la Caja de Ahorros
			<br>(Usuario: <b>$ced</b> - Nombre y Apellido: <b>" . $nomape . "</b>)
			<br><br>
			Favor, póngase en contacto con la administración de " . $mainframe->getCfg('MetaKeys') . "
			vía telefónica, o envíe un e-mail a " . $mainframe->getCfg('mailfrom') . ", a fin de 
			convalidar sus datos con el sistema, a la brevedad posible</p>";
		}
	}
	else
	{
		echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>,
		a fin de generar sus estados de cuenta como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $mainframe->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $mainframe->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}

} // fin - al consultar un asociado

function ver_prestamos($prestamo, $bgc)
{
		if ( count($prestamo) > 0 )
		{
			echo "
				<table width=100% height=100% border=0 cellspacing=0>
				  <tr>
					<td align=center>
					<hr width=95%>
					<h4>PRÉSTAMOS</h4>
					<hr width=95%>
					</td>
				  </tr>
				</table>

				<table width=95% height=100% border=0 cellspacing=0 align=center>
				  <tr bgcolor=#CCCCCC>
					<td align=left width=26%><strong>TIPO DE PRÉSTAMO</strong></td>
					<td align=center width=8%><strong>FECHA</strong></td>
					<td align=right width=12%><strong>MONTO</strong></td>
					<td align=right width=7%><strong>NRO.<br>CUO.</strong></td>
					<td align=right width=8%><strong>MON.<br>CUO.</strong></td>
					<td align=right width=6%><strong></strong></td>
					<td align=right width=7%><strong>NRO.<br>ESP.</strong></td>
					<td align=right width=8%><strong>MON.<br>ESP.</strong></td>
					<td align=right width=12%><strong>SALDO</strong></td>
					<td align=right width=6%><strong></strong></td>
			";
			
			foreach ($prestamo AS $i => $j)
			{
				$bgp = ($i % 2 == 0) ? '' : $bgc;
				$desprest = $j[0];
				$fecprest = $j[1];
				$monprest = $j[2];
				$nrcuotas = $j[3];
				$moncuota = $j[4];
				$forcuota = $j[5];
				$nrespeci = $j[6];
				$monespec = $j[7];
				$salprest = $j[8];
				$salespec = $j[9];
				if ( empty($nrcuotas) ) $nrcuotas = '-';
				if ( empty($moncuota) ) $moncuota = 0;
				if ( empty($nrespeci) ) $nrespeci = '-';
				if ( empty($monespec) ) $monespec = 0;

				if ( $moncuota >= 0 ) {
					echo "
					  <tr $bgp>
						<td align=left>$desprest</td>
						<td align=center>$fecprest</td>
						<td align=right>" . $monprest . "&nbsp;</td>
						<td align=right>$nrcuotas</td>
						<td align=right>" . $moncuota . "</td>
						<td align=right>$forcuota</td>
						<td align=right>$nrespeci</td>
						<td align=right>" . $monespec . "</td>
						<td align=right>" . $salprest . "</td>
						<td align=right>$salespec</td>
					  </tr>       
					";
				}  // se imprimen aquellos prestamos con valor en la cuota...
			}
			echo "
				</table>         
			";
		}
}

function escribir_archivo($nombre_archivo, $contenido)
{
   if (is_writable($nombre_archivo)) {

    	if (!$gestor = fopen($nombre_archivo, 'a')) {
         	echo "No se puede abrir el archivo ($nombre_archivo)";
         	exit;
    	}

    	if (fwrite($gestor, $contenido) === FALSE) {
        	echo "No se puede escribir al archivo ($nombre_archivo)";
        	exit;
    	}

//    	echo "Exito, se escribió ($contenido) al archivo ($nombre_archivo)";

    	fclose($gestor);
    	
    	chmod($nombre_archivo, 0777); 	// cambiando los permisos

   } else {
    	echo "No se puede escribir sobre el archivo $nombre_archivo";
   }
}

?>
