<?php
/*********************************
* configurações
*********************************/
$campos = array (
    array ( "nome" => "nome",   "tipo" => "text", "placeholder" => "nome"   ),
    array ( "nome" => "sigla",  "tipo" => "text", "placeholder" => "sigla"  ),
);

$endereco = "/api/estado/";

/* retorna as informações */
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if($_GET['id']!=""):
        $valor = $obj->BuscarPorCOD($_GET['id']);    
    else:
        $valor = $obj->BuscarTodos();    
    endif;
    echo json_encode($valor);
endif;


/* cria uma informação */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $valor = $obj->save();    
    echo json_encode($valor);
}

/* atualiza uma informação */
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $valor = $obj->save();    
    echo json_encode($valor);
}

/* deleta uma informação */
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if($_GET['id']!=""):
        $valor = $obj->BuscarPorCOD($_GET['id']);    
        $valor = $obj->delete($valor);
        echo json_encode($valor);
    else:
        $erro = array ("erro" => "Não foi possivel deletar o registro");
        echo json_encode($erro);
    endif;
    
}

?>