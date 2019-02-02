<?php
/* retorna as informações */
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if(@ $_GET['id']!=""):
        if(@ $_GET['full']!=""):
            $valor = MedicoController::getFull();
        else :
            $valor = MedicoController::BuscarPorCOD();
        endif;
    else :
        if(@ $_GET['full']!=""):
            $valor = MedicoController::getAllFull();
        else :
            $valor = MedicoController::BuscarTodos();    
        endif;


    endif;
    http_response_code($valor->status);
    echo json_encode($valor);
endif;

// cria uma informação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_POST['cadastro']=="ok"):
        $valor = $obj->postCadastro();    
        echo json_encode($valor);
        http_response_code($valor->status);
    else:
        $valor = $obj->post();    
        echo json_encode($valor);
        http_response_code($valor->status);
    endif;
}

// atualiza uma informação
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $valor = $obj->put();    
    echo json_encode($valor);
    http_response_code($valor->status);
}

// deleta uma informação
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    $valor = $obj->delete();
    echo json_encode($valor);
    http_response_code($valor->status);
}
?>