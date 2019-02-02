<?php
require_once "classes/conexao.php";
require_once "model/endereco.php";
require_once "model/usuario.php";

class EnderecoController extends EnderecoModel {

    public static function post()
    {   	
    	$info = UsuarioController::atualizarPermissoes();

    	if($info->valido == "valido"){
			$dados = ControllerAbstract::retornaRequest();
			foreach (static::$campos as $key => $value) {
				$objDados->$key = (isset($dados['endereco'][$key])) ? $dados['endereco'][$key] : null ;
			}
            if(isset($dados['op']))
				$op = $dados['op'];

			return parent::Inserir(static::$tabela,$objDados, static::$campos);
		}else{
			return $info;
		}
    }
    public static function put($admin=false)
    {
    	$controller = "EnderecoController";
    	if(!$admin){
	    	$info = UsuarioController::atualizarPermissoes();
	    	$dono = UsuarioController::pertenceUsuario('tb_consultorio_medico','tb_medico_id',$info->data->tb_medico_id,$_GET['id'],'tb_consultorio_id');
    	}

    	// verificar se o usuario é o dono da informação
    	if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();
			foreach ($controller::$campos as $key => $value) {
				$objDados->$key = (isset($dados['endereco'][$key])) ? $dados['endereco'][$key] : null ;
			}
            if(isset($dados['op']))
				$op = $dados['op'];

			if(array_key_exists("tb_medico_id", $objDados))
				$objDados->tb_medico_id = $info->data->tb_medico_id;

			return parent::Editar(static::$tabela,$objDados, static::$campos);
		}else{
			return array(
				"status" => 403,
				"data" => "Acesso negado"
			);
		}
    }


}

?>