<?php
    $valor = PageController::BuscarPagina();
    $valor->destaques = PageController::BuscarMedicosDestaque();
    http_response_code($valor->status);
    echo json_encode($valor);
?>