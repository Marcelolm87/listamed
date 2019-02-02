<?php
/* retorna as informações */
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if(@ $_GET['id']!=""):
        if(@ $_GET['filter'] == "medico" ):
            $valor = DoencaController::BuscarPorCODMedico("tb_medico_id");    
        else:
            $valor = DoencaController::BuscarPorCOD();
        endif;
    else:
        $valor = DoencaController::BuscarTodos();    
    endif;
    http_response_code($valor->status);
    echo json_encode($valor);
endif;

// cria uma informação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $obj->post();    
    echo json_encode($valor);
    http_response_code($valor->status);
}
/*
// atualiza uma informação
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $valor = $obj->put();    
    echo json_encode($valor);
    http_response_code($valor->status);
}

// deleta uma informação
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if($_GET['id']!=""):  
        $valor = DoencaController::delete();
        echo json_encode($valor);
        http_response_code($valor->status);
    else:
        $erro = array ("erro" => "Não foi possivel deletar o registro");
        echo json_encode($erro);
        http_response_code($valor->status);
    endif;
}
*/

?>