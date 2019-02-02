<?php
	require_once("model/medico.php");
	require_once("model/consultorio.php");

	if($_POST['acao']=="add"):
		if(($_POST['consultorio'])&&($_POST['codigoMedico'])):
			$consultorio = $_POST['consultorio'];
			$codigoMedico = $_POST['codigoMedico'];

			$retorno = MedicoModel::saveMedicoConsultorio($consultorio, $codigoMedico);
			echo json_encode($retorno);
		endif;
		if(($_POST['convenio'])&&($_POST['codigoConsultorio'])):
			$convenio = $_POST['convenio'];
			$codigoConsultorio = $_POST['codigoConsultorio'];

			$retorno = ConsultorioController::saveConsultorioConvenio($codigoConsultorio, $convenio);
			echo json_encode($retorno);
		endif;
	elseif ($_POST['acao']=="delete") :
		if(($_POST['consultorio'])&&($_POST['codigoMedico'])):
			$consultorio = $_POST['consultorio'];
			$codigoMedico = $_POST['codigoMedico'];
			$retorno = MedicoModel::deleteMedicoConsultorio($consultorio, $codigoMedico);
			echo json_encode($retorno);
		endif;
		if(($_POST['convenio'])&&($_POST['codigoConsultorio'])):
			$convenio = $_POST['convenio'];
			$codigoConsultorio = $_POST['codigoConsultorio'];
			$retorno = ConsultorioController::deleteConvenioConsultorio($codigoConsultorio, $convenio);
			echo json_encode($retorno);
		endif;
	endif;
?>