<?php

function escribir_archivo($narchivo, $contenido) {
	if ( file_exists($narchivo) ){
		unlink( $narchivo );
	}
	touch ($narchivo);

	if ( is_writable($narchivo) ) {
		if (!$gestor = fopen($narchivo, 'a')) {
			echo "No se puede abrir el archivo ($narchivo)";
			exit;
		}
		if (fwrite($gestor, $contenido) === FALSE) {
			echo "No se puede escribir al archivo ($narchivo)";
			exit;
		}
//		echo "Exito, se escribió ($contenido) al archivo ($narchivo)";
		fclose($gestor);
		chmod($narchivo, 0777);
	} else {
		echo "No se puede escribir sobre el archivo $narchivo";
	}
}

function remover_antiguos($directorio) {
// 3600 - 1 hora
// 24	- 1 dia
// 7	- dias
	$dir = opendir($directorio);
	while($f = readdir($dir)) {
		if((time()-filemtime($directorio . $f) > 1800) and !(is_dir($directorio . $f)))
		unlink($directorio . $f);
	}
	closedir($dir);
}

?>
