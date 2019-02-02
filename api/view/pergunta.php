<?php
	if(trim($_GET['busca'])!=""):
    	$valor = PerguntaController::BuscarPergunta($_GET['busca']);
    	http_response_code($valor->status);
    	echo json_encode($valor);
	else:	
	    $valor = PerguntaController::BuscarTodos();
	    http_response_code($valor->status);
	    echo json_encode($valor->data);
	endif;


?>