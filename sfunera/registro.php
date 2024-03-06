<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
header('Content-Type: text/html; charset=UTF-8');

global $app, $_SERVER;
// retrieve user instance
$my =& JFactory::getUser();

$url = JURI::getInstance()->toString();
$rou = JRoute::_($url);

$ss =& JFactory::getSession();
$tok = $ss->getToken();

$docr = $_SERVER['DOCUMENT_ROOT'];
require_once($docr . '/phps/gestarchivo.php');
require_once("libreria.php");
$vlib = new Libcredifunera();
$rdir = "/srv/www/htdocs/";

$ced = ($my->id) ? $my->username : "";
$nom = ($my->id) ? $my->name : "No identificado";
$mon = $vlib->getMonfin();

////////////////////////////////////

if ( !empty($ced) ) {

  $agree = (isset($_REQUEST["agree"])) ? $_REQUEST["agree"] : 0;

  // validad si existe un archivo registrado
  $epdf = $vlib->definirpdf($ced, $docr);
  $agree = ( file_exists($epdf) ) ? 1 : $agree;

  if ($agree == 0) {	// carga de formulario
	$datusr = $vlib->datUsuario($ced);
//var_dump($datusr);
?>
<style>
.stepwizard-step p {
    margin-top: 0px;
    color:#666;
}
.stepwizard-row {
    display: table-row;
}
.stepwizard {
    display: table;
    width: 100%;
    position: relative;
}
.stepwizard-step button[disabled] {
    /*opacity: 1 !important;
    filter: alpha(opacity=100) !important;*/
}
.stepwizard .btn.disabled, .stepwizard .btn[disabled], .stepwizard fieldset[disabled] .btn {
    opacity:1 !important;
    color:#bbb;
}
.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content:" ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-index: 0;
}
.stepwizard-step {
    display: table-cell;
    text-align: center;
    position: relative;
}
.btn-circle {
    width: 30px;
    height: 30px;
    text-align: center;
    padding: 6px 0;
    font-size: 12px;
    line-height: 1.428571429;
    border-radius: 15px;
}
.loader {
  width: 200px;
  height: 200px;
  margin: 0 auto;
  border: 16px solid #f3f3f3;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite; /* Safari */
  animation: spin 2s linear infinite;
}
/* Safari */
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}
@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
.sinborde {
  background-color: #ffffff !important;
  border: 0 !important;
}
input[type="text"], input[type="email"] {
  width: 95% !important;
}
</style>

<script src="https://code.jquery.com/jquery-3.4.1.js"></script>
<script type="text/javascript">
jQuery(function($){

    var navListItems = $('div.setup-panel div a'), frm = $('#sfuner'), panPdf = $('#pdf'),
        allWells = $('.setup-content'), allPrevBtn = $('.prevBtn'), allNextBtn = $('.nextBtn');

    allWells.hide();
//    panPdf.hide();
    $("#step-1 .cargad").hide();  $("#step-1 .panelc").show();
    $("#step-4 .cargad").hide();  $("#step-4 .panelc").hide();

    navListItems.click(function (e) {
        e.preventDefault();
        var $target = $($(this).attr('href')),
            $item = $(this);

        if (!$item.hasClass('disabled')) {
            navListItems.removeClass('btn-success').addClass('btn-default');
            $item.addClass('btn-success');
            allWells.hide();
            $target.show();
            $target.find('input:eq(0)').focus();
        }
    });

    allPrevBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            prevStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");
        prevStepWizard.removeAttr('disabled').trigger('click');
    });

    allNextBtn.click(function () {
        var curStep = $(this).closest(".setup-content"),
            curStepBtn = curStep.attr("id"),
            nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
            curInputs = curStep.find("input,select,textarea,checkbox"),
            isValid = true;

        $(".form-group").removeClass("has-error");
        for (var i = 0; i < curInputs.length; i++) {
            if (!curInputs[i].validity.valid) {
                isValid = false;
               $(curInputs[i]).closest(".form-group").addClass("has-error");
            }
        }

        if (isValid) nextStepWizard.removeAttr('disabled').trigger('click');

        if (curStepBtn == "step-4") {
                var optsel = $("#selfin").val();
                if (optsel < 0 || optsel == '') {
                   alert("Elija una de las opciones de financiamiento");
                   return;
                }
                $("#ced").val( $("#cedsoc").val() );
                $("#nom").val( $("#nomsoc").val() );
//              $("#finaut").html( $("#calcuo").html() );
        }
    });

    $('div.setup-panel div a.btn-success').trigger('click');

    var mk = '';
    for (var i=1; i<=8; i++) {
        mk = '<tr>';
        mk += '<td>' + i + '</td>';
//      mk += '<td><input name="apegf' + i + '" id="apegf' + i + '" type="text" class="form-control input-sm" size="12" placeholder="Apellido">';
        mk += '<td><input name="nomgf' + i + '" id="nomgf' + i + '" type="text" class="form-control input-sm" size="30" placeholder="Nombre">';
        mk += '<td><input name="cedgf' + i + '" id="cedgf' + i + '" type="text" value="0" class="form-control input-sm" size="8" placeholder="Cédula">';
        mk += '<td><input name="fecgf' + i + '" id="fecgf' + i + '" data-id="' + i + '" type="date" class="form-control input-sm fecnac">';
        mk += '<td><select name="pargf' + i + '" id="pargf' + i + '" data-id="' + i + '" class="form-control input-sm parent"><option value="" selected></option><option value="1">Cónyuge</option><option value="2">Hijos</option><option value="3">Padres</option><option value="4">Abuelos</option><option value="5">Nietos</option><option value="6">Hermanos</option><option value="7">Tíos</option><option value="8">Sobrinos directos</option></select>';
        mk += '<td><input name="edagf' + i + '" id="edagf' + i + '" data-id="' + i + '" type="number" class="form-control input-sm edad" size="6" placeholder="00">';
        mk += '</tr>';
        $("#familia tbody").append(mk);
    }

    var currSess = "<?php echo $tok; ?>";
    $.ajax({
        type: 'POST',
        url: '/phps/sfunera/proceso.php',
        crossDomain: false,
        dataType: 'json',
        cache: 'false',
        data: {
                ced: '<?php echo $ced; ?>',
                tok: currSess
        },
        beforeSend: function(){
                $("#step-1 .cargad").show();
                $("#step-1 .panelc").hide();
        },
        error: function(){
        }
    }).done(function( res ) {
        if(res.tokfun != currSess){
                alert("Esta sesión no es igual para la carga inicial: " + res.tokfun);
        }
        if(res.error == 0) {
                $("#step-1 .cargad").slideUp();
                $("#step-1 .panelc").slideDown("slow");

                $("#nomsoc").val(res.nombre);   $("#cedsoc").val(res.cedula);
                $("#emasoc").val(res.correo);   $("#telsoc").val(res.telefo);
                $("#tipsoc").val(res.tipper);

                $("#fecdia").val(res.fecact);   $("#deupre").val(res.deupre);
                $("#deuaso").val(res.deuaso);   $("#deupat").val(res.deupat);
                $("#ahoaso").val(res.ahoaso);   $("#ahopat").val(res.ahopat);
                $("#dis80p").val(res.porc80);   $("#totpre").val(res.totpre);

                $("#dispre").val(res.dpmont);   $("#maxjor").val(res.jpmont);
                $("#conpre").text(res.dpdesc);  $("#estjor").text(res.jpdesc);
                if(res.afilia == 0){
                        $(".afilia").show();	$(".renova").hide();
                } else{
                        $(".renova").show();	$(".afilia").hide();
                }

                if(res.activo > 0){
                        $("#conpre").removeClass("text-danger").addClass("text-success");
                        $("#estjor").removeClass("text-danger").addClass("text-success");
                } else{
                        $("#errini").text(res.desact);
                        $("#errini").removeClass("text-warning").addClass("text-danger");

                        $("#conpre").removeClass("text-success").addClass("text-danger");
                        $("#estjor").removeClass("text-success").addClass("text-danger");
                        $(".btn").attr("disabled", "disabled");
                        $(".btn").removeClass("btn-primary");
                        $(".sig").hide();
                }

                $("#cedben").val(res.cedben);   $("#nomben").val(res.nomben);
                $("#telben").val(res.telben);   $("#corben").val(res.corben);
                $("#dirben").val(res.dirben);
                for (var i=1; i<=8; i++) {
                        $("#nomgf" + i).val( eval("res.nomgf" + i) );
                        var cdval = eval("res.cedgf" + i);
			if (cdval == "") cdval = 0;
                        $("#cedgf" + i).val( cdval );
                        var dtval = eval("res.fecgf" + i);
                        var daval = "";
                        if (dtval){
                                daval = dtval.split("/");
                                daval = daval[2] + "-" + daval[1] + "-" + daval[0];
                        }
                        $("#fecgf" + i).val( daval );
                        $("#pargf" + i).val( eval("res.pargf" + i) );
                        $("#edagf" + i).val( eval("res.edagf" + i) );
                }
        }
	else { console.log("error: " + res.error); }
    });

    $(".parent").change(function () {
//      alert("click en: " + $(this).attr('id') + " - dta: " + $(this).data('id'));
//      var dob = $("#" + $(this).attr('id')).val();
        var ise = $(this).data('id');
        var dob = $("#fecgf" + ise).val();
        var age = 0;
        if(dob != ''){
                var tod = new Date();
                var fre = new Date(dob);
                var age = tod.getFullYear() - fre.getFullYear();
                var mon = tod.getMonth() - fre.getMonth();
                if (mon < 0 || (mon === 0 && tod.getDate() < fre.getDate())) {
                        age--;
                }
        }
        paren = $("#pargf" + ise).val();
        if (age > 60 && paren > 4 && paren != 6) {
                pers = $("#pargf" + ise + " option:selected").text();
                alert("Favor valide que " + pers + " debe tener menos de 60 años");
                $("#fecgf" + ise).focus();
                $("#edagf" + ise).val("");
                return false;
        } else {
		var cdval = $("#cedgf" + ise).val();
		if (cdval == "") cdval = 0;
		$("#cedgf" + ise).val( cdval );
		$("#edagf" + ise).val(age);
	}
    });

    $("#selfin").change(function () {
//      var idefin = $(this).find(':selected')[0].id;
        var valfin = $(this).val();
        var ncufin = $(this).find(':selected').data('value');
        if (valfin < 0 || valfin == '') {
           alert("Elija una de las opciones de financiamiento");
           return;
        }
        else{
          $.ajax({
                type: 'POST',
                url: '/phps/sfunera/calculo.php',
                crossDomain: false,
                dataType: 'json',
                cache: 'false',
                data: {
                        ced: $("#cedsoc").val(),
                        tip: $("#tipsoc").val(),
                        dpm: $("#dispre").val(),
                        mon: $("#monfin").val(),
                        opt: valfin,
                        ncu: ncufin,
                        tok: currSess
                },
                beforeSend: function(){
                        $("#step-4 .cargad").show();
                        $("#step-4 .panelc").hide();
                },
          }).done(function( res ) {
                if(res.tokfun != currSess){
                        alert("Esta sesión no es igual para el cálculo de préstamo: " + res.tokfun);
                }
                else {
                        $("#step-4 .cargad").slideUp();
                        $("#step-4 .panelc").slideDown("slow");

                        $("#tpc").text( $("#selfin option:selected").text() );

                        var msjcal = "";
                        valmoncuo = res.moncuo;
                        if (valmoncuo != "") {
                                $("#moncuo").val( valmoncuo );
                                $("#nrocuo").val( res.nrocuo );
                                $(".cuonor").show();
                                msjcal += res.mencuo + " POR " + valmoncuo;
                        } else {
                                $(".cuonor").hide();
                        }

                        valmoncue = res.moncue;
                        if (valmoncue != "") {
                                $("#moncue").val( valmoncue );
                                $("#nrocue").val( res.nrocue );
                                $(".cuoesp").show();
                                msjcal += "<br>";
                                msjcal += res.mencue + " POR " + valmoncue;
                        } else {
                                $(".cuoesp").hide();
                        }
                        valmonafi = res.monafi;
                        $("#monafi").val( valmonafi );
                        $("#desafi").text( res.desafi );

                        if (parseFloat(valmonafi) > 0){
                                msjcal += "<br>";
                                msjcal += "AFIANZAMIENTO: " + valmonafi;
                        }
//                      $("#calcuo").html( msjcal );
                        $("#finaut").html( msjcal );
                }
          });
        }
    });

    $("#btnfin").click(function(){
        if($("#agree").is(":checked")) {
//           $("#reg").hide();
//           panPdf.show();
           frm.submit();
        }
        else {
                alert('Declare la aceptación de los términos del convenio');
        }
        return false;
    });

});
</script>

<div class="row well2 well-lg">
	<div class="col-sm-6 text-center">
		<h4>CRÉDITO SERVICIOS FUNERARIOS</h4>
	</div>
	<div class="col-sm-6 text-right">
		<p><br><?php echo JHTML::_('date', 'now', JText::_('DATE_FORMAT_LC')) . " | " . date("h:i:s a"); ?></p>
	</div>
	<br />
</div>

<div id="reg" class="fila">
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step ini col-xs-2 col-xs-offset-1"> 
                <a href="#step-1" type="button" class="btn btn-success btn-circle">1</a>
                <p><small>Titularidad</small></p>
            </div>
            <div class="stepwizard-step sig col-xs-2"> 
                <a href="#step-2" type="button" class="btn btn-default btn-circle" disabled="disabled">2</a>
                <p><small>Beneficiario</small></p>
            </div>
            <div class="stepwizard-step sig col-xs-2"> 
                <a href="#step-3" type="button" class="btn btn-default btn-circle" disabled="disabled">3</a>
                <p><small>Familiares</small></p>
            </div>
            <div class="stepwizard-step sig col-xs-2"> 
                <a href="#step-4" type="button" class="btn btn-default btn-circle" disabled="disabled">4</a>
                <p><small>Financiamiento</small></p>
            </div>
            <div class="stepwizard-step sig col-xs-2"> 
                <a href="#step-5" type="button" class="btn btn-default btn-circle" disabled="disabled">5</a>
                <p><small>Autorización</small></p>
            </div>
        </div>
    </div>
    
    <form role="form" name="sfuner" id="sfuner" method="post" action="<?php echo $rou; ?>" enctype="multipart/form-data">

        <div class="panel panel-default setup-content" id="step-1">
            <div class="panel-heading">
                 <h3 class="panel-title">Datos del Titular</h3>
            </div>

            <div class="panel-body cargad">
		<div class="loader"></div>
		<p class="text-info text-center"><br>Por favor, espere la carga de datos..</p>
            </div>

            <div class="panel-body panelc">
		<p class="text-warning" id="errini">Valide los datos del titular contratante</p>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Nombre asociado</label>
			<input type="text" name="nomsoc" id="nomsoc" value="<?php echo mb_strtoupper($datusr->firstname . ', ' . $datusr->lastname); ?>" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Cédula</label>
			<input type="text" name="cedsoc" id="cedsoc" value="<?php echo $ced; ?>" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-12">
                    	<label class="control-label">Dirección</label>
		    	<p class="form-control-static" id="diraso">
	                   <textarea name="dirsoc" id="dirsoc" required class="form-control" rows="2" placeholder="Escriba dirección de habitación"><?php echo $datusr->cb_direccion; ?></textarea>
			</p>
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Correo electrónico</label>
			<input type="text" name="emasoc" id="emasoc" value="<?php echo $datusr->email; ?>" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Teléfono</label>
			<input type="text" name="telsoc" id="telsoc" value="<?php echo $datusr->cb_telefono; ?>" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Tipo de trabajador</label>
			<input type="text" name="tipsoc" id="tipsoc" value="<?php echo $datusr->cb_tipoper; ?>" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Área de adscripción</label>
			<input type="text" name="aresoc" id="aresoc" value="<?php echo $datusr->cb_localidad; ?>" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Ahorros Asociado</label>
			<input type="text" name="ahoaso" id="ahoaso" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Aportes Patrono</label>
			<input type="text" name="ahopat" id="ahopat" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Deudas Ahorro Asociado</label>
			<input type="text" name="deuaso" id="deuaso" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Deudas Aporte Patrono</label>
			<input type="text" name="deupat" id="deupat" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">80% Disponible</label>
			<input type="text" name="dis80p" id="dis80p" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Total préstamos</label>
			<input type="text" name="totpre" id="totpre" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Disponible para préstamos</label>
			<input type="text" name="dispre" id="dispre" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Máximo de jornada</label>
			<input type="text" name="maxjor" id="maxjor" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row hidden">
		    <div class="col-sm-6">
                    	<label class="control-label">Condición para préstamo</label>
		    	<p class="form-control-static" id="conpre"></p>
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Estado para jornada</label>
		    	<p class="form-control-static" id="estjor"></p>

			<input type="text" name="fecdia" id="fecdia" readonly class="form-control sinborde hidden">
			<input type="text" name="deupre" id="deupre" readonly class="form-control sinborde hidden">
                    </div>
                </div>
                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
            </div>
        </div>
        
        <div class="panel panel-default setup-content" id="step-2">
            <div class="panel-heading">
                 <h3 class="panel-title">Beneficiario por fallecimiento</h3>
            </div>
            <div class="panel-body">
              <div class="afilia">
		<p class="text-warning">Ingrese los datos del único beneficiario por fallecimiento del titular para pago de la cláusula</p>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Nombre completo</label>
                   	<input name="nomben" id="nomben" type="text" required2 class="form-control" placeholder="Nombre y apellido del beneficiario" />
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Cédula</label>
                   	<input name="cedben" id="cedben" type="text" required2 class="form-control" placeholder="Número de cédula" />
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-6">
                    	<label class="control-label">Teléfono</label>
                   	<input name="telben" id="telben" type="text" required2 class="form-control" placeholder="Teléfono del beneficiario" />
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Correo</label>
                   	<input name="corben" id="corben" type="email" required2 class="form-control" title="Ingrese un correo válido" placeholder="Ej: correo@dominio.com" />
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-12">
                    	<label class="control-label">Dirección del beneficiario</label>
		    	<p class="form-control-static">
	                   <textarea name="dirben" id="dirben" required2 class="form-control" rows="2" placeholder="Dirección del beneficiario"></textarea>
			</p>
		    </div>
                </div>
              </div>
              <div class="renova">
		<p class="text-warning">Sus datos ya fueron registrados</p>
              </div>
                <button class="btn btn-default prevBtn pull-left" type="button">Anterior</button>
                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
            </div>
        </div>
        
        <div class="panel panel-default setup-content" id="step-3">
            <div class="panel-heading">
                 <h3 class="panel-title">Grupo familiar a suscribir</h3>
            </div>

              <div class="afilia">

            <div class="panel-body">
		<p class="text-warning">Grupo familiar contemplado por el titular en el convenio con la institución</p>
            </div>
            <div class="table-responsive">
		<table id="familia" class="table table-striped">
		   <thead>
		     <tr>
			<th>#</th>
<!--
			<th>Apellidos</th>
-->
			<th>Nombres</th>
			<th>Cédula</th>
			<th>Fec.Nacim.</th>
			<th>Parentesco</th>
			<th>Edad</th>
		     </tr>
		   </thead>
		   <tbody>
		   </tbody>
		</table>
            </div>

              </div>
              <div class="renova">
            <div class="panel-body">
		<p class="text-warning">Sus datos ya fueron registrados</p>
            </div>
              </div>

            <div class="panel-body">
                <button class="btn btn-default prevBtn pull-left" type="button">Anterior</button>
                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
            </div>
        </div>
        
        <div class="panel panel-default setup-content" id="step-4">
            <div class="panel-heading">
                 <h3 class="panel-title">Cálculo crediticio</h3>
            </div>
            <div class="panel-body">

                <div class="form-group row">
		    <div class="col-sm-6">
			<label class="control-label">Financiamiento</label>
			   <select class="form-control" name="selfin" id="selfin" required>
				<option id="finsin" value="">- Seleccione -</option>

		    	<?php if (substr($datusr->cb_tipoper,0,1) == 'O') { ?>
				<option id="finsem" value="1" data-value="8">Semanal</option>
		    	<?php } ?>
<!--
				<option id="finqui" value="1" data-value="4">Quincenal</option>
				<option id="finbon" value="2" data-value="1">Sólo Bonos</option>
-->
				<option id="finesp" value="3" data-value="1">Combinados</option>
			   </select>
                    </div>
		    <div class="col-sm-6">
                    	<label class="control-label">Monto a Financiar</label>
			<div class="input-group">
				<span class="input-group-addon">Bs</span>
				<input type="text" name="monfin" id="monfin" value="<?php echo $mon; ?>" readonly class="form-control text-right" aria-label="Monto financiado">
<!--
				<span class="input-group-addon">.00</span>
-->
			</div>
                    </div>
                </div>

                <div class="form-group row2">
		   <div class="col-xs-12">

	             <div class="cargad">
			<div class="loader"></div>
			<p class="text-info text-center"><br>Por favor, espere la carga de datos..</p>
	             </div>

	             <div class="panelc well well-lg">
			<h4 id="calcuo" class="text-success text-center hidden"></h4>

	                <div class="form-group row cuonor">
			    <div class="col-sm-6">
				<label class="control-label">Número de Cuotas <span id="tcu"></span></label>
				<input type="text" name="nrocuo" id="nrocuo" readonly class="form-control text-center">
	                    </div>
			    <div class="col-sm-6">
	                    	<label class="control-label">Pago requerido</label>
				<input type="text" name="moncuo" id="moncuo" readonly class="form-control text-right">
	                    </div>
	                </div>
	                <div class="form-group row cuoesp">
			    <div class="col-sm-6">
				<label class="control-label">Número de Cuotas Especiales</span></label>
				<input type="text" name="nrocue" id="nrocue" readonly class="form-control text-center">
	                    </div>
			    <div class="col-sm-6">
	                    	<label class="control-label">Pago requerido</label>
				<input type="text" name="moncue" id="moncue" readonly class="form-control text-right">
	                    </div>
	                </div>
	                <div class="form-group row">
			    <div class="col-sm-6">
	                    	<label class="control-label">Descripción</label>
			    	<p class="form-control-static" id="desafi"></p>
	                    </div>
			    <div class="col-sm-6">
				<label class="control-label">Monto Afianzamiento</span></label>
				<input type="text" name="monafi" id="monafi" readonly class="form-control text-right">
	                    </div>
	                </div>

	             </div>

		   </div>
                </div>

		<br />
                <button class="btn btn-default prevBtn pull-left" type="button">Anterior</button>
                <button class="btn btn-primary nextBtn pull-right" type="button">Siguiente</button>
            </div>
        </div>

        <div class="panel panel-default setup-content" id="step-5">
            <div class="panel-heading">
                 <h3 class="panel-title">Completar Autorización</h3>
            </div>
            <div class="panel-body">

                <div class="form-group row">
		    <div class="col-sm-8">
                    	<label class="control-label">Nombre asociado</label>
			<input type="text" name="nom" id="nom" readonly class="form-control sinborde">
                    </div>
		    <div class="col-sm-4">
                    	<label class="control-label">Cédula</label>
			<input type="text" name="ced" id="ced" readonly class="form-control sinborde">
                    </div>
                </div>
                <div class="form-group row">
		    <div class="col-sm-8">
			<label class="control-label">Financiamiento</label>
		    	<p class="form-control-static text-primary" id="finaut"></p>
                    </div>
		    <div class="col-sm-4">
                    	<label class="control-label">Monto a Financiar</label>
			<div class="input-group">
				<span class="input-group-addon">Bs</span>
				<input type="text" name="monfin0" id="monfin0" value="<?php echo $mon; ?>" readonly class="form-control text-right" aria-label="Monto financiado">
<!--
				<span class="input-group-addon">.00</span>
-->
			</div>
                    </div>
                </div>

                <div class="form-group row">
		   <div class="col-xs-12">
		    <label class="control-label">Términos y condiciones</label>
	             <div style="border: 1px solid #e5e5e5; height: 132px; overflow: auto; padding: 10px;">
<p><b>AUTORIZO</b> a la <b>CAPUNEFM</b> para que descuente la cantidad definida en las cuotas que la misma 
designe en el compromiso de pago para la cancelación del financiamiento seleccionado para el pago de los 
beneficios señalados en el presente convenio, contratado con la empresa Necrópolis Funeral C.A. Igualmente 
<u><b>DECLARO</b></u> que los datos expresados en esta planilla son fidedignos y si fueren falsos acepto 
la no prestación del servicio ni cobro de la cláusula por servicios no prestados. Queda establecido que 
no podre desafiliarme mientras esté vigente el convenio respectivo.</p>
	             </div>
		   </div>
                </div>
                <div class="form-group row">
		   <div class="col-xs-12">
			<div class="checkbox">
			    <label>
	                    <input type="checkbox" name="agree" id="agree" value="1" required /> 
				ACEPTO todas las condiciones establecidas.
	                    </label>
        	    	</div>
		   </div>
		</div>
		<br />
                <button class="btn btn-default prevBtn pull-left" type="button">Anterior</button>
                <button class="btn btn-success pull-right" id="btnfin" type="button">Finalizar!</button>
            </div>
        </div>

    </form>
</div>

<?php
  // fin agree
  }
  else {
   // registrar y ver pdf
   $updf = "";
   $errpri = "";
   if ( !file_exists($epdf) ) {
//  $agree = ( file_exists($epdf) ) ? 1 : $agree;

        $monafi = (isset($_REQUEST["monafi"])) ? $_REQUEST["monafi"] : 0;
        $dirsoc = (isset($_REQUEST["dirsoc"])) ? $_REQUEST["dirsoc"] : "";
        $dirsoc = $vlib->str_to_utf8($dirsoc);

        $cn = $vlib->guardarTXT($rdir, $ced, $dirsoc, $monafi);
        $ln = explode("\n", $cn);

        if ( count($ln) > 0 ) {
//              unlink( $file_socio );

           $gdir = $vlib->actDirUsuario($ced, $dirsoc);
//           if ($gdir == 0) $errpri = "registro de dirección de asociado";

           $epdf = $vlib->generarpdf($ced, $docr, $monafi);
        }
   }

   if ( file_exists($epdf) ) {
        $updf = JURI::base() . "pdfs/" . $vlib->getRutapdf() . "/" . $ced . ".pdf";
//echo $updf;
//   } else {
//        $errpri = (!empty($errpri)) ? ($errpri . " y en planillas") : "planillas";
   }
?>

<div id="pdf">
  <div class="panel panel-success">
    <div class="panel-heading">Registro exitoso</div>
    <div class="panel-body">
	<div class="well">
		Documentos a consignar y enviar a crediwebcapunefm@gmail.com
		<ul>
			<li>Solicitud de Préstamo</li>
			<li>Compromiso de pago</li>
			<li>Afianauco (si lo requiere)</li>
		</ul>
<!--
		<br>
                ESPERAR JORNADA DE RECOLECCION DE SOLICITUDES EN EL AREA 
                CORRESPONDIENTE SEGUN CRONOGRAMA PUBLICADO PREVIAMENTE
-->
	</div>
	<hr style="border-top: 1px dotted #8c8b8b; width: 80%;">
<?php
	if ( !empty($updf) ){
?>
	<h5>Planillas generadas</h5>
	<div class="text-center">{pdf=<?php echo $updf; ?>|100%|500}</div>
<?php
	} else {
?>
	<div class="alert alert-danger">
	   <strong>Error en <?php echo $errpri; ?>!</strong> Reingrese a la sesión de asociado o contacte al administrador
	</div>
<?php
	}
?>
	<div class="text-right">
	   <a href="index.php?option=com_comprofiler&task=logout" class="btn btn-info" role="button">Cerrar sesión</a>
	</div>
    </div>
  </div>
</div>
<?php
  } // fin else agree
} // fin empty ced

?>
