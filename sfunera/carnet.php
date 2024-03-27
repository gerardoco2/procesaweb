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


          $html ='  <style>
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
                                Telefonos: 0412-169-76-20 / 0412-664-73-20 / 0412-411-79-82 
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
            ';

            function generaCarnetPdf($html) {

				$options = new Options();
				$options->set('isRemoteEnabled', TRUE);

				// instantiate and use the dompdf class
				$dompdf = new Dompdf($options);
				$dompdf->loadHtml($html);

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

            generaCarnetPdf($html);
			

?>