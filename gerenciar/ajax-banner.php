<?php
	require_once("controller/banner.php");
	if ($_POST['acao']=="delete") :
		$retorno = BannerController::delete($_POST['id']);
		echo json_encode($retorno);
	endif;
?>