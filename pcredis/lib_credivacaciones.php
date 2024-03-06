<?php

class Libcredivacaciones {

public static $txread = "CREDIVACACIONES";
public static $ejepvx = "credivacaciones";
// md5(credivacaciones2018) = a950bc1b538ff2435b7984f9564aafd9
public static $pdfpat = "a950bc1b538ff2435b7984f9564aafd9";

public static function getCredito() {
	return self::$txread;
}

public static function getEjecpvx() {
	return self::$ejepvx;
}

public static function getRutapdf() {
	return self::$pdfpat;
}

public static function verhtml($cedula, $nombre, $correo, $telefo, $cuenta, $tipper, $status, $estado, 
                $fecact, $ahoaso, $ahopat, $deuaso, $deupat, $porc80, $deupre, $totpre, 
                $nropre, $totafi, $nroafi, $dpmont, $jpmont, $dpdesc, $jpdesc, 
                $codpro, $nompro, $app, $val = 0, $sel = 0, $aad = '0', $txtbot = 'Calcular')
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
//      var mo = document.getElementById('mon').value;
//      var op = document.getElementById('opc');
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
        if ( verOPC() ) {
                fe.submit();
        }
}
</script>

<div class='table-responsive'>
                                <table class='table'>
                                  <tr>
                                        <td width=25%>
						<p class='text-center'>
                                                <img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
						</p>
                                        </td>
                                        <td width=50%>
                                          <p class='text-center'>" . strtoupper( $app->getCfg('MetaDesc') ) . "</p>
                                          <p class='text-center'>(" . strtoupper( $app->getCfg('MetaKeys') ) . ")</p>
                                          </td>
                                        <td width=25% valign=bottom>
					  <p class='text-right'>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "</p>
                                          <p class='text-right'>" . date("h:i:s a") . "</p>
                                        </td>
                                  </tr>
                                  <tr>
                                       <td colspan=3>
                                        <hr width=95%>
                                        <h3 class='text-center'>PROGRAMA: $nompro</h3>
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
                <form id='fcal' method='post' action='".JRoute::_($url)."' onsubmit='return calculo(this);' enctype='multipart/form-data'>

                <table width=100% height=100% border=0 cellspacing=0 align=center>
                  <tr>
                        <td>
                                        <hr width=95%>
                                        <h5 class='text-left'>AREA DE ADSCRIPCION:</h5>
                          <select name=ads id=ads style='text-align:center'>
                                <option value=0" . (($aad=='0')?' selected': '') . ">- Seleccione -</option>
								";
$j = 0;
foreach (self::buscadscripciones() as $row) {
        echo "<option " . ((strcmp($row[0],$aad)==0)?'selected':'') . " value=" . urlencode($row[0]) . ">" . $row[0] . "</option>";
}

$txttippag = (substr($tipper,0,1)== 'O') ? '25 cuotas semanales' : '10 cuotas quincenales';
$txttippag = strtoupper($txttippag);

echo "
                          </select>
                        </td>
                  </tr>
                </table>

                                <table width=100% height=100% border=0 cellspacing=0>
                                  <tr>
                                        <td align=center>
                                        <hr width=95%>
                                        <h4>Documentos a consignar al correo crediwebcapunefm@gmail.com</h4>
					<ul type='circle'>
						<li>Copia de cédula de identidad vigente</li>
						<li>Copia de RIF vigente</li>
						<li>Nómina actualizada</li>
						<li>Contrato de adhesión</li>
					</ul>
                                        <hr width=95%>
                                        </td>
                                  </tr>
                                </table>

                                <table width=100% height=100% border=0 cellspacing=0>
                                  <tr>
                                        <td align=center>
                                        <hr width=95%>
                                        <h4>FORMA DE PAGO</h4>
<!--                                    <span>" . $txttippag . " y 2 especiales</span><br>-->
                                        <span><i>
                                                * Esta solicitud no garantiza el otorgamiento del préstamo.
                                                El mismo esta sujeto a revisión de la documentación a consignar
	                                        </i></span>
                                        <hr width=95%>
                                        </td>
                                  </tr>
                                </table>
                          <input type=hidden name=ced value='" . $cedula . "'>
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
                          <p><input type=radio name=mon value=2500000 ". (($val == 2500000)?'checked':'') ."/>2.500.000,00</p>
                        </td>
                        <td align=center>
                        MODO DE PAGO <br>
<!--
                          <p align=left><input type=radio name=opc value=1 ". (($sel == 1)?'checked':'') ."/>SOLO CUOTAS ORDINARIAS</p>
-->
                          <p align=left><input type=radio name=opc value=2 ". (($sel == 2)?'checked':'') ."/>SOLO ESPECIALES</p>
<!--
                          <p align=left><input type=radio name=opc value=3 ". (($sel == 3)?'checked':'') ."/>COMBINADOS</p>
-->
                        </td>

                  </tr>
                  <tr>
                        <td $bgc colspan=2>
			<p class='text-center'>
                          <input type=submit name=env value='" . $txtbot . "'>
			</p>
                        </td>
                  </tr>
                </table>
                </form>
</div>
       ";
}

public static function validaemail($ema) {
        $ema = filter_var($ema, FILTER_SANITIZE_EMAIL);
        return (filter_var($ema, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
}

public static function datusuario($ced) {
        $query = "SELECT A.cb_fecnac, B.email FROM #__comprofiler A, #__users B WHERE A.id = B.id AND B.username = '" . $ced . "' LIMIT 1";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadRow();
}

public static function contratoadhesion($ced) {
        $query = "SELECT A.cb_contratoadhesion FROM #__comprofiler A, #__users B WHERE A.id = B.id AND B.username = '" . $ced . "' LIMIT 1";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
	$re = $db->loadRow();
//print_r($re);
        return $re[0];
}

public static function planillas($ced) {
        $fpdf = "/home/pvx/" . $ced . "_";
        $prog = "_" . self::$txread . ".pdf";
        $searches = array(
                $fpdf . "PP" . $prog,
                $fpdf . "RA" . $prog,
//                $fpdf . "TA_ANUA" . $prog,
//                $fpdf . "TA_QNAL" . $prog,
//                $fpdf . "TA_25EE" . $prog,
                $fpdf . "ET" . $prog
        );
        return $searches;
}

public static function planillas2($ced) {
        $fpdf = "/home/pvx/planillas_faltantes/" . $ced . "_";
        $prog = "_" . self::$txread . ".pdf";
        $searches = array(
                $fpdf . "PP" . $prog,
                $fpdf . "RA" . $prog,
//                $fpdf . "TA_ANUA" . $prog,
//                $fpdf . "TA_QNAL" . $prog,
//                $fpdf . "TA_25EE" . $prog,
                $fpdf . "ET" . $prog
        );
        return $searches;
}

public static function buscadscripciones() {
        $query = "SELECT B.fieldtitle FROM #__comprofiler_fields A, #__comprofiler_field_values B ";
        $query .= "WHERE A.fieldid = B.fieldid AND A.name = 'cb_localidad' ORDER BY B.ordering ASC";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadRowList();
}

public static function respdf($ced, $npr) {
        $dpdf = "pdfs/" . self::$pdfpat . "/";
        $fpdf = "/home/web/jcapunefm/" . $dpdf . $ced . ".pdf";

        $updf = JURI::base() . $dpdf . $ced . ".pdf";
//echo $updf;
        if ( file_exists($fpdf) ) {

                        echo "
                <table width=100% height=100% border=0 cellspacing=0>
                  <tr>
                        <td width=25% align=center>
                                <img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
                        </td>
                        <td width=50% align=center>
                          <strong class='text-center'>GRACIAS POR PARTICIPAR EN EL PROGRAMA <br>" . $npr . "</strong>
                        </td>
                        <td width=25% valign=bottom align=right>" . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "
                          <br>" . date("h:i:s a") . "
                        </td>
                  </tr>
                </table>

                  <br>
                <center>
		";
		echo "{pdf=" . $updf . "|100%|500}";
/***
echo "
                        <object width='640' height='480' internalinstanceid='25' type='application/pdf' data='" . $updf . "'>
<iframe src='" . $updf . "' style='border: none;' height='100%' width='100%'>
Este navegador no soporta lector de PDF. Por favor descargue el archivo mediante: <a href='" . $updf . "'>AQUI</a>
</iframe>
                        </object>
	";
***/
echo "
                        <br><br>
                        <a href='index.php?option=com_comprofiler&task=logout'>
                                <input type=button name=sesion value='Cerrar sesión'>
                        </a>
                </center>
                        ";
        }
}

public static function cumpleanos($id) {
        $query = "SELECT cb_fecnac FROM #__comprofiler WHERE id = '" . $id . "' LIMIT 1";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadResult();
}

public static function str_to_utf8($str) {
        if (mb_detect_encoding($str, 'UTF-8', true) === false) {
                $str = utf8_encode($str);
        }
        return $str;
}

public static function mostraryfinalizar($url, $ced, $npr) {
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
                               DOCUMENTOS A ESCANEAR y enviar a crediwebcapunefm@gmail.com
				<ul>
					<li>Solicitud de Préstamo</li>
					<li>Compromiso de pago</li>
					<li>Afianauco (si lo requiere)</li>
					<li>Etiqueta </li>
					<li>Contrato de adhesión</li>
				</ul>
                                <br>
                                ESPERAR JORNADA DE RECOLECCION DE SOLICITUDES EN EL AREA 
                                CORRESPONDIENTE SEGUN CRONOGRAMA PUBLICADO PREVIAMENTE
                                <br>
                                <p class='text-center'>
                                <input type=hidden name=ced value='$ced'>
                                <input type=hidden name=npr value='$npr'>
                                <input type=hidden name=bot value='lnk'>
                                <input type=submit name=ace value='MOSTRAR PLANILLAS Y FINALIZAR'>
                                </p>
                        </h4>
                        <hr width=95%>
                        </td>
                  </tr>
                </table>
                </form>
        ";
}

public static function aceptaryprocesar($ced, $raiz, $rdir, $url, $docr) {

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
        $ads = (isset($_REQUEST["ads"])) ? $_REQUEST["ads"] : "";
        $ads = self::str_to_utf8( urldecode($ads) );

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
        $contenido .= $ads . PHP_EOL;
//        $contenido .= $ema . PHP_EOL;
        $contenido .= count(glob("/srv/www/htdocs/DEF_" . self::$txread . "_*.TXT"));

//        $contenido .= date("h:i:sa");

        $file_socio = $raiz . $rdir . "DEFINITIVO_" . self::$txread . ".TXT";
        escribir_archivo($file_socio, $contenido);

//ob_start();
        $ejec = exec($raiz . $rdir . "ejec_pvx_" . self::$ejepvx . " definitivo 2>&1");
//echo "ejecutando definitivo " . date("h:i:sa") . "<br>";

        $file_socio = $raiz . $rdir . "DEF_" . self::$txread . "_".$ced.".TXT";
        escribir_archivo($file_socio, $contenido);

//ob_end_clean();
//        $ejec = exec($raiz . $rdir . "ejec_pvx_credivacaciones resta 2>&1");
//echo "ejecutando resta definitivo " . date("h:i:sa") . "<br>";

        $searches = self::planillas( $ced );
//      $afi = str_replace(",","",$afi);
        if (floatval(str_replace(",","",$afi)) > 0) {
                $searches[] = "/home/pvx/PLANILLA_AFIANZADORA.pdf";
        }
	$searches[] = "/home/pvx/CONTRATO_ADHESION.pdf";
	$fpdf = '';
        foreach ($searches AS $sea) {
                if ( file_exists($sea) ) {
                        $fpdf .= $sea . " ";
                }
        }

//echo "serie: " . $fpdf . "<br>";
        if ( !empty($fpdf) ) {
//		$hashced = substr(hash_hmac('sha256', $ced, md5(microtime())), 0, 5);
//                $pdff = $docr . "/pdfs/" . self::$pdfpat . "/" . $ced . "_" . $hashced . ".pdf";
                $pdff = $docr . "/pdfs/" . self::$pdfpat . "/" . $ced . ".pdf";

//echo "unido: " . $pdff . "<br>";
                $ejec = exec("/usr/bin/gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=" . $pdff . " " . $fpdf);
//              $ejec = exec("/usr/bin/convert " . $fpdf . " " . $pdff);
                if ( file_exists($pdff) ) {
                        $searches = self::planillas( $ced );
                        foreach ($searches AS $sea) { @unlink( $sea ); }
                }
        }

//      $updf = JURI::base(). "media/pdf_credivacaciones/" . $ced . ".pdf";
        self::mostraryfinalizar($url, $ced, $npr);
}

} // fin de class

?>
