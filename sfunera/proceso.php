<?php

define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

$tok = (isset($_REQUEST["tok"])) ? $_REQUEST["tok"] : "";
$ced = (isset($_REQUEST["ced"])) ? $_REQUEST["ced"] : "";

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');
$rdir = "/srv/www/htdocs/";
$merr = "";
$resp = [];
$rest = array();

if ( !empty($ced) && IS_AJAX ) {
	$file_socio = $rdir . "DISPONIBILIDAD_SFUNERA.TXT";

	escribir_archivo($file_socio, $ced);

	$ejec = exec($rdir . "ejec_pvx_credifuneraria disponibilidad 2>&1");

	$fildis = $rdir . $ced . "_DISPONIBILIDAD_SFUNERA.TXT";

	$cndis = file_get_contents( trim($fildis) );
	$lndis = explode("\n", $cndis);

	$resp['error'] = 0;
//$rest = array("resp", $ln);

//var_dump($lndis);
	if ( count($lndis) > 0 ) {
//		unlink( $fildis );

		$resp['tokfun'] = $tok;

                foreach ($lndis as $tx)
                {
                        $tx = trim( $tx );
                        list($uno, $dos) = explode(";", $tx, 2);
                        $arr = explode(";", trim($dos));

                        if ( $uno == '01' ) {
                                $resp['cedula'] = $arr[0];
                        }
//echo "dat: $uno - $arr[0] <br>";
                        switch ( $uno ) {
                        case '02':
                                $resp['nombre'] = $arr[0];
                                break;
                        case '03':
                                $resp['correo'] = trim($arr[0]);
                                break;
                        case '04':
                                $resp['telefo'] = trim($arr[0]);
                                break;
                        case '05':
                                $resp['cuenta'] = trim($arr[0]);
                                break;
                        case '06':
                                $resp['tipper'] = trim($arr[0]);
                                break;
                        case '07':
                                $status = trim($arr[0]);
                                switch ($status) {
                                        case 'A':  $estado = 'ACTIVO';      break;
                                        case 'J':  $estado = 'JUBILADO';    break;
                                        default:   $estado = 'NO DEFINIDO'; break;
                                }
				$resp['estado'] = $estado;
                                break;
                        case '08':
                                $resp['ahoaso'] = trim($arr[0]);
                                break;
                       case '09':
                                $resp['ahopat'] = trim($arr[0]);
                                break;
                        case '10':
                                $resp['deuaso'] = trim($arr[0]);
                                break;
                        case '11':
                                $resp['deupat'] = trim($arr[0]);
                                break;
                        case '12':
                                $resp['porc80'] = trim($arr[0]);
                                break;
                        case '13':
                                $resp̈́['deupre'] = trim($arr[0]);
                                break;
                        case '14':
                                $resp['totpre'] = trim($arr[0]);
                                $resp['nropre'] = trim($arr[1]);
                                break;
                       case '15':
                                $resp['totafi'] = trim($arr[0]);
                                $resp['nroafi'] = trim($arr[1]);
                                break;
                        case '16':
                                $resp['dpmont'] = trim($arr[0]);
                                $resp['dpdesc'] = str_replace('<', '', $arr[1]);
                                $resp['dpdesc'] = str_replace('>', '', $dpdesc);
                                $resp['dpdesc'] = trim($dpdesc);
                                break;
                        case '17':
                                $resp['fecact'] = trim($arr[0]);
                                break;
                        case '18':
                                $resp['jpmont'] = trim($arr[0]);
                                $resp['jpdesc'] = str_replace('<', '', $arr[1]);
                                $resp['jpdesc'] = str_replace('>', '', $jpdesc);
                                $resp['jpdesc'] = trim($jpdesc);
                                break;
                        case '19':
                                $resp['codpro'] = trim($arr[0]);
                                $resp['nompro'] = trim($arr[1]);
                                break;
                        case '20':
                                $resp['activo'] = trim($arr[0]);
                                $resp['desact'] = trim($arr[1]);
                                break;
                        case '21':
                                $resp['afilia'] = trim($arr[0]); // 0: nuevo afiliacion, 1: viejo renovacion
                                break;
                        }
                }

	} else {
		$resp['error'] = 1;
	}

	$filben = $rdir . $ced . "_BENEFICIARIOS_SFUNERA.TXT";
//	$filben = $rdir . "6915461_BENEFICIARIOS_SFUNERA.TXT";
	$cnben = file_get_contents( trim($filben) );
	$lnben = explode("\n", $cnben);

	if ( count($lnben) > 0 ) {
//              unlink( $filben );

                foreach ($lnben as $tx)
                {
                        $tx = trim( $tx );
                        list($uno, $dos) = explode(";", $tx, 2);
                        $arr = explode(";", trim($dos));

                        if ( $uno == 'U' ) {
                                $resp['cedben'] = trim($arr[0]);
                                $resp['nomben'] = filter_var(trim($arr[1]), FILTER_SANITIZE_STRING);
                                $resp['telben'] = trim($arr[2]);
                                $resp['corben'] = filter_var(trim($arr[3]), FILTER_SANITIZE_EMAIL);
                                $resp['dirben'] = filter_var(trim($arr[4]), FILTER_SANITIZE_STRING);
                        }
			if ( is_numeric($uno) && $uno >= 1 && $uno <= 8 ) {
                                $resp['cedgf' . $uno] = trim($arr[0]);
                                $resp['nomgf' . $uno] = filter_var(trim($arr[1]), FILTER_SANITIZE_STRING);
                                $resp['pargf' . $uno] = trim($arr[2]);
                                $resp['edagf' . $uno] = trim($arr[3]);
                                $resp['fecgf' . $uno] = trim($arr[4]);
			}
                }
	} else {
		$resp['error'] = 2;
	}
}

echo json_encode( $resp );

//echo 'Message: ' . $cn;

//exit();

return;

?>
