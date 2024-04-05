<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;

// retrieve user instance
$my =& JFactory::getUser();

$ced = $_REQUEST["ced"]; // usuario de la consulta
$tip = $my->usertype; // tipo de usuario de la sesion activa

$docr = $_SERVER['DOCUMENT_ROOT'];
 //require_once($docr . '/phps/gestarchivo.php');

////////////////////////////////////

if ( $tip === "Guest" ) 
{
        echo "No tiene permiso para visualizar est información. 
              Favor contactar a un Autor, Editor, Publicador, Gestor o Administrador de la plataforma Web";
        die;
}





?>


    <form action="/index.php?option=com_content&view=article&id=185" method="post">


    

    <p>Selecciona la cuota a pagar :</p>
          <input type="radio" id="html" name="servFunerario" value="HTML">
          <label for="html">Servicio Funerario </label><br>
          <input type="radio" id="css" name="Prestamo Comercial" value="comercial">
          <label for="comercial">Prestamo Comercial</label><br>
          <input type="radio" id="javascript" name="fav_language" value="JavaScript">
          <label for="javascript">Ahorro Asociado</label>

  <br>  

  <h4>Ingresa los datos para realizar el pago</h4>


  <div class="row">
    <div class="col-md-4">
    <label for="cedula">Cedula:</label>
        <input type="text" name="cedula" >

    </div>
    <div class="col-md-4">
    <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" >

    </div>
    <div class="col-md-4">
    <label for="banco">Banco:</label>
        <input type="text" name="banco" >
    </div>
  </div>

  <div class="row">
    <div class="col-md-4">
    <label for="bancos">Selecciona tu banco:</label>
        <select id="bancosSelect">
        </select>
    </div>
    <div class="col-md-4">

    <label for="token">token:</label>
        <input type="text" name="token" >

    </div>
    <div class="col-md-4">


    <label for="token">Monto a Pagar:</label>
        <input type="text" name="monto" >
    </div>
  </div>

    <br>
    <br>
    <br>

        <button class="btn btn-primary" type="submit"> Enviar Pago </button>
    </form>
    <div id="result"></div>


    <script src="./bt.js"></script>