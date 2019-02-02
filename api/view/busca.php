<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if($_GET['cidade']>0):
	    $valor = BuscaController::Buscar($_GET['cidade']);
	else:
    	$valor = BuscaController::Buscar();
	endif;
	
    http_response_code($valor->status);
    echo ($valor);
endif;
?>