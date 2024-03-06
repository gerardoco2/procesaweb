<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

global $mainframe, $_SERVER;

// retrieve user instance
$my =& JFactory::getUser();

$ced = ($my->id) ? $my->username : ""; // usuario de la sesion activa
$nom = ($my->id) ? $my->name : "No identificado"; // usuario de la sesion activa

////////////////////////////////////

//$raiz = $_SERVER["DOCUMENT_ROOT"];

$raiz = "/srv/www/htdocs";
$rdir = "/";

$file_socio = $raiz . $rdir . "SOCIO.TXT";

if ( file_exists($file_socio) ){
	unlink($file_socio);
//	exec("rm " . $file_socio);
}

touch ($file_socio);

escribir_archivo($file_socio, $ced); // guardar id usuario para su lectura por procesa

// mediante el id socio se consultan datos en procesa y se guarda en archivo texto

//$file_datos = $raiz . $rdir . "DATOS.TXT";

//if ( file_exists($file_datos) )  @unlink($file_datos);

/*touch ($file_datos);

@chgrp($file_socio, "procesa");
@chown($file_socio, "procesa");
@chmod($file_socio, 0777);
*/

//echo exec("ls -l"); 

//$ejec = shell_exec("sudo chown root:root " . $file_socio . " &> /dev/null"); 

$ejec = exec($raiz . $rdir . "ejec_pvx"); 

//$ejec = shell_exec("/home/pvxfull/pvx /home/pvx/procesa/RU_VERIF &> /dev/null"); 

//$ejec = shell_exec("/home/pvxfull/pvx /home/pvx/procesa/RU_VERIF"); 

$filas = $raiz . $rdir . "DATOS.TXT"; // archivo resultante de la info sistema procesa

$cn = file( trim($filas) );

if ( file_exists($filas) )
{
	$bgc = 'bgcolor=#E6E6E6';
	
	$o1 = 'P/';
	$o2 = 'F/';
	$o3 = 'FA/';
	$o4 = 'D/';

	foreach ($cn AS $l0 => $t0)
	{
		$r = stristr($t0, $ced);
		if ( $r ) $dbasico[$t0] = $l0;
	}
	if ( count($dbasico) > 0 )
	{
		foreach ($cn AS $l1 => $t1)
		{
			$r1 = stristr($t1, $o1);
			if ( $r1 ) $prestamo[$t1] = $l1;
		}
		foreach ($cn AS $l2 => $t2)
		{
			$r2 = stristr($t2, $o2);
			if ( $r2 )  $fiador[$t2] = $l2;
		}
		foreach ($cn AS $l3 => $t3)
		{
			$r3 = stristr($t3, $o3);
			if ( $r3 )  $afianzado[$t3] = $l3;
		}
		foreach ($cn AS $l4 => $t4)
		{
			$r4 = stristr($t4, $o4);
			if ( $r4 )  $disponible[$t4] = $l4;
		}

		foreach ($dbasico AS $p0 => $j0)
		{
			list($cedula, $nombres, $status, $aporteS, $aporteP, $tipotrab, $expedient,
				$fecharet, $montoret, $saldoAS, $saldoAP, $saldoRE,
				$deudaAS, $deudaAP, $totalhaberes, $dispon, $fechaing) = explode("/", $p0);

			switch ($status)
			{
				case 'A':	$status = 'ACTIVO';		break;
				case 'J':	$status = 'JUBILADO';		break;
				default:	$status = 'NO DEFINIDO';	break;
			}
			
			if ( !strpos($fechaing, '-') )
			{
				$fechaing = substr($fechaing,0,2) . "-" . substr($fecharing,2,2) . "-" . substr($fechaing,-4);
			}
			$fechaing = ($fechaing === '') ? '------' : $fechaing;

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
				<td align=left>ASOCIADO: <b>" . number_format($cedula, -2, "," ,".") . "</b></td>
				<td align=left>$nombres</td>
				<td align=left>ESTADO:</td>
				<td align=left>$status</td>
			  </tr>
			  <tr $bgc>
				<td align=left>AHORRO ASOCIADO:</td>
				<td align=left>" . number_format(abs($saldoAS), 2, "," ,".") . "</td>
				<td align=left>APORTE ASOCIADO: </td>
				<td align=left>" . number_format(abs($aporteS), 2, "," ,".") . "</td>
			  </tr>
			  <tr>
				<td align=left>AHORRO PATRONO:</td>
				<td align=left>" . number_format(abs($saldoAP), 2, "," ,".") . "</td>
				<td align=left>APORTE PATRONAL: </td>
				<td align=left>" . number_format(abs($aporteP), 2, "," ,".") . "</td>
			  </tr>
			  <tr $bgc>
				<td>SUBTOTAL HABERES: </td>
				<td align=left>" . number_format($saldoRE, 2, "," ,".") . "</td>
				<td>FECHA DE INGRESO: </td>
				<td>" . $fechaing . "</td>
			  </tr>
			  <tr>
				<td align=left>MENOS DEUDA APORTE ASO.:</td>
				<td align=left>" . number_format($deudaAS, 2, "," ,".") . "</td>
				<td align=left>TIPO DE PERSONAL: </td>
				<td align=left>$tipotrab</td>
			  </tr>
			  <tr $bgc>
				<td align=left>MENOS DEUDA APORTE PAT.:</td>
				<td align=left>" . number_format($deudaAP, 2, "," ,".") . "</td>
				<td align=left>NRO. EXPEDIENTE:</td>
				<td align=left>$expedient</td>
			  </tr>
			  <tr>
				<td align=left>TOTAL HABERES:</td>
				<td align=left>" . number_format(abs($totalhaberes), 2, "," ,".") . "</td>
				<td align=left>AHORRADO (80,00%):</td>
				<td align=left>" . number_format(abs($dispon), 2, "," ,".") . "</td>
			  </tr>
			</table>
			";
			ver_prestamos($prestamo);
			ver_fiadores($fiador);
			ver_afianzados($afianzado);

			if ( !strpos($fecharet, '-') )
			{
				$fecharet = substr($fecharet,0,2) . "-" . substr($fecharet,2,2) . "-" . substr($fecharet,-4);
			}
			$fecharet = ($fecharet === '') ? '------' : $fecharet;			

			echo "
		    <table width=95% height=100% border=0 cellspacing=0 align=center>
			  <tr><td colspan=3 align=center><hr noshade></td></tr>
			  <tr>
				<td width=60% align=right>Fecha de último retiro:</td>
				<td width=20% align=right>" . $fecharet . "</td>
				<td width=20% align=center></td>
			  </tr>
			  <tr>
				<td width=60% align=right>Monto de último retiro:</td>
				<td width=20% align=right>" . number_format(abs($montoret), 2, "," ,".") . "</td>
				<td width=20% align=center></td>
			  </tr>
			  <tr><td colspan=3 align=center><hr noshade></td></tr>
			</table>
			";

			ver_disponible($disponible);
		}
	}
	else
	{
		echo "<p align=justify>Existe un <b><i>error en la consulta</i></b> de sus datos básicos
		para generar sus estados de cuenta como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $mainframe->getCfg('MetaKeys') . " 
		vía telefónica, o envíe un e-mail a " . $mainframe->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
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

function ver_prestamos($prestamo)
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

				<table width=90% height=100% border=0 cellspacing=0 align=center>
				  <tr bgcolor=#CCCCCC>
					<td align=left width=30%><strong>TIPO DE PRÉSTAMO</strong></td>
					<td align=center width=10%><strong>FECHA</strong></td>
					<td align=right width=15%><strong>MONTO</strong></td>
					<td align=right width=10%><strong>NRO</strong></td>
					<td align=right width=10%><strong>CUOTA</strong></td>
					<td align=right width=15%><strong>SALDO</strong></td>
			";
			
			$i = 0;
			foreach ($prestamo AS $p1 => $j1)
			{
				$bgp = ($i % 2 == 0) ? '' : $bgc;
				
				list($ppb, $desprest, $fecprest, $monprest, 
					$nrcuotas, $moncuota, $salprest) = explode("/", $p1);
					
				$desprest = ucwords(strtolower($desprest));

				if ( empty($nrcuotas) ) $nrcuotas = '-';
				if ( empty($moncuota) ) $moncuota = 0;

				if ( $moncuota >= 0 ) {
					echo "
					  <tr $bgp>
						<td align=left>$desprest</td>
						<td align=center>$fecprest</td>
						<td align=right>" . number_format($monprest, 2, "," ,".") . "&nbsp;</td>
						<td align=right>$nrcuotas</td>
						<td align=right>" . number_format($moncuota, 2, "," ,".") . "</td>
						<td align=right>" . number_format($salprest, 2, "," ,".") . "</td>
					  </tr>       
					";
				}  // se imprimen aquellos prestamos con valor en la cuota...

				$i++;
			}
			echo "
				</table>         
			";
		}
}

function ver_fiadores($fiador)
{
		if ( count($fiador) > 0 )
		{
			echo "
			<table width=100% height=100% border=0 cellspacing=0>
			<tr>
				<td align=center>
				<hr width=95%>
				<h4>FIADORES</h4>
				<hr width=95%>
				</td>
			</tr>
			</table>

			<table width=90% height=100% border=0 cellspacing=0 align=center>
			  <tr bgcolor=#CCCCCC>
				<td align=center width=20%><strong>CEDULA</strong></td>
				<td align=center width=50%><strong>APELLIDOS Y NOMBRES</strong></td>
				<td align=center width=30%><strong>SALDO</strong></td>
			";
			
			$i = 0;
			foreach ($fiador AS $p2 => $j2)
			{
				$bgp = ($i % 2 == 0) ? '' : $bgc;
				
				list($ppb, $cedula, $nombre, $fianza) = explode("/", $p2);

				echo "
				  <tr $bgp>
					<td align=left>$cedula</td>
					<td align=center>$nombre</td>
					<td align=center>" . number_format($fianza, 2, "," ,".") . "</td>
				  </tr>       
				";
				$i++;
			}
			echo "
				</table>         
			";
		}
}

function ver_afianzados($afianzado)
{
		if ( count($afianzado) > 0 )
		{
			echo "
			<table width=100% height=100% border=0 cellspacing=0 align=center>
			<tr>
				<td align=center>
				<hr width=95%>
				<h4>AFIANZADOS</h4>
				<hr width=95%>
				</td>
			</tr>
			</table>

			<table width=90% height=100% border=0 cellspacing=0 align=center>
			  <tr bgcolor=#CCCCCC>
				<td align=center width=20%><strong>CEDULA</strong></td>
				<td align=center width=50%><strong>APELLIDOS Y NOMBRES</strong></td>
				<td align=center width=30%><strong>SALDO</strong></td>
			";
			
			$i = 0;
			foreach ($afianzado AS $p3 => $j3)
			{
				$bgp = ($i % 2 == 0) ? '' : $bgc;
				
				list($ppb, $cedula, $nombre, $fianza) = explode("/", $p3);

				echo "
				  <tr $bgp>
					<td align=left>$cedula</td>
					<td align=center>$nombre</td>
					<td align=center>" . number_format($fianza, 2, "," ,".") . "</td>
				  </tr>       
				";
				$i++;
			}
			echo "
				</table>         
			";
		}
}

function ver_disponible($disponible)
{
		foreach ($disponible AS $p4 => $j4)
		{
			list($p, $deuda, $dispopre, $msj1, $disporet, $msj2) = explode("/", $p4);
			
			echo "
		    <table width=95% height=100% border=0 cellspacing=0 align=center>
			  <tr>
				<td width=55% align=right>Disponibilidad para Préstamos:</td>
				<td width=20% align=right>" . number_format(abs($dispopre), 2, "," ,".") . "</td>
				<td width=20% align=center><font size=1>" . $msj1 . "</font></td>
			  </tr>
			  <tr>
				<td width=55% align=right>Disponibilidad para Retiro Parcial de Haberes:</td>
				<td width=20% align=right>" . number_format(abs($disporet), 2, "," ,".") . "</td>
				<td width=20% align=center><font size=1>" . $msj2 . "</font></td>
			  </tr>
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
    	
//    	@chgrp($nombre_archivo, "procesa");
    	chmod($nombre_archivo, 0777); 	// cambiando los permisos
//    	chown($path, $user_name);

//    	@chown($nombre_archivo, "procesa");

//	shell_exec("/bin/chown -R procesa:procesa /home/usupvx");

	} else {
    	echo "No se puede escribir sobre el archivo $nombre_archivo";
	}
}

?>
