<?php

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

$tok = (isset($_REQUEST["tok"])) ? $_REQUEST["tok"] : "";
$ced = (isset($_REQUEST["ced"])) ? $_REQUEST["ced"] : "";
$opt = (isset($_REQUEST["opt"])) ? $_REQUEST["opt"] : 0;
$dpm = (isset($_REQUEST["dpm"])) ? $_REQUEST["dpm"] : 0;
$tip = (isset($_REQUEST["tip"])) ? $_REQUEST["tip"] : "";
$mon = (isset($_REQUEST["mon"])) ? $_REQUEST["mon"] : 0;
$ncu = (isset($_REQUEST["ncu"])) ? $_REQUEST["ncu"] : 0;

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');
$rdir = "/srv/www/htdocs/";
$merr = "";
$resp = [];
$rest = array();

if ( !empty($ced) && IS_AJAX ) {
        $file_socio = $rdir . "PRE_CALCULO_SFUNERA.TXT";

        $contenido = $ced . PHP_EOL . $dpm . PHP_EOL . $tip . PHP_EOL . $opt . PHP_EOL . $mon;
//$resp['cont'] = $contenido;

        escribir_archivo($file_socio, $contenido);

        $ejec = exec($rdir . "ejec_pvx_credifuneraria calculo 2>&1");

        $filas = $rdir . $ced . "_CALCULO_SFUNERA.TXT";

        $cn = file_get_contents( trim($filas) );
        $ln = explode("\n", $cn);

//$rest = array("resp", $ln);

//}

//var_dump($ln);

	if ( file_exists($filas) && count($ln) > 0 ) {
//              unlink( $filas );

		$resp['tokfun'] = $tok;
		$obr = (substr($tip,0,1)== 'O') ? 1 : 0;
		$msc = ($obr) ? "SEMANALES" : "QUINCELANES";
		$nco = ($obr) ? 8 : 4;
//		$nco = ($obr) ? 4 : 2;
		$nce = 1;

                $ms1 = $nco . " CUOTAS " . $msc;
                $ms2 = $nce . " " . "CUOTA ESPECIAL";
                $mco = $mce = $afi = 0;
                $des = '';

                foreach ($ln as $tx)
                {
                        $tx = trim( $tx );
                        list($uno, $dos) = explode(";", $tx, 2);
                        $arr = explode(";", trim($dos));

                       switch ( $uno ) {
                        case '01':
				$mco = trim($arr[0]);
				$mce = trim($arr[1]);
                                break;
                        case '02':
                                $afi = trim($arr[0]);
                                $des = trim($arr[1]);
                                break;
                        }
                }

		$resp['mencuo'] = $ms1;
		$resp['nrocuo'] = $nco;
		$resp['moncuo'] = $mco;

		$resp['mencue'] = $ms2;
		$resp['nrocue'] = $nce;
		$resp['moncue'] = $mce;

		$resp['monafi'] = $afi;
		$resp['desafi'] = $des;

	}

}

/*
if ( empty( $nom ) ) {
	$errorMSG = "<li>Name is required</<li>";
}

if(empty($errorMSG)){
//	$msg = "Name: ".$name.", Email: ".$email.", Subject: ".$msg_subject.", Message:".$message;
//	exit;
}

//$res = array('resp' => $nom);
*/
echo json_encode( $resp );

//echo 'Message: ' . $cn;

//exit();

return;

?>
