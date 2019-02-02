<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class UsuarioController extends ControllerAbstract {

	/**
	 * preparando os dados
	 * @param  [string] $metodo metodo de envio
	 * @param  [object] $dados do registro
	 * @return [object] Codigo do retorno e mensagem (as vezes dados).
	 */
	function save($metodo=null)
	{
		$op = null;
		$dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);
		$objDados = $this->getCampos();

		foreach ($this->campos as $key => $value) {
			$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
		}

		//verificar se o token está vazio ( criar usuario )
		if($objDados->token==""):
			$user = $this->buscarUserSenha($objDados);

			// login já existe
			if($user->id > 0):
				$date = date_create();
				$dateNow = date_format($date, 'Y-m-d H:i:s');
				if($user->validtoken >= $dateNow):
					unset($user->pass);
					return array(
							"status" => 200,
							"msg" => "Login e senha já existe, com token valido.",
							"data" => $user
						);
				else:
					$objDados->id = $user->id;
					$objDados->token = $this->gerarToken($dados['login'], $dados['pass']);
					$objDados->pass = $this->criptografarSenha($dados['login'], $dados['pass']);
					$objDados->validtoken = $this->getDateToken();
					if($this->processando('PUT', $objDados, $this->permissoes, $op))
						return array(
							"status" => 200,
							"msg" => "Token do usuário atualizado.",
							"data" => $objDados
						);
				endif;
			else:
				// verificar se o login já existe
				$userExist = $this->buscarUser($objDados);

				if(!empty($userExist)):
					return array(
							"status" => 203,
							"msg" => "Erro: login já existe"
						);
				else:
					$userExist = $this->buscarMedicoID($objDados);
					if(!empty($userExist)):
						return array(
							"status" => 203,
							"msg" => "Erro: este médico já tem login"
						);
					else:
						$objDados->token = $this->gerarToken($dados['login'], $dados['pass']);
						$objDados->pass = $this->criptografarSenha($dados['login'], $dados['pass']);
						$objDados->validtoken = $this->getDateToken();
						if($this->processando('POST', $objDados, $this->permissoes, $op)):
							$getID = $this->getID($objDados);
							$objDados->id = $getID['id'];
							return array(
								"status" => 201,
								"msg" => "Usuário criado com sucesso.",
								"data" => $objDados
							);
						endif;
					endif;
				endif;
			endif;
		endif;
	}
	
	function getID($objDados)
	{
		$sql = "SELECT $this->tabela.id FROM $this->tabela WHERE $this->tabela.login = :login";
		$op = Conexao::getInstance()->prepare($sql);
		$op->bindValue(":login", $objDados->login);
		$op->execute();
		return($op->fetch(PDO::FETCH_ASSOC));
	}

	function buscarUserSenha($objDados)
	{
		$sql = "SELECT $this->select FROM $this->tabela WHERE $this->tabela.login = :login AND $this->tabela.pass = :pass";
		$op = Conexao::getInstance()->prepare($sql);
		$op->bindValue(":login", $objDados->login);
		$op->bindValue(":pass", $this->criptografarSenha($objDados->login, $objDados->pass));
		$op->execute();
		return (object) $op->fetch(PDO::FETCH_ASSOC);
	}
	
	function buscarUser($objDados)
	{
		$sql = "SELECT $this->select FROM $this->tabela WHERE $this->tabela.login = :login";
		$op = Conexao::getInstance()->prepare($sql);
		$op->bindValue(":login", $objDados->login);
		$op->execute();
		return $op->fetchall(PDO::FETCH_ASSOC);
	}
	
	function buscarMedicoID($objDados)
	{
		$sql = "SELECT $this->select FROM $this->tabela WHERE $this->tabela.tb_medico_id = :id_medico";
		$op = Conexao::getInstance()->prepare($sql);
		$op->bindValue(":id_medico", $objDados->tb_medico_id);
		$op->execute();
		return $op->fetchall(PDO::FETCH_ASSOC);
	}

	/**
	 * preparando os dados
	 * @param  [string] $user
	 * @param  [string] $pass
	 * @return [string] token.
	 */
	function gerarToken($user, $pass)
	{
		$date = date_create();
		$cod = date_format($date, 'YmdHi').$login.$pass;
		return md5($cod);
	}
	
	/**
	 * preparando os dados
	 * @param  [string] $user
	 * @param  [string] $pass
	 * @return [string] senha criptografada.
	 */
	function criptografarSenha($user, $pass)
	{
		return md5($user.$pass);
	}

	/**
	 * preparando os dados
	 * @param  [string] $user
	 * @param  [string] $pass
	 * @return [string] senha criptografada.
	 */
	function getDateToken()
	{
		$date = date_create();
		$dataDia = date_format($date, 'd') +1;
		$dataInicio = date_format($date, 'Y-m-');
		$dataFim = date_format($date, ' H:i:s');
		
		$data = $dataInicio.$dataDia.$dataFim;

		return $data;
	}


}
?>