<?php
	require_once "classes/conexao.php";
	require_once "model/abstract.php";

	class ControllerAbstract extends ClassAbstract {

		/**
		 * preparando os dados
		 * @param  [string] $metodo metodo de envio
		 * @param  [object] $dados do registro
		 * @return [object] Codigo do retorno e mensagem (as vezes dados).
		 */
		function save($metodo=null)
		{
			//$op = null;
			//$dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);
			//$token = (isset($_SERVER['HTTP_TOKEN'])) ? $_SERVER['HTTP_TOKEN'] : '' ;
			
			//echo "<pre>"; print_r($_SERVER); echo "</pre>";


			/*$user['login'] =  
			$user['pass'] = */

			//if($token!=""):
				//$id_medico = parent::buscaPermissoes($token,$dados['tb_medico_id']);


				//if($id_medico>0):
					$objDados = $this->getCampos();
					foreach ($this->campos as $key => $value) {
						$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
					}
		            if(isset($dados['op']))
						$op = $dados['op'];

					if($_GET['editar']!=""):
						$objDados->id = $_GET['editar'];
					endif;

					$retorno = $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);			
					if($_SERVER['REQUEST_METHOD']=="POST"):
						return array(
							"status" => 201,
							"msg" => "Registro inserido com sucesso."
						);
					else:
						return array(
							"status" => 201,
							"msg" => "Registro alterado com sucesso.",
							"data" => $objDados
						);
					endif;

				//else:
				//	return array(
				//		"status" => 201,
				//		"msg" => "Você não tem permissão para executar essa ação.",
				//	);
				//endif;
			//else:
			//	return array(
			//			"status" => 201,
			//			"msg" => "Você não tem permissão para executar essa ação.",
			//		);
			//endif;

		}

		/**
		 * chamando as funções conforme o tipo de requisição
		 * @param  [string] $metodo metodo de envio
		 * @param  [object] $dados      informações do registro
		 * @param  [array]  $permissoes permissões do usuario
		 * @return [object] Codigo do retorno e mensagem (as vezes dados).
		 */
		function processando ($metodo, $dados = null, $permissoes = array(), $op = null)
		{
            $info = null;
			/**
			 * verificando o metodo request da pagina
			 * @var [string] get/post/put/delete
			 */
			if($metodo=="GET")
			{
				/**
				 * verifica se tem permissão para executar esse função
				 */
				if($permissoes['get'])
				{
					if($op =="editar")
					{
						$info = $this->get($dados);
					}
					else if($op =="deletar")
					{
						$info = $this->delete($dados);
					}
					return json_decode($info);
				}
			}
			elseif($metodo=="POST")
			{

  				/**
				 * verifica se tem permissão para executar esse função
				 */
				if($permissoes['post'])
				{
            		if(@$dados->id > 0)
					{
						$info = $this->put($dados);
					}
					else
					{
						$info = $this->post($dados);
					}
				}
				return $info;
			}
            elseif($metodo=="PUT")
			{
				/**
				 * verifica se tem permissão para executar esse função
				 */
                if($permissoes['put'])
				{
            		if(isset($dados->id))
					{
                        $info = $this->put($dados);
					}
				}
				return $info;
			}
		}

		/**
		 * retornando os campos
		 * @return [object] dados
		 */
		public function getCampos() {
			return (object) $this->campos;
		}

		/**
		 * Verifica se o request é get, post, put ou delete
		 * @param  [object] $metodo recebe o $_REQUEST
		 * @return [array] com os dados recebidos pelo request
		 */
		function retornaRequest($metodo)
		{
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

		/**
		 * Busca informações de todos os registrou ou de 1 id
		 * @param  [object] $value com o id a ser buscado
		 * @return [object] retorna todos registros ou 1 do id
		 */
		public function get($value = null)
		{
			$dados = new StdClass;
			if(isset($value->id)):
				$dados->dados = $this->BuscarPorCOD($value->id);
				return json_encode($dados);
			else:
				$dados->dados = $this->BuscarTodos();
				return json_encode($dados);
			endif;
		}

		/**
		 * inserir o registro
		 * @param  [object] $value todas informações a ser inserida
		 * @return [object] retorna se o insert foi ou não executado
		 */
		public function post($value = null)
		{
			$retorno = $this->Inserir($value);
			return json_encode($retorno);
		}

		/**
		 * deletar um registro
		 * @param  [object] $value com o id a ser deletado
		 * @return [object] retorna se o delete foi ou não executado
		 */
		public function delete($value = null, $id=true)
		{
			$retornoDel = ($id===true) ? $this->Deletar($value->id) : $this->Deletar($value);
			$dados = json_encode($retornoDel);
			return array(
				"status" => 204,
				"msg" => "Registro deletado com sucesso.",
				"dados" => $dados
			);
		}


		/**
		 * atualizar um registro
		 * @param  [object] $value todas as informações e id a ser atualizadas
		 * @return [object] retorna se o updade foi ou não executado
		 */
		public function put($value = null)
		{
			$retorno = $this->Editar($value);
			return json_encode($retorno);
		}

	}
?>
