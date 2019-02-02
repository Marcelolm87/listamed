<?php
	require_once "classes/conexao.php";
	require_once "model/abstract.php";

	class ControllerAbstract extends ClassAbstract {

	    public static function buscarTodos()
	    {
	    	$controller = ucfirst($_GET['page'])."Controller";
			return parent::BuscarTodos($controller::$tabela,$controller::$relation,$controller::$select);
	    }
    
	    public static function BuscarPorCOD($id)
	    {
			$controller = ucfirst($_GET['page'])."Controller";
			return parent::BuscarPorCOD($controller::$tabela,$controller::$relation,$controller::$select, $_GET['id']);
	    }

		public static function BuscarPorCODMedico($campo)
		{
			$controller = ucfirst($_GET['page'])."Controller";
			$tabela = $controller::$tabela;
			$id = $_GET['id'];

			$sql = "SELECT * FROM $tabela WHERE $tabela.$campo = $id";
			$dados = parent::executar($sql, 'all');

			if(!empty($dados)){
				return array(
					"status" => 200,
					"data" => $dados
				);
			} else {
				return array(
					"status" => 200,
					"data" => "Nada encontrado"
				);
			}
		}

	    public static function post($controller = null)
	    {
	    	if($controller == null)
		    	$controller = ucfirst($_GET['page'])."Controller";
			else
		    	$controller = ucfirst($controller)."Controller";
	    	
	    	$info = UsuarioController::atualizarPermissoes();

	    	if($info->valido == "valido"){
				$dados = ControllerAbstract::retornaRequest();
				foreach ($controller::$campos as $key => $value) {
					$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
				}
	            if(isset($dados['op']))
					$op = $dados['op'];

				if(array_key_exists("tb_medico_id", $objDados))
					$objDados->tb_medico_id = $info->data->tb_medico_id;

				return parent::Inserir($controller::$tabela,$objDados, $controller::$campos);
			}else{
				return $info;
			}
	    }

	    public static function put($admin=false)
	    {
	    	$controller = ucfirst($_GET['page'])."Controller";
	    	if(!$admin){
		    	$info = UsuarioController::atualizarPermissoes();
		    	$dono = UsuarioController::pertenceUsuario($controller::$tabela,'tb_medico_id',$info->data->tb_medico_id,$_GET['id']);
	    	}

	    	// verificar se o usuario é o dono da informação
	    	if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {
				$dados = ControllerAbstract::retornaRequest();
				foreach ($controller::$campos as $key => $value) {
					$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
				}
	            if(isset($dados['op']))
					$op = $dados['op'];

				if(array_key_exists("tb_medico_id", $objDados))
					$objDados->tb_medico_id = $info->data->tb_medico_id;
	
				$objDados->id = $_GET['id'];

				return parent::Editar($controller::$tabela,$objDados, $controller::$campos);
			}else{
				return array(
					"status" => 403,
					"data" => "Acesso negado"
				);
			}
	    }

		public function delete($admin=false)
		{
			$controller = ucfirst($_GET['page'])."Controller";
	    	if(!$admin){
	    		$info = UsuarioController::atualizarPermissoes();
	    		$dono = UsuarioController::pertenceUsuario($controller::$tabela,'tb_medico_id',$info->data->tb_medico_id,$_GET['id']);	
			}
	    	// verificar se o usuario é o dono da informação
	    	if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {
				parent::Deletar($controller::$tabela,$_GET['id']);
				return array(
					"status" => 200,
					"msg" => "Registro deletado com sucesso.",
				);
			}else{
				return array(
					"status" => 403,
					"msg" => "Você não tem permissão para executar essa ação.",
				);
			}
		}

		/**
		 * Verifica se o request é get, post, put ou delete
		 * @param  [object] $metodo recebe o $_REQUEST
		 * @return [array] com os dados recebidos pelo request
		 */
		function retornaRequest()
		{
			$metodo = $_SERVER['REQUEST_METHOD'];
			$dadosRequisicao = array();

			if($metodo=="GET"):
				$dadosRequisicao = $_GET;
			elseif ($metodo=="POST"):
				$dadosRequisicao = $_POST;
			elseif ($metodo=="PUT"):
				parse_str(file_get_contents('php://input'), $dadosRequisicao);
			elseif ($metodo=="DELETE"):
				parse_str(file_get_contents('php://input'), $dadosRequisicao);
			endif;

			return $dadosRequisicao;
		}


	}
?>