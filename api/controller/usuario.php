<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class UsuarioController extends ControllerAbstract {
	
	public static function atualizarPermissoes(){
		// gerando data para verificar validade do token
		$date = date_create();
		$dateNow = date_format($date, 'Y-m-d H:i:s');
		$token = (isset($_SERVER['HTTP_TOKEN'])) ? $_SERVER['HTTP_TOKEN'] : '' ;

		if($token!=""):
			// buscar token
			$sql = "SELECT * FROM tb_users WHERE tb_users.token = '$token' and tb_users.validtoken >= '$dateNow'";
			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();
			$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);

			if(!empty($retorno->id)):
				return (object) array(
					"valido" => "valido",
					"data" => $retorno
				);
			else:
				if ( ($_SERVER['PHP_AUTH_USER']!="") && ($_SERVER['PHP_AUTH_PW'])):
					$login = $_SERVER['PHP_AUTH_USER']; 
					$pass = static::criptografarSenha($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
					$sql = "SELECT * FROM tb_users WHERE tb_users.login = '$login' and tb_users.pass = '$pass'";
					$op = Conexao::getInstance()->prepare($sql);
					$op->execute();
					$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);
					if(!empty($retorno->id)):
						$info_token = static::gerarToken($login, $pass);
						$info_pass = static::criptografarSenha($dados['login'], $dados['pass']);
						$info_validtoken = static::getDateToken();
						
						$sql = "UPDATE tb_users set token = '$info_token', validtoken = '$info_validtoken' WHERE id = $retorno->id ";
						$op = Conexao::getInstance()->prepare($sql);
						$op->execute();
						
						$sql = "SELECT * FROM tb_users WHERE tb_users.token = '$info_token' and tb_users.validtoken >= '$dateNow'";
						$op = Conexao::getInstance()->prepare($sql);
						$op->execute();
						$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);
					
						return (object) array(
							"valido" => "valido",
							"data" => $retorno
						);
					else:
						return (object) array(
							"valido" => "invalido",
							"status" => 402,
							"msg" => "solicitar um novo token"
						);	
					endif;
				else:
					return (object) array(
						"valido" => "invalido",
						"status" => 402,
						"msg" => "solicitar um novo token"
					);	
				endif;
			endif;
		else:
			if ( ($_SERVER['PHP_AUTH_USER']!="") && ($_SERVER['PHP_AUTH_PW'])):
				$login = $_SERVER['PHP_AUTH_USER']; 
				$pass = static::criptografarSenha($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);
				$sql = "SELECT * FROM tb_users WHERE tb_users.login = '$login' and tb_users.pass = '$pass'";
				$op = Conexao::getInstance()->prepare($sql);
				$op->execute();
				$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);
				if(!empty($retorno)):
					$info_token = static::gerarToken($login, $pass);
					$info_pass = static::criptografarSenha($dados['login'], $dados['pass']);
					$info_validtoken = static::getDateToken();
					
					$sql = "UPDATE tb_users set token = '$info_token', validtoken = '$info_validtoken' WHERE id = $retorno->id ";
					$op = Conexao::getInstance()->prepare($sql);
					$op->execute();
					
					$sql = "SELECT * FROM tb_users WHERE tb_users.token = '$info_token' and tb_users.validtoken >= '$dateNow' ";
					$op = Conexao::getInstance()->prepare($sql);
					$op->execute();
					$retorno = (object) $op->fetch(PDO::FETCH_ASSOC);

					return (object) array(
						"valido" => "valido",
						"data" => $retorno
					);
				else:
					return (object) array(
						"valido" => "invalido",
						"status" => 402,
						"msg" => "solicitar um novo token"
					);	
				endif;
			else:
				return (object) array(
					"valido" => "invalido",
					"status" => 402,
					"msg" => "solicitar um novo token"
				);	
			endif;
		endif;

	}

	public static function pertenceUsuario($tabela,$campo,$info,$id, $campoID="id")
	{
		$sql = "SELECT * FROM $tabela WHERE $tabela.$campoID = $id and $tabela.$campo = $info";
		$op = Conexao::getInstance()->prepare($sql);
		$op->execute();
		return (object) $op->fetch(PDO::FETCH_ASSOC);
	}

	public static function pertenceUsuarioSimples($tabela,$campo,$id)
	{
		$sql = "SELECT * FROM $tabela WHERE $tabela.$campo = $id";
		$op = Conexao::getInstance()->prepare($sql);
		$op->execute();
		return (object) $op->fetch(PDO::FETCH_ASSOC);
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