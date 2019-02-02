<?php
// cria uma informação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $obj->post();    
    echo json_encode($valor);
    http_response_code($valor->status);
}

// atualiza uma informação
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $valor = $obj->put();    
    echo json_encode($valor);
    http_response_code($valor->status);
}

// deleta uma informação
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if($_GET['id']!=""):  

        $valor = $obj->delete(true);
        echo json_encode($valor);
        http_response_code($valor->status);
    else:
        $erro = array ("erro" => "Não foi possivel deletar o registro");
        echo json_encode($erro);
        http_response_code($valor->status);
    endif;
}

?>