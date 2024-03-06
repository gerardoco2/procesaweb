<?php

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

$ced = (isset($_REQUEST["ced"])) ? $_REQUEST["ced"] : "";
$tok = (isset($_REQUEST["tok"])) ? $_REQUEST["tok"] : "";

$arr = array();
if (isset($_REQUEST["ssd"])) parse_str($_REQUEST["ssd"], $arr);

$nomsoc = $arr["nomsoc"];
$dirsoc = $arr["dirsoc"];
$emasoc = $arr["emasoc"];
$emasoc = $arr["emasoc"];
$tipsoc = $arr["tipsoc"];
$fecdia = $arr["fecdia"];

$dispre = $arr["dispre"];
$maxjor = $arr["maxjor"];
$nrocuo = $arr["nrocuo"];
$moncuo = $arr["moncuo"];
$nrocue = $arr["nrocue"];
$moncue = $arr["moncue"];

$ahoaso = $arr["ahoaso"];
$apopat = $arr["apopat"];
$dis80p = $arr["dis80p"];
$totpre = $arr["totpre"];
$deuaho = $arr["deuaho"];
$deuapo = $arr["deuapo"];
$deupre = $arr["deupre"];

$selfin = $arr["selfin"];
$monfin = $arr["monfin"];

//$apeben = $arr["apeben"];
$nomben = $arr["nomben"];
$cedben = $arr["cedben"];
$telben = $arr["telben"];
$corben = $arr["corben"];
$dirben = $arr["dirben"];
$agree = $arr["agree"];

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');
$rdir = "/srv/www/htdocs/";
$resp = array();

if ( !empty($ced) && $agree == 1 && IS_AJAX ) {

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

//        $cont .= $dirsoc . PHP_EOL;
        $cont .= $selfin . PHP_EOL;
        $cont .= $monafi . PHP_EOL;
        $cont .= $aresoc . PHP_EOL;

        $cont .= "U;" . $cedben . ";" . $nomben . ";" . $telben . ";" . $corben . ";" . $dirben . PHP_EOL;


	for ($i = 1; $i <= 8; $i++){
		$nomgf = $arr["nomgf" . i];
		$cedgf = $arr["cedgf" . i];
		$fecgf = $arr["fecgf" . i];
		$pargf = $arr["pargf" . i];
		$edagf = $arr["edagf" . i];
		$cont .= $i . ";" . $cedgf . ";" . $nomgf . ";" . $fecgf . ";" . $pargf . ";" . $edagf . PHP_EOL;
	}

        $file_socio = $rdir . "DEFINITIVO_SFUNERA.TXT";
        escribir_archivo($file_socio, $cont);

//        $ejec = exec($rdir . "ejec_pvx_credifuneraria definitivo 2>&1");

//        $file_socio = $rdir . $ced . "_DEFINITIVO_SFUNERA.TXT";

        $cn = file_get_contents( trim($file_socio) );
        $ln = explode("\n", $cn);

	if ( count($ln) > 0 ) {
//              unlink( $filas );

		$resp['cn'] = $cn;
		$resp['atk'] = $tok;
		$resp['ids'] = $ced;
		$resp['afi'] = $monafi;
//		$vlib->actDirUsuario($ced, $dirsoc);
//		$resp['pdo'] = $vlib->generarpdf($ced, $rdir, $docr);
	}
} // fin if ced

echo json_encode( $resp );

//exit();

//return;

?>
