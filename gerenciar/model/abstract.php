<?php
	require_once "classes/conexao.php";

	class ClassAbstract {

		/**
		 * Inserir os dados no banco de dados
		 * @param [object] $dados com todas informações a ser inseridas.
		 */
		public function Inserir($dados) {
			try {
				$count=0;
				$infoCampos = "";
				$infoTags = "";

				foreach ($this->campos as $k => $v) {
					$infoCampos .= ($count==0) ? $k : ', '.$k;
					$infoTags .= ($count==0) ? ':'.$k : ', :'.$k;
					$count++;
				}

				foreach ($dados as $k => $v) {
					$infoDados[":$k"] = $v;
				}
				$sql = "INSERT INTO $this->tabela ( $infoCampos ) VALUES ( $infoTags )";
				$op = Conexao::getInstance()->prepare($sql);
				return $op->execute($infoDados);
			}
			catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
				print_r ($e);
			}
		}

		/**
		 * Editar os dados no banco de dados
		 * @param [object] $dados com todas informações a ser editada.
		 */
		public function Editar($dados) {
			try {
				$count=0;
				$infoUpdate = "";

				foreach ($this->campos as $k => $v) {
					if($k!="id"):
						$infoUpdate .= ($count==0) ? "$k = :$k" : ", $k = :$k";
						$count++;
					endif;
				}
				foreach ($dados as $k => $v) {
					$infoDados[":$k"] = $v;
				}
				$sql = "UPDATE $this->tabela set $infoUpdate WHERE id = :id";

                $op = Conexao::getInstance()->prepare($sql);

				return $op->execute($infoDados);
			}
			catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
				print_r ($e);
			}
		}

		/**
		 * Deleta um registro
		 * @param [int] $id recebe a id do registro a ser deletado.
		 */
		public function Deletar($id) {
			try {
				$sql = "DELETE FROM $this->tabela WHERE id = :id";
				$op = Conexao::getInstance()->prepare($sql);
				$op->bindValue(":id", $id);
				return $op->execute();
			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
				print_r ($e);
			}
		}

		/**
		 * BuscarPorCOD encontra o registro usando o id
		 * @param [int] $id recebe o id do registro a ser encontrado.
		 */
		public function BuscarPorCOD($id, $cls=true) {
			try {
				if($cls):
					if(is_array($this->relation)):
						$sql = "SELECT $this->select FROM $this->tabela, ".$this->relation['tabela']." WHERE $this->tabela.id = :cod AND ".$this->relation['campo'] ;
          		else:
            		$sql = "SELECT $this->select FROM $this->tabela WHERE id = :cod";
               endif;   
            else:
         		$sql = "SELECT * FROM $this->tabela WHERE id = :cod";
            endif;
 
 				$op = Conexao::getInstance()->prepare($sql);
				$op->bindValue(":cod", $id);
				$op->execute();
				$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

				return (object) array(
					"status" => 200,
					"data" => $dados
				);

			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
				print_r($e);
			}
		}

		/**
		 * BuscarTodos os registros
		 */
		public function BuscarTodos() {
			try {                
                if(is_array($this->relation)):
                    $sql = "SELECT $this->select FROM $this->tabela, ".$this->relation['tabela']." WHERE ".$this->relation['campo'] ;
                else:
                    $sql = "SELECT $this->select FROM $this->tabela";
                endif;

				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();
				$dados = (object) $op->fetchall(PDO::FETCH_ASSOC);

				return (object) array(
					"status" => 200,
					"data" => $dados
				);
			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
				print_r($e);
			}
		}

		/**
		 * Encontra o ultimo registro.
		 */
		public function UltimoRegistro() {
			try {
				$sql = "SELECT * FROM $this->tabela ORDER BY id DESC LIMIT 1 ";
				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();
				$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

				return (object) array(
					"status" => 200,
					"data" => $dados
				);

			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
				print_r($e);
			}
		}

		/*
		* buscar permissões
		*/
		public static function buscaPermissoes($token,$id)
		{
			// gerando data para verificar validade do token
			$date = date_create();
			$dateNow = date_format($date, 'Y-m-d H:i:s');

			// buscar token
			$sql = "SELECT tb_medico_id as id_medico FROM tb_users WHERE tb_users.token = '$token' and tb_users.validtoken >= '$dateNow' and tb_users.tb_medico_id = '$id'";
			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();
			$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);

			// token valido 
			if(@ $retorno > 1):
	
			else:
				// buscar usuario e senha
				$sql = "SELECT * FROM tb_users WHERE tb_users.login = '$login' and tb_users.pass = '$pass'";
				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();
				$usuario = (object) $op->fetch(PDO::FETCH_ASSOC);
				
				if(!empty($usuario)):
					if($usuario->validtoken <  $dateNow):
						return (object) array(
							"status" => 200,
							"data" => $usuario
						);
					else:
						$objDados->token = $this->gerarToken($dados['login'], $dados['pass']);
						$objDados->pass = $this->criptografarSenha($dados['login'], $dados['pass']);
						$objDados->validtoken = $this->getDateToken();
						if($this->processando('PUT', $objDados, $this->permissoes, $op))
							return array(
								"status" => 200,
								"msg" => "Token do usuário atualizado com sucesso.",
								"data" => $objDados
							);
					endif;
				else:
					return (object) array(
						"status" => 403,
						"msg" => "Não foi possivel encontrar o usuario."
					);
				endif;
			endif;

			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();
			$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);
			return $retorno->id_medico;
		}

		/**
		 * Executar
		 */
		public static function executar($sql, $fetch) {
			try {
				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();			
				switch ($fetch) {
					case 'all':
						return (object) $op->fetchall(PDO::FETCH_ASSOC);
						break;
					case 'one':
						return (object) $op->fetch(PDO::FETCH_ASSOC);
					default:
						return (object) $op->fetchall(PDO::FETCH_ASSOC);
						break;
				}

			} catch (Exception $e) {
				print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
				print_r($e);
			}
		}
	}
?>