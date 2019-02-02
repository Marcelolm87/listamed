<?php
require_once("model/servico.php");
if($_POST['acao']=="add"):
/*	if(($_POST['consultorio'])&&($_POST['codigoMedico'])):
		$consultorio = $_POST['consultorio'];
		$codigoMedico = $_POST['codigoMedico'];

		$retorno = MedicoModel::saveMedicoConsultorio($consultorio, $codigoMedico);
		echo json_encode($retorno);
	endif;*/
elseif ($_POST['acao']=="delete") :
	if(($_POST['servico'])&&($_POST['consultorio'])):
		$consultorio = $_POST['consultorio'];
		$servico = $_POST['servico'];
		$retorno = ServicoModel::deleteServicoConsultorio($servico, $consultorio);
		echo json_encode($retorno);
	endif;
endif;
?>