<?php
require_once("model/medico.php");
if($_POST['acao']=="delete") :
	if(($_POST['experiencia'])&&($_POST['codigoMedico'])):
		$experiencia = $_POST['experiencia'];
		$codigoMedico = $_POST['codigoMedico'];
		$retorno = MedicoModel::deleteMedicoExperiencia($experiencia, $codigoMedico);
		echo json_encode($retorno);
	endif;
endif;
?>