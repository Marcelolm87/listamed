<?php
/* retorna as informações */
if ($_SERVER['REQUEST_METHOD'] === 'GET') :
    if($_GET['id']!=""):
    	if( $_GET['filter'] == "medico" ):
	        $valor = $obj->BuscarPorCODMedico($_GET['id']);    
       	else:
       		$valor = $obj->BuscarPorCOD($_GET['id']);
   		endif;
    else:
        $valor = $obj->BuscarPorCODMedico($_GET['id']);    
    endif;
    echo json_encode($valor);
endif;

if( $_GET['filter'] != "medico" ):
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
endif;
?>