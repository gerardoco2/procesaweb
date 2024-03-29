<?php


defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;


// retrieve user instance
$my =& JFactory::getUser();

$ced = ($my->id) ? $my->username : ""; // usuario de la sesion activa
$nom = ($my->id) ? $my->name : "No identificado"; // usuario de la sesion activa

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');
require_once($docr . '/phps/dompdf/autoload.inc.php');
// reference the Dompdf namespace
use Dompdf\Dompdf;
use Dompdf\Options;


//echo $docr . "<br>";

//echo __DIR__;
////////////////////////////////////





if ( !empty($ced) )
{
	$dirw = "/home/web/jcapunefm/pdfs/";
	$raiz = "/srv/www/htdocs";
	$rdir = "/";
	$file_socio = $raiz . $rdir . "SFUNERA.TXT";

	if ( file_exists($file_socio) ){
		unlink( $file_socio );
	}
	touch ($file_socio);

	escribir_archivo($file_socio, $ced); // guardar id usuario para su lectura por procesa

	$filas = $raiz . $rdir . $ced . "_SFUNERA.TXT"; // archivo resultante
	if ( file_exists($filas) ) {
		unlink( $filas );
	}

	$ejec = exec($raiz . $rdir . "ejec_pvx_sfunera 2>&1");

	if ( file_exists($filas) )
	{

			$benef_arr = file(trim($filas));
			
			echo "
			<style>
				table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 100%;
				}

				td, th {
				border: 1px solid #dddddd;
				text-align: left;
				padding: 8px;
				}

				tr:nth-child(even) {
				background-color: #dddddd;
				}
				</style>
			<h3> Listado de sus Beneficiarios Registrados en el Servicio Funerario </h3>
			<br>
			<table>
				<tr>
					<th> Cedula </th>
					<th> Nombres y Apellidos</th>
					<th> Parentesco </th>
				</tr>
				";

			foreach ( $benef_arr as $beneficiario )
			{
				list($tipo, $cedula, $nombre, $parentesco) = explode(";", $beneficiario);

				echo "
				<tr> 
					<td>" . $cedula . "</td>
					<td>" . $nombre . "</td>
					<td>" . $parentesco  . "</td>
				</tr>";	
			}
			echo "</table>";



// CARNET EMPIEZA AQUI

			echo '<h3 style="margin: 20px; ">Descarga tu Carnet del servicio funerario aqui </h3> ';
			
			list($tipo, $cedula_afil, $bene_afiiliado, $parentesco) = explode(";", $benef_arr[0]); 
			$form = '
			<form action="index.php?option=com_content&view=article&id=180" method="post">
				<input type="hidden" id="nombre_afiliado" name="nombre_afiliado" value="'. $bene_afiiliado .'">
				<input type="hidden" id="cedula_afiliado" name="cedula_afiliado" value="'. $cedula_afil .'"> ';
			for ($i=1; $i < sizeof($benef_arr); $i++) { 
				list($tipo, $cedula, $beneficiario, $parentesco) = explode(";", $benef_arr[$i]);
				$form .= '<input type="hidden" id="nombre_benef" name="nombre_benef-'.$i.'" value="'. $beneficiario .'"> ';
				$form .= '<input type="hidden" id="parentesco_benef" name="parentesco_benef-'.$i.'" value="'. $parentesco .'"> ';
				$form .= '<input type="hidden" id="cedula_benef" name="cedula_benef-'.$i.'" value="'. $cedula .'"> ';
			}

			$form .= '
			<button class="btn btn-primary" type="submit" style="margin: 0 auto;">Descargar Carnet</button>
			</form>';
			
			echo $form;

			echo '
			<style>
			.container {
				margin-top: 60px;
				float: left;
				flex-direction: row;
			  }
			  
			  .front-side {
				float: left;
				height: 300px;
				width: 550px;
				border: 1px solid black;
			  }
			  .logo ,  .footer{
				display: flex;
				flex-direction: row;
				justify-content: center;
			  }

			  .body {
				text-align: center;
			  }
			  .body p {
				font-weight: 700;
				font-size: 12px;
				letter-spacing: 1px
			  }
			  
			  .body > .title {
				fonr-weight: 800;
			  }
			  
			  .footer img {
				width: 200px
			  }
			  
			  .affiliate-info {
				display: flex;
				justify-content: space-around;
			  }
			  
			  .affiliate-info  p {
				margin: 0;
			  }
			  
			  .benef-container {
				height: 16px;
				display: flex;
				flex-direction: row;
				justify-content: space-between;
				margin-left: 30px;
				margin-right: 30px
			  }
			  
			  table {
				font-family: arial, sans-serif;
				border-collapse: collapse;
				width: 90%;
				margin: 0 auto;
			  }
			  
			  td, th {
				text-align: left;
				padding: 2px;
				font-size: 12px
			  }
			</style>
			<div>

				<div class="container">
				<div class="front-side">
				<div class="logo">
					<img src="https://capunefm.com/images/logocapunefm.png" alt="">
				</div>
					<div class="body">
					<p>CAJA DE AHORROS DEL PERSONAL DE LA <br>
					UNIVERSIDAD NACIONAL EXPERIMENTAL <br>
						FRANCISCO DE MIRANDA
					CAPUNEFM</p>

					<div class="title">
						<h3>CARNET DE AFILIACION</h3>
					</div>
					<div class="titular">
						<h4>'. $bene_afiiliado  . '</h4>
					</div>
				<div class="footer">
					<img src="https://www.necropolisfuneral.com/assets/img/logo_necrolpolis-footer.png" alt="">
				</div>   
					</div>

				</div>

				<div class="front-side">
				<div class="logo">
					<img src="https://capunefm.com/images/logocapunefm.png" alt="">
				</div>
				<div class="affiliate-info">
					<div class="name">
					<p>Nombres y Apellidos del Afiliado:</p>
					'. $bene_afiiliado .'
					</div>
					<div class="id">
					<p>Cedula:</p>
					'. $cedula_afil .'
					</div>
				</div>
					<div class="body">
					

					<div class="beneficiaries">
						<div class="benef-title">Carga Familiar</div>
						

						<table>';

						for ($x = 1; $x <= sizeof($benef_arr); $x++) {
							list($tipo, $cedula, $beneficiario, $parentesco) = explode(";", $benef_arr[$x]);
							echo '
							<tr>
								<td>'. $beneficiario .'</td>
								<td>'. $cedula .'</td>
								<td>'. $parentesco .'</td>
							</tr>
							';
						};

						echo '
						</table>
					</div>

					</div>

				</div>  
				</div>

			</div>
			';

			//echo $carnetHtml;

			function generaCarnetPdf($html) {

				$options = new Options();
				$options->set('isRemoteEnabled', TRUE);

				// instantiate and use the dompdf class
				$dompdf = new Dompdf($options);
				$dompdf->loadHtml('
				<style>
					/* Container */
					.container {
					margin-top: 60px;
					display: inline-block; /* Display inline-block to allow elements next to it */
					width: 100%; /* Set container width */
					}
		
					/* Front side */
					.front-side {
					float: left;
					height: 300px;
					width: 500px; /* Set width to 100% to fill container */
					border: 1px solid black;
					}
		
					/* Logo and footer */
					.logo,
					.footer {
					text-align: center; /* Center content horizontally */
					padding-top: 5px; /* Add top padding */
					margin-bottom: 5px;
					}
					
					.logo img {
						heigh: 40px;
						width:180px;
					}

					.footer img {
					width: 180px;
					}

					
					/* Body */
					.body {
					text-align: center;
					}
		
					.body p {
					font-weight: 700;
					font-size: 12px;
					letter-spacing: 2px;
					}
		
					.body > .title {
					font-weight: 800;
					}

					.titular > p {
					font-size: 14px;
					margin-bottom: 0;
					}

					table {
					width: 100%;
					}

					td, th {
					text-align: left;
					padding-left: 8px;
					font-size: 12px;
					font-size: 14px
					}

					th {
					font-size: 14px;
					}

					td { 
					font-size: 12px; 
					}
					tr:nth-child(even) {
					background-color: #dddddd;
					}
				</style>
				<div>

				<div class="container">
                    <div class="front-side">
                        <div class="logo">
                            <img src="https://capunefm.com/images/logocapunefm.png" alt="">
                        </div>
                        <div class="body">
                            <p>CAJA DE AHORROS DEL PERSONAL DE LA <br>
                            UNIVERSIDAD NACIONAL EXPERIMENTAL <br>
                            FRANCISCO DE MIRANDA CAPUNEFM</p>

                            <div class="title">
                                <h5>CARNET DE AFILIACION</h5>
                            </div>
                            <div class="titular">
                                <p >GERARDO COLINA</p>
                            </div>
                            <div class="footer">
                                <img src="https://www.necropolisfuneral.com/assets/img/logo_necrolpolis-footer.png" alt="">
                              <p>
                                telefonos: 0412-169-76-20 / 0412-664-73-20 / 0412-411-79-82 
                              </p>
                            </div>   
                        </div>

                    </div>

                    <div class="front-side">
                        <div class="logo">
                            <img src="https://capunefm.com/images/logocapunefm.png" alt="">
                        </div>
                        <div class="affiliate-info">
                           <table>
                             <tr>
                               <th>Nombres y Apellidos del Afiliado :</th>
                               <th> Cedula :</th>
                             </tr>
                             <tr >
                               <td>Gerardo Colina</td>
                               <td> 20569539</td>
                             </tr>
                           </table>
                           <table>
                             <tr>
                               <td style="text-align: center" colspan="3">Carga Familiar</td>
                             </tr>
                             <tr>
                               <td>Nelis Quintero</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Antonia Quintero De Colina</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Quintero</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Antonia Quintero De Colina</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Quintero</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Antonia Quintero De Colina</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Quintero</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                             <tr>
                               <td>Nelis Antonia Quintero De Colina</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                              <tr>
                               <td>Nelis Antonia Quintero De Colina</td>
                               <td>7484580</td>
                               <td>Madre</td>
                             </tr>
                           </table>

                        </div>
                    </div>  
				</div>
                <div class="clearfix"></div>
			</div>
				');

				$stream = true;
				// (Optional) Setup the paper size and orientation
				$dompdf->setPaper('A4', 'landscape');

				// Render the HTML as PDF
				$dompdf->render();

				// Output the generated PDF to Browser
				//$dompdf->stream();

				if ($stream) {
					ob_end_clean();
					$dompdf->stream("carnet.pdf", array("Attachment" => 0));

				} else {
				return $dompdf->output();
				}

				die();

			}
			
				//generaCarnetPdf($carnetHtml);

                remover_antiguos($dirw);
	}
	else
	{
		echo "<p align=justify>Hubo un <b><i>error en lectura del archivo de datos</i></b>,
		a fin de generar sus estados de cuenta como afiliado de la Caja de Ahorros
		<br>(Usuario: <b>$ced</b> y Nombre Asociado: <b>" . strtoupper($nom) . "</b>)
		<br><br>
		Favor, póngase en contacto con la administración de " . $app->getCfg('MetaKeys') . "
		vía telefónica, o envíe un e-mail a " . $app->getCfg('mailfrom') . ", a fin de 
		solventar su caso a la brevedad posible</p>";
	}

} // fin - al consultar un asociado

?>
