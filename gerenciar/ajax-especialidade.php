<?php
require_once("model/medico.php");
if($_POST['acao']=="add"):
	if(($_POST['especialidade'])&&($_POST['codigoMedico'])):
		$especialidade = $_POST['especialidade'];
		$codigoMedico = $_POST['codigoMedico'];

		$retorno = MedicoModel::saveMedicoEspecialidade($especialidade, $codigoMedico);
		echo json_encode($retorno);
	endif;
elseif ($_POST['acao']=="delete") :
	if(($_POST['especialidade'])&&($_POST['codigoMedico'])):
		$especialidade = $_POST['especialidade'];
		$codigoMedico = $_POST['codigoMedico'];

		$retorno = MedicoModel::deleteMedicoEspecialidade($especialidade, $codigoMedico);
		echo json_encode($retorno);
	endif;
endif;
?>