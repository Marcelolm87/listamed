<?php
require_once("model/galeria.php");
if($_POST['acao']=="add"):
/*	if(($_POST['consultorio'])&&($_POST['codigoMedico'])):
		$consultorio = $_POST['consultorio'];
		$codigoMedico = $_POST['codigoMedico'];

		$retorno = MedicoModel::saveMedicoConsultorio($consultorio, $codigoMedico);
		echo json_encode($retorno);
	endif;*/
elseif ($_POST['acao']=="delete") :
	if(($_POST['imagem'])&&($_POST['consultorio'])):
		$consultorio = $_POST['consultorio'];
		$imagem = $_POST['imagem'];
		$retorno = GaleriaModel::deleteImagem($imagem, $consultorio);
		echo json_encode($retorno);
	endif;
endif;
?>