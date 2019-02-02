<?php
require_once "classes/conexao.php";
require_once "model/doenca.php";
require_once "model/usuario.php";

class DoencaController extends DoencaModel {

	public static function post($objDados, $admin=false)
	{
		if(!$admin){
	    	$info = UsuarioController::atualizarPermissoes();
    	}

    	// verificar se o usuario é o dono da informação
    	if( ($info->valido == "valido") || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();
			
			foreach (static::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}

	        if(isset($dados['op']))
				$op = $dados['op'];

			$retornoDoenca = parent::Inserir(static::$tabela,$objDados, static::$campos);

			static::saveDoencaSintoma($retornoDoenca->data->id,$dados['sintomas']);
			return $retornoDoenca;

		}else{
			return $info;
		}
	}

	public static function saveDoencaSintoma($doenca, $sintomas)
	{
        try {
        	$sint = explode(',', $sintomas);
        	foreach ($sint as $k => $v) {
	            $sql = "INSERT INTO tb_doencas_sintomas ( tb_doencas_id, tb_sintomas_id ) VALUES ( $doenca, $v )";
	            $op = Conexao::getInstance()->prepare($sql);
	            $op->execute();
        	}
        	return('ok');
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }

    
	}

}
?>