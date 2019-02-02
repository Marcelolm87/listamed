<?php
require_once "classes/conexao.php";
require_once "model/convenio.php";
require_once "model/usuario.php";

class ConvenioController extends ConvenioModel {

	public static function post($objDados, $admin=false)
	{		
		$retorno = parent::post();
		if(!$admin){
	    	$info = UsuarioController::atualizarPermissoes();
    	}
    	// verificar se o usuario é o dono da informação
    	if( ($info->valido == "valido") || ($admin==true) ) {
			$convenio_medico = array(
				"id" => "",
				"tb_convenio_id" => $retorno->data->id,
				"tb_medico_id" => $info->data->tb_medico_id
			);
			$campos = array("id" => null, "tb_convenio_id" => null, "tb_medico_id" => null);
			$retornoMC = parent::Inserir('tb_medico_convenio',(object) $convenio_medico , $campos);

			return $retorno;
		}else{
			return $info;
		}
	}
	
	public static function put($admin=false)
	{
		if(!$admin){
			$info = UsuarioController::atualizarPermissoes();
			$dono = UsuarioController::pertenceUsuario('tb_medico_convenio','tb_medico_id',$info->data->tb_medico_id,$_GET['id'],'tb_convenio_id');
		}

		// verificar se o usuario é o dono da informação
		if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();

			foreach (ConvenioController::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}
			if(isset($dados['op']))
				$op = $dados['op'];
			
			$objDados->id = $_GET['id'];

			$retornoConvenio = parent::Editar(static::$tabela,$objDados, static::$campos);
			return $retornoConvenio;
		}else{
			return array(
				"status" => 403,
				"data" => "Acesso negado"
			);
		}
	}

	public function delete($admin=false)
	{
    	if(!$admin){
    		$info = UsuarioController::atualizarPermissoes();
    		$dono = UsuarioController::pertenceUsuario('tb_medico_convenio','tb_medico_id',$info->data->tb_medico_id,$_GET['id'],'tb_convenio_id');
		}

    	// verificar se o usuario é o dono da informação
    	if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {

			$retorno = ConvenioController::BuscarPorCOD();
			static::DeletarConvenio($_GET['id'], $info->data->tb_medico_id );
			parent::Deletar(ConvenioController::$tabela,$_GET['id']);

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
	 * Deleta um registro
	 * @param [int] $id recebe a id do registro a ser deletado.
	 */
	public static function DeletarConvenio($convenio, $medico) {
		try {
			$sql = "DELETE FROM tb_medico_convenio WHERE tb_medico_id = :medico and tb_convenio_id = :convenio";

			$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":medico", $medico);
			$op->bindValue(":convenio", $convenio);
			return $op->execute();
		} catch (Exception $e) {
			print "Ocorreu um erro ao tentar deletar esta informação.";
		}
	}

}
?>