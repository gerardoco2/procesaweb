<?php 
defined( '_JEXEC' ) or die( 'Restricted access' );

global $app, $_SERVER;

// retrieve user instance
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





?>
    <form action="./procesarPago.php" method="post">
        <label for="cedula">Cedula:</label>
        <input type="text" name="cedula" >

        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" >

        <label for="banco">Banco:</label>
        <input type="text" name="banco" >

        <label for="token">token:</label>
        <input type="text" name="token" >

        <button type="submit"> Enviar Pago </button>
    </form>
    <div id="result"></div>


