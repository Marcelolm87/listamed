<?php

// criar um novo usuario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_POST['login'] = $_SERVER['PHP_AUTH_USER'];
    $_POST['pass'] = $_SERVER['PHP_AUTH_PW'];

    $valor = $obj->save();    
    http_response_code($valor['status']);
    echo json_encode($valor);
}

// criar um novo usuario
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $valor = UsuarioController::atualizarPermissoes();   
    http_response_code($valor->status);
    echo json_encode($valor);
}


?>