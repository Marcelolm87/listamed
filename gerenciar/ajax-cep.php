<?php
	require_once("model/consultorio.php");
	if($_GET['cep']!=""):
		$retorno = ConsultorioController::BuscarPorNome($_GET['cep']);
		echo json_encode($retorno);
	endif;
?>