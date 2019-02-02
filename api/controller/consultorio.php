<?php
require_once "classes/conexao.php";
require_once "model/consultorio.php";
require_once "model/usuario.php";
require_once "controller/endereco.php";

class ConsultorioController extends ConsultorioModel {

    public static function BuscarPorCEP($cep)
    {
    	$cepOrganiza = str_replace("-", "", $cep);
		$cepOrganizaTraco  = sprintf( '%s-%s', substr( $cepOrganiza, 0, strlen( $cepOrganiza ) - 3), substr( $cepOrganiza, -3, strlen( $cepOrganiza ) + 1  ) );
		$sql = "SELECT * FROM tb_endereco, tb_consultorio where tb_endereco.id = tb_consultorio.tb_endereco_id and tb_endereco.cep = '$cepOrganiza' or tb_endereco.cep = '$cepOrganizaTraco'"; 
		$dados = parent::executar($sql, 'all');
		return $dados;
    }

	public static function post($objDados, $admin=false)
	{
		if(!$admin){
	    	$info = UsuarioController::atualizarPermissoes();
    	}

    	// verificar se o usuario é o dono da informação
    	if( ($info->valido == "valido") || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();

			// inserindo o endereco
			$retorno = EnderecoController::post('endereco');
			
			foreach (static::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}

			$objDados->tb_endereco_id = $retorno->data->id;
	        
	        if(isset($dados['op']))
				$op = $dados['op'];

			if(array_key_exists("tb_medico_id", $objDados))
				$objDados->tb_medico_id = $info->data->tb_medico_id;

			$retornoConsultorio = parent::Inserir(static::$tabela,$objDados, static::$campos);
			
			$consultorio_medico = array(
				"id" => "",
				"tb_consultorio_id" => $retornoConsultorio->data->id,
				"tb_medico_id" => $info->data->tb_medico_id
			);
			$campos = array("id" => null, "tb_consultorio_id" => null, "tb_medico_id" => null);
			$retornoMC = parent::Inserir('tb_consultorio_medico',(object) $consultorio_medico , $campos);

			return $retornoConsultorio;

		}else{
			return $info;
		}
	}

	public static function put($admin=false)
	{
		if(!$admin){
			$info = UsuarioController::atualizarPermissoes();
			if($info->valido=="invalido"):
				return ($info);
			else:
				$dono = UsuarioController::pertenceUsuario('tb_consultorio_medico','tb_medico_id',$info->data->tb_medico_id,$_GET['id'],'tb_consultorio_id');
			endif;
		}

		// verificar se o usuario é o dono da informação
		if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();

			
			// editando o endereco
			$retorno = EnderecoController::put('endereco');

			foreach (ConsultorioController::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}
			if(isset($dados['op']))
				$op = $dados['op'];
			
			if(array_key_exists("tb_medico_id", $objDados))
				$objDados->tb_medico_id = $info->data->tb_medico_id;

			$objDados->id = $_GET['id'];
			$objDados->tb_endereco_id = $retorno->data['id'];

			$retornoConsultorio = parent::Editar(static::$tabela,$objDados, static::$campos);
			return $retornoConsultorio;

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
    		if($info->valido=="invalido"):
				return ($info);
			else:
				$dono = UsuarioController::pertenceUsuario('tb_consultorio_medico','tb_medico_id',$info->data->tb_medico_id,$_GET['id'],'tb_consultorio_id');
			endif;
		}
    	// verificar se o usuario é o dono da informação
    	if( (($info->valido == "valido") && ($dono->id > 0)) || ($admin==true) ) {

			$retorno = ConsultorioController::BuscarPorCOD();
			static::DeletarConsultorio($_GET['id'], $info->data->tb_medico_id );
			parent::Deletar(ConsultorioController::$tabela,$_GET['id']);
			EnderecoController::Deletar(EnderecoController::$tabela,$retorno->data->tb_endereco_id);

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
	public static function DeletarConsultorio($consultorio, $medico) {
		try {
			$sql = "DELETE FROM tb_consultorio_medico WHERE tb_medico_id = :medico and tb_consultorio_id = :consultorio";

			$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":medico", $medico);
			$op->bindValue(":consultorio", $consultorio);
			return $op->execute();
		} catch (Exception $e) {
			print "Ocorreu um erro ao tentar deletar esta informação.";
		}
	}

    public static function BuscarImagens($id)
    {
    	$sql = "SELECT * FROM tb_consultorio_imagens where tb_consultorio_imagens.tb_consultorio_id = '$id'"; 
		$dados = parent::executar($sql, 'all');
		return $dados;
    }

    public static function BuscarServicos($id)
    {
    	$sql = "SELECT * FROM tb_consultorio_servico where tb_consultorio_servico.tb_consultorio_id = '$id'"; 
		$dados = parent::executar($sql, 'all');
		return $dados;
    }

    public static function BuscarMedicos($id)
    {
    	$sql = "SELECT tb_medico.id, tb_medico.nome, tb_medico.imagem, tb_medico.especialidade_text, tb_medico.status   FROM tb_medico, tb_consultorio_medico where tb_medico.id = tb_consultorio_medico.tb_medico_id and tb_consultorio_medico.tb_consultorio_id = '$id'"; 
		$dados = parent::executar($sql, 'all');
		return $dados;
    }
    public static function BuscarConvenio($id)
    {
    	$sql = "SELECT tb_convenio.id, tb_convenio.nome FROM tb_convenio, tb_consultorio_convenio where tb_convenio.id = tb_consultorio_convenio.tb_convenio_id and tb_consultorio_convenio.tb_consultorio_id = '$id'"; 
		$dados = parent::executar($sql, 'all');
		return $dados;
    }

}
?>