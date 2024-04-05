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


        <label for="cedula">Cedula:</label>
        <input type="text" name="cedula" >

        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" >

        <label for="banco">Banco:</label>
        <input type="text" name="banco" >

        <label for="bancos">Selecciona tu banco:</label>
        <select id="bancosSelect">

        </select>

        <label for="token">token:</label>
        <input type="text" name="token" >

        <button type="submit"> Enviar Pago </button>
    </form>
    <div id="result"></div>


    <script src="./bt.js"></script>