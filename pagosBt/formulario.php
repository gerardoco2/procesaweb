<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> -->

<style>

    .error {
        color: red;
    }
    #success-container {
        display: none;
    }

    #alert {
        display: none;
    }
    .logo {
        max-width: 300px;
        margin-bottom: 20px;
    }
</style>

<div class="container"> 
<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;

//retrieve user instance
$my =& JFactory::getUser();

$ced = $_REQUEST["ced"]; // usuario de la consulta
$tip = $my->usertype; // tipo de usuario de la sesion activa

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');

////////////////////////////////////

if ( $tip === "Guest" ) 
{
        echo "No tiene permiso para visualizar est información. 
              Favor contactar a un Autor, Editor, Publicador, Gestor o Administrador de la plataforma Web";
        die;
}




if($ced) {
    $dirw = "/home/web/jcapunefm/pdfs/";
	$raiz = "/srv/www/htdocs";
	$rdir = "/";
	$file_rechazos = $raiz . $rdir . "RECHAZOS.TXT";

	if ( file_exists($file_rechazos) ){
		unlink( $file_rechazos );
	}
	touch ($file_rechazos);

	escribir_archivo($file_rechazos, $ced); // guardar id usuario para su lectura por procesa

	$filas = $raiz . $rdir . $ced . "_RECHAZOS.TXT"; // archivo resultante

    if ( file_exists($filas) ) {
		unlink( $filas );
	}

    $ejec = exec($raiz . $rdir . "ejec_pvx_rechazos 2>&1");


    $lineas = file($filas);


    echo(var_dump($lineas));

}






?>
<div class="row">


    
    <div id="form-container" class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="logo" src="bt.png" alt="boton-pago-tesoro">
                <p style="color: #0d6efd" >Botón de Pago - Banco del Tesoro</p>
            </div>
        </div>
        <div class="alert alert-danger" data-bs-dismiss="alert" role="alert" id="alert"></div>
        <div class="row">
            <div class="col-md-8">
                <form  method="post" >
                    <p>Selecciona la cuota a pagar :</p>
                    
                    <select name="cuota" id="cuotaSelect" class="form-control">
                        <option value=""></option>
                        <option value="134">Servicio Funerario</option>
                        <option value="95">Prestamo Comercial </option>
                        <option value="50">Pestamo Especial</option>
                        <option value="30">Cuota Ahorro Socio</option>
                    </select>
                    <span id="opcionApagarError" class="error"></span>
        
                    <h4 style="margin-top:18px; margin-bottom:18px">Ingresa los datos para realizar el pago</h4>
        
                    <div class="row">
                        <div class="col-md-4">
                            <label for="cedula">Cédula:</label>
                            <input type="text" name="cedula"  id='cedula' class="form-control form-data" required>
                            <span id="cedulaError" class="error"></span>
                        </div>
        
                        <div class="col-md-4">
                            <label for="telefono">Teléfono:</label>
                            <input type="text" name="telefono" id="telefono" class="form-control form-data" required>
                            <span id="telefonoError" class="error"></span>
                        </div>
        
                        <div class="col-md-4">
                            <label for="bancosSelect">Selecciona tu banco:</label>
                            <select id="bancosSelect" name="bancosSelect" class="form-control form-data" >
                            </select>
                        </div>
                    </div>
        
                    <div class="row">
                        <div class="col-md-4">
                            <label for="token">Token:</label>
                            <input type="text" name="token" id="token" class="form-control form-data" required>
                            <span id="tokenError" class="error"></span>
                        </div>
                        <div class="col-md-4">
                            <label for="monto">Monto a Pagar:</label>
                            <input type="text" name="monto" id="monto" disabled  class="form-control form-data">
                        </div>
                    </div>
        
                    <button style="margin-top: 25px" class="btn btn-primary" type="submit" id="submit" > Enviar Pago </button>
                </form>
            </div>
        </div>
        
        <div id="loader" style="display: none; text-align: center;"><img src="./loader.gif" alt="Cargando..." /></div>
        <div id="successMessage" style="display: none; color: green; text-align: center;"></div>
    </div>

<div id="success-container">
    <!-- Content Start -->
    <table cellpadding="0" cellspacing="0" cols="1" background="#d7d7d7" align="center" style="width: 100%;">
            <tr background="#d7d7d7">
                <td height="50" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
            </tr>


            <tr background="#d7d7d7">
                <td style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                    <!-- Seperator Start -->
                    <table cellpadding="0" cellspacing="0" cols="1" background="#d7d7d7" align="center" style="max-width: 600px; width: 100%;">
                        <tr background="#d7d7d7">
                            <td height="30" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>
                    </table>
                    <!-- Seperator End -->


                    <table align="center" cellpadding="0" cellspacing="0" cols="3" background="white" class="bordered-left-right" style="border-left: 10px solid #d7d7d7; border-right: 10px solid #d7d7d7; max-width: 600px; width: 100%;">
                        <tr height="50"><td colspan="3" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                        <tr align="center">
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td class="text-primary" style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                <img src="http://dgtlmrktng.s3.amazonaws.com/go/emails/generic-email-template/tick.png" alt="GO" width="50" style="border: 0; font-size: 0; margin: 0; max-width: 100%; padding: 0;">
                            </td>
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>
                        <tr height="17"><td colspan="3" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                        <tr align="center">
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td class="text-primary" style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                <h1 style="color: #F16522; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 30px; font-weight: 700; line-height: 34px; margin-bottom: 0; margin-top: 0;"> Pago Recibido</h1>
                            </td>
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>
                        <tr height="30"><td colspan="3" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                        <tr align="left">
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                <p style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">
                                    Hola Gerardo , 
                                </p>
                            </td>
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>
                        <tr height="10"><td colspan="3" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                        <tr align="left">
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                <p style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;">Hemos Recibido el pago de su cuota por el <strong>Botón de Pago - Banco del Tesoro!</strong></p>
                                <br>
                                <p style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0; ">
                                <strong>Detalles del pago: </strong><br/>Monto: <span id="montoPagado"></span> Bs <br/>Detalle: <span id="decPago"></span>.<br/></p>
                                    <br>
                               
                            </td>
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>
                        <tr height="30">
                            <td style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td style="border-bottom: 1px solid #D3D1D1; color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>
                        <tr height="30"><td colspan="3" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td></tr>
                        <tr align="center">
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                            <td style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;">
                                <p style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;"><strong> Referencia del Pago : <p id="refpago"></p></strong></p>
                                <p style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;"><strong> Fecha : <p id="fechaPago"></p></strong></p>
             
                                <p style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 22px; margin: 0;"></p>
                            </td>
                            <td width="36" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>

                        <tr height="50">
                            <td colspan="3" style="color: #464646; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; line-height: 16px; vertical-align: top;"></td>
                        </tr>

                    </table>
                    <!-- Generic Pod Left Aligned with Price breakdown End -->
                    
                </td>
            </tr>
        </table>
        <div class="btn-regresar" style="text-align: center; margin: 10px">
            <button class="btn btn-primary" id="regresar">Regresar</button> 
            <div class="btn btn-success" id="imprimir">Imprime o Descarga tu comprobante</div>    
        </div>
        
        <!-- Content End -->

</div>


</div>
</div> 
<script src="./bt.js"></script>