<?php

class Libcredifunera {

  public static $txread = "SFUNERA";
  public static $ejepvx = "credifuneraria";
// md5(credifuneraria2020)  7d965edc1697e41e63fe90852ad20727
  public static $pdfpat = "7d965edc1697e41e63fe90852ad20727";
//  private static $monini = 154000;
  private static $monini = 3400000;

  public static function getCredito() {
	return self::$txread;
  }

  public static function getEjecpvx() {
	return self::$ejepvx;
  }

  public static function getRutapdf() {
	return self::$pdfpat;
  }

  public static function getMonfin() {
	$mon = number_format(self::$monini, 2); // format: $12,345.00
	return $mon;
  }

  public static function validaemail($ema) {
        $ema = filter_var($ema, FILTER_SANITIZE_EMAIL);
        return (filter_var($ema, FILTER_VALIDATE_EMAIL)) ? 1 : 0;
  }

  public static function datUsuario($ced) {
        $query = "SELECT A.firstname, A.lastname, A.cb_direccion, A.cb_localidad, A.cb_fecnac, A.cb_telefono, A.cb_tipoper, B.email FROM #__comprofiler A, #__users B WHERE A.id = B.id AND B.username = '" . $ced . "' LIMIT 1";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
	$rows = $db->loadObjectList();
        return $rows[0];
  }

  public static function actDirUsuario($ced, $dir) {
        $query = "SELECT A.id FROM #__comprofiler A, #__users B WHERE A.id = B.id AND B.username = '" . $ced . "' LIMIT 1";
        $db1 =& JFactory::getDBO();
        $db1->setQuery($query);
	$rows = $db1->loadObjectList();
        $IDu = $rows[0]->id;

	$exito = 0;
        $query = "UPDATE #__comprofiler SET cb_direccion = '" . $dir . "' WHERE id = " . $IDu;
        $db1->setQuery($query);
	$db1->query();
//	$db1->execute();
	if ($db1->getAffectedRows()){ $exito = 1; }
        return $exito;
  }

  public static function contratoadhesion($ced) {
        $query = "SELECT A.cb_contratoadhesion FROM #__comprofiler A, #__users B WHERE A.id = B.id AND B.username = '" . $ced . "' LIMIT 1";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
	$re = $db->loadRow();
//print_r($re);
        return $re[0];
  }

  public static function baseplanillas($ced, $fal = 0) {
        $rpdf = "/home/pvx/" . (($fal) ? "planillas_faltantes/" : "") . $ced . "_";
        $prog = "_" . self::$txread . ".pdf";
        $searches = array(
                $rpdf . "PP" . $prog,
                $rpdf . "PB" . $prog,
                $rpdf . "RA" . $prog,
                $rpdf . "CA" . $prog
//                $rpdf . "ET" . $prog
        );
        return $searches;
  }

  public static function fileplanillas($lst, $del = 0) {
	$fpdf = "";
	foreach ($lst AS $sea) {
	   if ( file_exists($sea) ) {
		if ( $del == 1 ) { @unlink( $sea ); }
		else { $fpdf .= $sea . " "; }
           }
        }
	return $fpdf;
  }

  public static function buscadscripciones() {
        $query = "SELECT B.fieldtitle FROM #__comprofiler_fields A, #__comprofiler_field_values B ";
        $query .= "WHERE A.fieldid = B.fieldid AND A.name = 'cb_localidad' ORDER BY B.ordering ASC";
        $db =& JFactory::getDBO();
        $db->setQuery($query);
        return $db->loadRowList();
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

  public static function guardarTXT($rdir, $ced, $dirsoc, $monafi) {

	$nomsoc = (isset($_REQUEST["nomsoc"])) ? $_REQUEST["nomsoc"] : "";
	$emasoc = (isset($_REQUEST["emasoc"])) ? $_REQUEST["emasoc"] : "";
	$telsoc = (isset($_REQUEST["telsoc"])) ? $_REQUEST["telsoc"] : "";
        $tipsoc = (isset($_REQUEST["tipsoc"])) ? $_REQUEST["tipsoc"] : "";
        $dispre = (isset($_REQUEST["dispre"])) ? $_REQUEST["dispre"] : 0;
        $maxjor = (isset($_REQUEST["maxjor"])) ? $_REQUEST["maxjor"] : 0;

        $nrocuo = (isset($_REQUEST["nrocuo"])) ? $_REQUEST["nrocuo"] : 0;
        $moncuo = (isset($_REQUEST["moncuo"])) ? $_REQUEST["moncuo"] : 0;
        $nrocue = (isset($_REQUEST["nrocue"])) ? $_REQUEST["nrocue"] : 0;
        $moncue = (isset($_REQUEST["moncue"])) ? $_REQUEST["moncue"] : 0;

        $ahoaso = (isset($_REQUEST["ahoaso"])) ? $_REQUEST["ahoaso"] : 0;
        $apopat = (isset($_REQUEST["apopat"])) ? $_REQUEST["apopat"] : 0;
        $dis80p = (isset($_REQUEST["dis80p"])) ? $_REQUEST["dis80p"] : 0;
        $totpre = (isset($_REQUEST["totpre"])) ? $_REQUEST["totpre"] : 0;
        $fecdia = (isset($_REQUEST["fecdia"])) ? $_REQUEST["fecdia"] : "";
        $deuaho = (isset($_REQUEST["deuaho"])) ? $_REQUEST["deuaho"] : 0;
        $deuapo = (isset($_REQUEST["deuapo"])) ? $_REQUEST["deuapo"] : 0;
        $deupre = (isset($_REQUEST["deupre"])) ? $_REQUEST["deupre"] : 0;

        $selfin = (isset($_REQUEST["selfin"])) ? $_REQUEST["selfin"] : 0;
        $monfin = (isset($_REQUEST["monfin"])) ? $_REQUEST["monfin"] : 0;
        $aresoc = (isset($_REQUEST["aresoc"])) ? $_REQUEST["aresoc"] : "";

        $nomben = (isset($_REQUEST["nomben"])) ? $_REQUEST["nomben"] : "";
        $cedben = (isset($_REQUEST["cedben"])) ? $_REQUEST["cedben"] : "";
        $telben = (isset($_REQUEST["telben"])) ? $_REQUEST["telben"] : "";
        $corben = (isset($_REQUEST["corben"])) ? $_REQUEST["corben"] : "";
        $dirben = (isset($_REQUEST["dirben"])) ? $_REQUEST["dirben"] : "";
        $dirben = self::str_to_utf8($dirben);

        $afilia = (isset($_REQUEST["afilia"])) ? $_REQUEST["afilia"] : 0;

        $cont = $ced . PHP_EOL;
        $cont .= $nomsoc . PHP_EOL;
        $cont .= $dispre . PHP_EOL;
        $cont .= $monfin . PHP_EOL;

        $cont .= $nrocuo . PHP_EOL;
        $cont .= $moncuo . PHP_EOL;
        $cont .= $nrocue . PHP_EOL;
        $cont .= $moncue . PHP_EOL;

        $cont .= $ahoaso . PHP_EOL;
        $cont .= $apopat . PHP_EOL;
        $cont .= $dis80p . PHP_EOL;
        $cont .= $totpre . PHP_EOL;

        $cont .= $fecdia . PHP_EOL;
        $cont .= $tipsoc . PHP_EOL;
        $cont .= $deuaho . PHP_EOL;
        $cont .= $deuapo . PHP_EOL;
        $cont .= $deupre . PHP_EOL;

//        $cont .= $dirsoc . PHP_EOL;
        $cont .= $selfin . PHP_EOL;
        $cont .= $monafi . PHP_EOL;
        $cont .= $aresoc . PHP_EOL;

        $cont .= "U;" . $cedben . ";" . $nomben . ";" . $telben . ";" . $corben . ";" . $dirben . PHP_EOL;

        for ($i = 1; $i <= 8; $i++){
                $nomgf = (isset($_REQUEST["nomgf" . $i])) ? $_REQUEST["nomgf" . $i] : "";
                $cedgf = (isset($_REQUEST["cedgf" . $i])) ? $_REQUEST["cedgf" . $i] : 0;
                $fecgf = (isset($_REQUEST["fecgf" . $i])) ? $_REQUEST["fecgf" . $i] : "";
                $pargf = (isset($_REQUEST["pargf" . $i])) ? $_REQUEST["pargf" . $i] : "";
                $edagf = (isset($_REQUEST["edagf" . $i])) ? $_REQUEST["edagf" . $i] : "";
                $cont .= $i . ";" . $cedgf . ";" . $nomgf . ";" . $fecgf . ";" . $pargf . ";" . $edagf . PHP_EOL;
        }
        $cont .= $afilia;
//echo "contenido: " . $cont;

        $file_socio = $rdir . "DEFINITIVO_" . self::$txread . ".TXT";
        escribir_archivo($file_socio, $cont);

        $ejec = exec($rdir . "ejec_pvx_credifuneraria definitivo 2>&1");

        $file_socio2 = $rdir . "DEF_" . self::$txread . "_" . $ced . ".TXT";
        escribir_archivo($file_socio2, $cont);

        $cn = file_get_contents( trim($file_socio) );
	return $cn;
  }

  public static function definirpdf($ced, $docr) {
	$dpdf = $docr . "/pdfs/" . self::$pdfpat;
	if ( !file_exists($dpdf) ) {
		mkdir($dpdf, 0755, true);
	}
//	$hashced = substr(hash_hmac('sha256', $ced, md5(microtime())), 0, 5);
//	$pdff = $docr . "/pdfs/" . self::$pdfpat . "/" . $ced . "_" . $hashced . ".pdf";
	$pdff = $dpdf . "/" . $ced . ".pdf";
	return $pdff;
  }

  public static function generarpdf($ced, $docr, $mafi) {

        $ss = self::baseplanillas( $ced );
//echo "afianauco: " . $afi;
        if (floatval(str_replace(",", "", $mafi)) > 0){
		$ss[] = "/home/pvx/PLANILLA_AFIANZADORA.pdf";
        }
//	$ss[] = "/home/pvx/CONTRATO_ADHESION.pdf";
        $fpdf = self::fileplanillas( $ss );

//echo "serie: " . $fpdf . "<br>";
	$pdff = "";
        if ( !empty($fpdf) ) {
		$pdff = self::definirpdf($ced, $docr);
//echo "unido: " . $pdff . "<br>";
                $ejec = exec("/usr/bin/gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=" . $pdff . " " . $fpdf);
		if ( file_exists($pdff) ) {
//echo "existe: " . $pdff . "<br>";
			$ss = self::baseplanillas( $ced );
			self::fileplanillas($ss, 1);
                } else  $pdff = "";
        }
	return $pdff;
  }

} // fin de class

?>
