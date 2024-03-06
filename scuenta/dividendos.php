<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;

// retrieve user instance
$my =& JFactory::getUser();

$ced = ($my->id) ? $my->username : ""; // usuario de la sesion activa
$nom = ($my->id) ? $my->name : "No identificado"; // usuario de la sesion activa

////////////////////////////////////

if (!function_exists('verdiv'))
{
 function verdiv($ruta, $anyo, $actual, $app, $ced, $nom) {

   $lee_archivo = 0;

   if ( file_exists($ruta) )
   {
	$lee_archivo = 1;

	$bgc = 'bgcolor=#E6E6E6';

	$cn = file( trim($ruta) );

	foreach ($cn AS $l0 => $t0)
	{
		$r = stristr($t0, $ced);
		if ( $r ) $dbasico[$t0] = $l0;
	}
	if ( count($dbasico) > 0 )
	{
		foreach ($dbasico AS $p0 => $j0)
		{
			list($cedula, $monto) = explode(";", $p0);

			echo "<table width=100% height=100% border=0 cellspacing=0>";

			if ($anyo == $actual)
			{
			 echo "
			  <tr>
				<td width=25% align=center>
					<img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
				</td>
				<td width=50% align=center>
				  <b>" . strtoupper( $app->getCfg('MetaDesc') ) . "<br />
				  (" . strtoupper( $app->getCfg('MetaKeys') ) . ")</b>
				  </td>
				<td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
				  <br>" . date("h:i:s a") . "
				</td>
			  </tr>
			 ";
			}
			echo "
			  <tr>
				<td colspan=3 align=center>
				<hr width=95%>
				<h4>ESTADO DE DIVIDENDO " . $anyo . "</h4>
				<hr width=95%>
				</td>
			  </tr>
			</table>
			<table width=90% height=100% border=0 cellspacing=0 align=center>
			  <tr $bgc>
				<td align=left>ASOCIADO: <b>" . number_format($cedula, -2, "," ,".") . "</b></td>
				<td align=left>" . mb_strtoupper($nom, 'UTF-8') . "</td>
				<td align=left>DIVIDENDO:</td>
				<td align=left>$monto</td>
			  </tr>
			</table>
			";

		}
	}
	else
	{
		echo "<p align=justify>Existe un <b><i>error en la consulta</i></b> de sus datos básicos
		para generar su <b>estado de dividendo " . $y_anterior . "</b> como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . " 
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}
   }

   if ( !$lee_archivo && ($anyo != $actual) )
   {
	echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>,
	a fin de generar su <b>estado de dividendo</b> como afiliado de la Caja de Ahorros
	<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
	<br><br>
	Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . " 
	vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
	solventar su caso a la brevedad posible</p>";
   }
 }
}

////////////////////////////////////

$raiz = "/home/web";
$sweb = "/jcapunefm/images/dividendos";
$rdir = "/";

$y_actual = date("Y") - 1;
$y_anterior = $y_actual - 1;
$y_antesterior = $y_actual - 2;

$div_actual = $raiz . $sweb . $rdir . "dividendos" . $y_actual . ".txt";
$div_anterior = $raiz . $sweb . $rdir . "dividendos" . $y_anterior . ".txt";
$div_antesterior = $raiz . $sweb . $rdir . "dividendos" . $y_antesterior . ".txt";

verdiv($div_actual, $y_actual, $y_actual, $app, $ced, $nom);
//verdiv($div_anterior, $y_anterior, $y_actual, $app, $ced, $nom);
//verdiv($div_antesterior, $y_antesterior, $y_actual, $app, $ced, $nom);

/*

if ( file_exists($div_actual) )
{
	$lee_archivo = 1;

	$bgc = 'bgcolor=#E6E6E6';

	$cn = file( trim($div_actual) );

	foreach ($cn AS $l0 => $t0)
	{
		$r = stristr($t0, $ced);
		if ( $r ) $dbasico[$t0] = $l0;
	}
	if ( count($dbasico) > 0 )
	{
		foreach ($dbasico AS $p0 => $j0)
		{
			list($cedula, $monto) = explode(";", $p0);

			echo "
			<table width=100% height=100% border=0 cellspacing=0>
			  <tr>
				<td width=25% align=center>
					<img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
				</td>
				<td width=50% align=center>
				  <b>" . strtoupper( $app->getCfg('MetaDesc') ) . "<br />
				  (" . strtoupper( $app->getCfg('MetaKeys') ) . ")</b>
				  </td>
				<td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
				  <br>" . date("h:i:s a") . "
				</td>
			  </tr>
			  <tr>
				<td colspan=3 align=center>
				<hr width=95%>
				<h3>ESTADO DE DIVIDENDO " . $y_actual . "</h3>
				<hr width=95%>
				</td>
			  </tr>
			</table>
			<table width=90% height=100% border=0 cellspacing=0 align=center>
			  <tr $bgc>
				<td align=left>ASOCIADO: <b>" . number_format($cedula, -2, "," ,".") . "</b></td>
				<td align=left>" . mb_strtoupper($nom, 'UTF-8') . "</td>
				<td align=left>DIVIDENDO:</td>
				<td align=left>$monto</td>
			  </tr>
			</table>
			";

		}
	}
	else
	{
		echo "<p align=justify>Existe un <b><i>error en la consulta</i></b> de sus datos básicos
		para generar su <b>estado de dividendo " . $y_actual . "</b> como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . " 
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}
}
*/

?>
