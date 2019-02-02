<?php
require_once("model/medico.php");
if($_POST['acao']=="add"):
	if(($_POST['convenio'])&&($_POST['codigoMedico'])):
		$convenio = $_POST['convenio'];
		$codigoMedico = $_POST['codigoMedico'];

		$retorno = MedicoModel::saveMedicoConvenio($convenio, $codigoMedico);
		echo json_encode($retorno);
	endif;
elseif ($_POST['acao']=="delete") :
	if(($_POST['convenio'])&&($_POST['codigoMedico'])):
		$convenio = $_POST['convenio'];
		$codigoMedico = $_POST['codigoMedico'];
		$retorno = MedicoModel::deleteMedicoConvenio($convenio, $codigoMedico);
		echo json_encode($retorno);
	endif;
endif;
?>