<?php
error_reporting(E_ALL);
ini_set('display_errors', 0);

/* retorna as informações */
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if(@ $_GET['id']!=""):
    	if(@ $_GET['filter'] == "medico" ):
	        $valor = $obj->BuscarPorCODMedico($_GET['id']);    
       	else:
       		$valor = $obj->BuscarPorCOD($_GET['id']);
   		endif;
    else:
        $valor = $obj->BuscarTodos();    
    endif;
    http_response_code($valor->status);
    echo json_encode($valor);
endif;

// cria uma informação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $obj->save();    
    echo json_encode($valor);
    http_response_code($valor['status']);
}

// atualiza uma informação
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $valor = $obj->save();    
    echo json_encode($valor);
    http_response_code($valor['status']);
}

// deleta uma informação
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if($_GET['id']!=""):
        $valor = $obj->BuscarPorCOD($_GET['id']);    
        $valor = $obj->delete($valor);
        echo json_encode($valor);
        http_response_code($valor['status']);
    else:
        $erro = array ("erro" => "Não foi possivel deletar o registro");
        echo json_encode($erro);
        http_response_code($valor['status']);
    endif;
}

?>
