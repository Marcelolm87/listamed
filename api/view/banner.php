<?php

	if ($_SERVER['REQUEST_METHOD'] === 'GET') :
	    if(@ $_GET['id']!=""):
	        $valor = BannerController::BuscarPorCOD();
	    elseif($_GET['buscar']):
	        $valor = BannerController::BuscarBanners($_GET['buscar']);    
	    else:
	        $valor = BannerController::BuscarBanners('todos');    
	        //$valor = BannerController::BuscarTodos();    
	    endif;
	    http_response_code($valor->status);
	    echo json_encode($valor);
	endif;
?>