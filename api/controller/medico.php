<?php
require_once "classes/conexao.php";
require_once "model/medico.php";
require_once "model/usuario.php";

class MedicoController extends MedicoModel {
    

	public static function getFull($id)
	{
		$controller = ucfirst($_GET['page'])."Controller";
		$tabela = $controller::$tabela;
		$id = $_GET['id'];

		$sql = "SELECT 
					tb_medico.id, 
					tb_medico.nome, 
					tb_medico.crm, 
					tb_medico.especialidade_text, 
					tb_medico.texto, 
					tb_medico.email, 
					tb_medico.site,
					tb_medico.imagem,
					tb_medico.facebook,
					tb_medico.instagram,
					tb_medico.twitter,
					tb_medico.telefone,
					tb_medico.whatsapp,
					tb_medico.periodo,
					tb_medico.agenda_email,
					tb_medico.agenda_telefone,
					tb_medico.desconto,
					tb_medico.depoimento,
					tb_medico.link_artigo,
					tb_medico.destaque,
					tb_endereco.endereco,
					tb_endereco.numero,
					tb_endereco.bairro,
					tb_endereco.cep,
					tb_cidade.nome as cidade,
					tb_estado.sigla as estado,
					/*tb_telefone.numero as telefone,*/
					tb_especialidade.id as especialidade_id,
					tb_especialidade.nome as especialidade,
					tb_convenio.id as convenio_id,
					tb_convenio.nome as convenio,
					tb_consultorio.id as consultorio_id,
					tb_consultorio.nome as consultorio,
					tb_redesocial.id as redesocial_id,
					tb_redesocial.nome as redesocial_nome,
					tb_redesocial.link as redesocial_link,
					tb_experiencia.id as experiencia_id,
					tb_experiencia.nome as experiencia_nome,
					tb_experiencia.descricao as experiencia_descricao,
					tb_experiencia.imagem as experiencia_imagem,
					tb_experiencia.local as experiencia_local,
					tb_experiencia.datainicio as experiencia_datainicio,
					tb_experiencia.datafim as experiencia_datafim,
					tb_experiencia.titulo as experiencia_titulo,
					tb_experiencia.orientador as experiencia_orientador
				FROM tb_medico
					LEFT JOIN tb_medico_especialidade ON tb_medico_especialidade.tb_medico_id = tb_medico.id
					LEFT JOIN tb_especialidade ON tb_medico_especialidade.tb_especialidade_id = tb_especialidade.id
					LEFT JOIN tb_endereco ON tb_medico.tb_endereco_id = tb_endereco.id
					LEFT JOIN tb_cidade ON tb_endereco.tb_cidade_id = tb_cidade.id
					LEFT JOIN tb_estado ON tb_cidade.tb_estado_id = tb_estado.id
					LEFT JOIN tb_telefone_medico ON tb_telefone_medico.tb_medico_id = tb_medico.id
					LEFT JOIN tb_telefone ON tb_telefone.id = tb_telefone_medico.tb_telefone_id
					LEFT JOIN tb_medico_convenio ON tb_medico_convenio.tb_medico_id = tb_medico.id
					LEFT JOIN tb_convenio ON tb_medico_convenio.tb_convenio_id = tb_convenio.id
					LEFT JOIN tb_consultorio_medico ON tb_consultorio_medico.tb_medico_id = tb_medico.id
					LEFT JOIN tb_consultorio ON tb_consultorio_medico.tb_consultorio_id = tb_consultorio.id
					LEFT JOIN tb_redesocial ON tb_medico.id = tb_redesocial.tb_medico_id
					LEFT JOIN tb_experiencia ON tb_experiencia.tb_medico_id = tb_medico.id
				WHERE tb_medico.id = $id ";

		$dados = parent::executar($sql, 'all');

		foreach ($dados as $k => $v) {
			$idMedico = $v['id']; 

			if(! $infoSaida[$idMedico]['id']==$v['id']):
				$infoSaida[$idMedico] = array(
					"id" => $v['id'],
					"nome" => $v ['nome'],
					"crm" => $v['crm'],
					"especialidade_text" => $v['especialidade_text'],
					"texto" => $v['texto'],
					"email" => $v['email'],
					"site" => $v['site'],
					"cidade" => $v['cidade'],
					"estado" => $v['estado'],
					"telefone" => $v['telefone'],
					"imagem" => $v['imagem'],
					"facebook" => $v['facebook'],
					"instagram" => $v['instagram'],
					"twitter" => $v['twitter'],
					"telefone" => $v['telefone'],
					"whatsapp" => $v['whatsapp'],
					"endereco" => $v['endereco'],
					"numero" => $v['numero'],
					"bairro" => $v['bairro'],
					"cep" => $v['cep'],
					"periodo" => $v['periodo'],
					"agenda_email" => $v['agenda_email'],
					"agenda_telefone" => $v['agenda_telefone'],
					"desconto" => $v['desconto'],
					"link_artigo" => $v['link_artigo'],
					"destaque" => $v['destaque'],
					"depoimento" => $v['depoimento']
				);
			endif;
			if($v['especialidade']!="")
				$infoSaida[$idMedico]['especialidade'][$v['especialidade_id']] = $v['especialidade'];
	
			if($v['consultorio']!="")
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']] = $v['consultorio'];

			if($v['convenio']!="")
				$infoSaida[$idMedico]['convenio'][$v['convenio_id']] = $v['convenio'];
			
			if($v['doenca']!=""){
				$infoSaida[$idMedico]['doenca'][$v['doenca_id']]['nome'] = $v['doenca'];
				$infoSaida[$idMedico]['doenca'][$v['doenca_id']]['desc'] = $v['doenca_descricao'];
			}
			if($v['redesocial_id']!=""){
				$infoSaida[$idMedico]['redesocial'][$v['redesocial_id']]['nome'] = $v['redesocial_nome'];
				$infoSaida[$idMedico]['redesocial'][$v['redesocial_id']]['link'] = $v['redesocial_link'];
			}
			if($v['sintoma']!=""){
				$infoSaida[$idMedico]['sintoma'][$v['sintoma_id']]['nome'] = $v['sintoma'];
				$infoSaida[$idMedico]['sintoma'][$v['sintoma_id']]['desc'] = $v['sintoma_descricao'];
			}

			if($v['experiencia_id']!=""){
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['nome'] = $v['experiencia_nome'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['desc'] = $v['experiencia_descricao'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['imagem'] = $v['experiencia_imagem'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['datainicio'] = $v['experiencia_datainicio'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['datafim'] = $v['experiencia_datafim'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['local'] = $v['experiencia_local'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['titulo'] = $v['experiencia_titulo'];
				$infoSaida[$idMedico]['experiencia'][$v['experiencia_id']]['orientador'] = $v['experiencia_orientador'];
			}
		}

		$dados = (object) $infoSaida;
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

	public static function getAllFull()
	{
		$controller = ucfirst($_GET['page'])."Controller";
		$tabela = $controller::$tabela;
		$id = $_GET['id'];

		$sql = "SELECT 
					tb_medico.id, 
					tb_medico.nome, 
					tb_medico.crm, 
					tb_medico.site,
					tb_medico.imagem,
					tb_cidade.nome as cidade,
					tb_telefone.numero as telefone,
					tb_especialidade.id as especialidade_id,
					tb_especialidade.nome as especialidade,
					tb_convenio.id as convenio_id,
					tb_convenio.nome as convenio
				FROM tb_medico
					LEFT JOIN tb_medico_especialidade ON tb_medico_especialidade.tb_medico_id = tb_medico.id
					LEFT JOIN tb_especialidade ON tb_medico_especialidade.tb_especialidade_id = tb_especialidade.id
					LEFT JOIN tb_endereco ON tb_medico.tb_endereco_id = tb_endereco.id
					LEFT JOIN tb_cidade ON tb_endereco.tb_cidade_id = tb_cidade.id
					LEFT JOIN tb_telefone_medico ON tb_telefone_medico.tb_medico_id = tb_medico.id
					LEFT JOIN tb_telefone ON tb_telefone.id = tb_telefone_medico.tb_telefone_id
					LEFT JOIN tb_medico_convenio ON tb_medico_convenio.id = tb_medico.tb_medico_id
					LEFT JOIN tb_convenio ON tb_medico_convenio.tb_convenio_id = tb_convenio.id
					LEFT JOIN tb_consultorio_medico ON tb_consultorio_medico.tb_medico_id = tb_medico.id
					LEFT JOIN tb_consultorio ON tb_consultorio_medico.tb_consultorio_id = tb_consultorio.id";

		$dados = parent::executar($sql, 'all');

		foreach ($dados as $k => $v) {
			$idMedico = $v['id']; 

			if(! $infoSaida[$idMedico]['id']==$v['id']):
				$infoSaida[$idMedico] = array(
					"id" => $v['id'],
					"nome" => $v ['nome'],
					"crm" => $v['crm'],
					"site" => $v['site'],
					"cidade" => $v['cidade'],
					"telefone" => $v['telefone'],
					"imagem" => $v['imagem']
				);
			endif;
			if($v['especialidade']!="")
				$infoSaida[$idMedico]['especialidade'][$v['especialidade_id']] = $v['especialidade'];
			if($v['consultorio']!="")
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']] = $v['consultorio'];

			if($v['convenio']!="")
				$infoSaida[$idMedico]['convenio'][$v['convenio_id']] = $v['convenio'];
			if($v['doenca']!=""){
				$infoSaida[$idMedico]['doenca'][$v['doenca_id']]['nome'] = $v['doenca'];
				$infoSaida[$idMedico]['doenca'][$v['doenca_id']]['desc'] = $v['doenca_descricao'];
			}
			if($v['sintoma']!=""){
				$infoSaida[$idMedico]['sintoma'][$v['sintoma_id']]['nome'] = $v['sintoma'];
				$infoSaida[$idMedico]['sintoma'][$v['sintoma_id']]['desc'] = $v['sintoma_descricao'];
			}

		}

		$dados = (object) $infoSaida;

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

   	public static function post($objDados, $admin=false)
	{
    	$controller = ucfirst($_GET['page'])."Controller";
    	$info = UsuarioController::atualizarPermissoes();

    	// verificar se o usuario é o dono da informação
    	if( ($info->valido == "valido") || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();
			
			foreach (static::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}

	        if(isset($dados['op']))
				$op = $dados['op'];

			$retornoMedico = parent::Inserir(static::$tabela,$objDados, static::$campos);

			static::saveConvenio($retornoMedico->data->id,$dados['convenio']);
			static::saveEspecialidade($retornoMedico->data->id,$dados['especialidade']);
			static::saveConsultorio($retornoMedico->data->id,$dados['consultorio']);
			return $retornoMedico;

		}else{
			return $info;
		}
	}

   	public static function postCadastro($objDados, $admin=false)
	{
		$dados = ControllerAbstract::retornaRequest();
		foreach (static::$campos as $key => $value) {
			$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
		}

		$objDados->tb_endereco_id = static::saveEndereco();

        if(isset($dados['op']))
			$op = $dados['op'];

		$retornoMedico = parent::Inserir(static::$tabela,$objDados, static::$campos);
		return $retornoMedico;
	}

	public static function saveEndereco()
	{
        try {
        	$sql = "INSERT INTO `tb_endereco` (`endereco`, `numero`, `bairro`, `cep`, `tb_cidade_id`) VALUES ('.', '0', '.', '0', '8974');";
			$op = Conexao::getInstance()->prepare($sql);
	        $op->execute();

			$sql = "SELECT max(id) as id FROM `tb_endereco` ORDER BY `id` DESC";
			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();
			$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

        	return($dados->id);
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }    
	}



   	public static function put()
	{
    	$controller = ucfirst($_GET['page'])."Controller";
    	$info = UsuarioController::atualizarPermissoes();
    	
    	if( ($info->valido == "valido") || ($admin==true) ) {

    	// verificar se o usuario é o dono da informação
		$dados = ControllerAbstract::retornaRequest();

		foreach (static::$campos as $key => $value) {
			$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
		}

        if(isset($dados['op']))
			$op = $dados['op'];

		$objDados->id = $info->data->tb_medico_id;
		$retornoMedico = parent::Editar(static::$tabela,$objDados, static::$campos);

		static::deleteConvenio($objDados->id);
		static::saveConvenio($objDados->id,$dados['convenio']);
				
		static::deleteEspecialidade($objDados->id);
		static::saveEspecialidade($objDados->id,$dados['especialidade']);
		
		static::deleteConsultorio($objDados->id);
		static::saveConsultorio($objDados->id,$dados['consultorio']);
		
		static::editarTelefone($objDados->id,$dados['telefone']);

		return $retornoMedico;

		}else{
			return $info;
		}
	}

	public static function editarTelefone($medico, $telefone)
	{
		$sql = "UPDATE tb_telefone, tb_telefone_medico set tb_telefone.numero = $telefone WHERE tb_telefone_medico.tb_telefone_id = tb_telefone.id and tb_telefone_medico.tb_medico_id=  $medico";
		$op = Conexao::getInstance()->prepare($sql);		
		$info = $op->execute();
	}

	public static function deleteConvenio($medico)
	{
        try {
			$sql = "DELETE FROM tb_medico_convenio WHERE tb_medico_id = :id";
			$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":id", $medico);
			return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }    
	}

	public static function deleteEspecialidade($medico)
	{
        try {
			$sql = "DELETE FROM tb_medico_especialidade WHERE tb_medico_id = :id";
			$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":id", $medico);
			return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }    
	}

	public static function deleteConsultorio($medico)
	{
        try {
			$sql = "DELETE FROM tb_consultorio_medico WHERE tb_medico_id = :id";
			$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":id", $medico);
			return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }    
	}

	public static function saveConvenio($medico, $convenios)
	{
        try {
        	$convenio = explode(',', $convenios);
        	foreach ($convenio as $k => $v) {
	            $sql = "INSERT INTO tb_medico_convenio ( tb_medico_id, tb_convenio_id ) VALUES ( $medico, $v )";
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

	public static function saveEspecialidade($medico, $especialidades)
	{
        try {
        	$especialidade = explode(',', $especialidades);
        	foreach ($especialidade as $k => $v) {
	            $sql = "INSERT INTO tb_medico_especialidade ( tb_medico_id, tb_especialidade_id ) VALUES ( $medico, $v )";
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

	public static function saveConsultorio($medico, $consultorios)
	{
        try {
        	$consultorio = explode(',', $consultorios);
        	foreach ($consultorio as $k => $v) {
	            $sql = "INSERT INTO tb_consultorio_medico ( tb_medico_id, tb_consultorio_id ) VALUES ( $medico, $v )";
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

	public function delete()
	{
    	$controller = ucfirst($_GET['page'])."Controller";
    	$info = UsuarioController::atualizarPermissoes();
    	
    	if( ($info->valido == "valido") || ($admin==true) ) {
			static::deleteConvenio($info->data->tb_medico_id);
			static::deleteEspecialidade($info->data->tb_medico_id);
			static::deleteConsultorio($info->data->tb_medico_id);
			parent::Deletar($controller::$tabela,$info->data->tb_medico_id);
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
}

?>