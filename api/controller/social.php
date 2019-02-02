<?php
require_once "classes/conexao.php";
require_once "model/social.php";
require_once "model/usuario.php";

class SocialController extends SocialModel {
	public static function put($admin=false)
	{
		if(!$admin){
			$info = UsuarioController::atualizarPermissoes();
			$dono = UsuarioController::pertenceUsuario('tb_redesocial','id',$_GET['id'], $info->data->tb_medico_id,'tb_medico_id');
		}

		// verificar se o usuario é o dono da informação
		if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();

			foreach (SocialController::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}
			if(isset($dados['op']))
				$op = $dados['op'];

			$objDados->id = $_GET['id'];
			$objDados->tb_medico_id = $info->data->tb_medico_id;

			$retornoSocial = parent::Editar(static::$tabela,$objDados, static::$campos);
			return $retornoSocial;
		}else{
			return array(
				"status" => 403,
				"data" => "Acesso negado"
			);
		}
	}
}

?>