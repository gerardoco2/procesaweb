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

if ( $tip === "Registered" || $tip === "Guest" ) 
{
        echo "No tiene permiso para visualizar est información. 
              Favor contactar a un Autor, Editor, Publicador, Gestor o Administrador de la plataforma Web";
        die;
}

if ( !$ced )
{
//echo JURI::current();
	$uri =& JURI::getInstance();
	
  echo "<form name=f1 action=" . $uri->toString() . " method=post>
        <table width=100% height=100% border=0 cellspacing=0>
          <tr>
                <td width=25% align=center>
                        <img src=" . JURI::base() . "images/stories/capunefm/iconcapunefm.png />
                </td>
                <td width=50% align=center>
                        <h3>CONSULTA DE ESTADO DE CUENTA</h3>
                        <br /> 
                        <b>ASOCIADO " . strtoupper( $app->getCfg('MetaKeys') ) . " </b>
                </td>
                <td width=25% valign=bottom align=right>
                " . JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . "<br>" . date("h:i:s a") . "
                </td>
          </tr>
          <tr>
                <td colspan=3 align=center>
                <hr width=95%>
                        ID: <input type=text name=ced size=20 value=''>&nbsp;&nbsp;<input type=submit name=enviar value='Consultar' size=12>
                <hr width=95%>
                </td>
