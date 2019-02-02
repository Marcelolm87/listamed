<?php
/* retorna as informações */
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if(@ $_GET['id']!=""):
        if(@ $_GET['filter'] == "medico" ):
            $valor = EspecialidadeController::BuscarPorCODMedico("tb_medico_id");    
        else:
            $valor = EspecialidadeController::BuscarPorCOD();
        endif;
    else:
        $valor = EspecialidadeController::BuscarTodos();    
    endif;
    http_response_code($valor->status);
    echo json_encode($valor);
endif;

// cria uma informação
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if($_GET['action']=="cadMedEsp"){
        $valor = EspecialidadeController::saveEspecialidade($_POST['medico'], $_POST['especialidade']);
    }else{
        $valor = $obj->post();    
    }

    echo json_encode($valor);
    http_response_code($valor->status);
}

/*// atualiza uma informação
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    $valor = $obj->put();    
    echo json_encode($valor);
    http_response_code($valor->status);
}*/

// deleta uma informação
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  
    if($_GET['action']=="cadMedEsp"){
        $valor = EspecialidadeController::deletarEspecialidade($_POST['medico'], $_POST['especialidade']);
    }else{
    /*    if($_GET['id']!=""):  
            $valor = ConsultorioController::delete();
            echo json_encode($valor);
            http_response_code($valor->status);
        else:
            $erro = array ("erro" => "Não foi possivel deletar o registro");
            echo json_encode($erro);
            http_response_code($valor->status);
        endif;*/
    }



}


?>