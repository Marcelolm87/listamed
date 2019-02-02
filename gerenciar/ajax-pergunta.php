<?php
require_once("model/pergunta.php");
if($_POST['acao']=="add"):
/*	if(($_POST['consultorio'])&&($_POST['codigoMedico'])):
		$consultorio = $_POST['consultorio'];
		$codigoMedico = $_POST['codigoMedico'];

		$retorno = MedicoModel::saveMedicoConsultorio($consultorio, $codigoMedico);
		echo json_encode($retorno);
	endif;*/
elseif ($_POST['acao']=="delete") :
	if(($_POST['pergunta'])):
		$pergunta = $_POST['pergunta'];
		$retorno = PerguntaModel::delete($pergunta);
		echo json_encode($retorno);
	endif;
endif;
?>