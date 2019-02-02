<?php
require_once "classes/conexao.php";
require_once "model/busca.php";

class BuscaController extends BuscaModel {

	static $debug;

	public static function Buscar($cidade=null)
	{
		$valor = $_GET['valor'];

		// buscando tudo
		if($cidade>0):
			$todasInformacoes = static::buscaFullFiltro($cidade);
		else:
			$todasInformacoes = static::buscaFull();
		endif;

		$ocorrencias = static::encontrarOcorrencia($todasInformacoes, $valor);
		
			$ocorrencias2->profissionais = $ocorrencias;
			foreach ($ocorrencias2->profissionais as $kProf => $vProf) :
				foreach ($vProf['consultorio'] as $kCons => $vCons) :
					if (!is_array($consultorio[$kCons])) :
						$consultorio[$kCons] = $vCons;
					endif;
					$consultorio[$kCons]['profissionais'][$kProf] = $vProf;
					unset($consultorio[$kCons]['profissionais'][$kProf]['consultorio']);
					unset($ocorrencias2->profissionais[$kProf]['consultorio']);
				endforeach;
			endforeach;
			$ocorrencias2->centro = $consultorio;

			unset($ocorrencias);
			$ocorrencias = $ocorrencias2;

		return json_encode($ocorrencias);
	}

	public static function verificaPalavra($palavra, $char)
	{
		$pos = strpos($palavra, $char);
		if(is_numeric($pos)):
			$aux = "";
			$aux = explode($char, $palavra);
			return($aux);
		endif;
		return $palavra;
	}
	public static  function tirarAcentos($string){
	    return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$string);
	}

	public static function verificarLeven($buscar, $palavra, $lev)
	{
		$init = 0;
		$init2 = 0;
		$lev = 10;

		$pos = strpos($palavra, ' ');
		$pos2 = strpos($buscar, ' ');

		$palavra_array = static::verificaPalavra(static::tirarAcentos($palavra), ' ');
		$buscar_array  = static::verificaPalavra(static::tirarAcentos($buscar), ' ');

		if(is_array($palavra_array)){
			foreach ($palavra_array as $pa => $va) {
				if(is_array($buscar_array)){
					foreach ($buscar_array as $pb => $vb) {
						$levAux = levenshtein($va, $vb);
						static::$debug[$va][$vb] = $levAux;
						$lev = ($lev > $levAux) ? $levAux : $lev;
						if($levAux==0){
							if($init>0){
								$lev = -1;
							}
							$init++;
						}
					}
				}else{
					$levAux = levenshtein($va, $buscar);
					static::$debug[$va][$buscar] = $levAux;
					$lev = ($lev > $levAux) ? $levAux : $lev;
				}
			}
		}else{
			if(is_array($buscar_array)){
				foreach ($buscar_array as $pb => $vb) {
					$levAux = levenshtein($palavra, $vb);
					static::$debug[$palavra][$vb] = $levAux;
					$lev = ($lev > $levAux) ? $levAux : $lev;
				}
			}else{
				$levAux = levenshtein($palavra, $buscar);
				static::$debug[$palavra][$buscar] = $levAux;
				$lev = ($lev > $levAux) ? $levAux : $lev;
			}
		}

		$palavra_array = static::verificaPalavra(static::tirarAcentos($palavra), ' ');
		$buscar_array  = static::verificaPalavra(static::tirarAcentos($buscar), '-');

		if(is_array($palavra_array)){
			foreach ($palavra_array as $pa => $va) {
				if(is_array($buscar_array)){
					foreach ($buscar_array as $pb => $vb) {
						$levAux = levenshtein($va, $vb);
						static::$debug[$va][$vb] = $levAux;
						$lev = ($lev > $levAux) ? $levAux : $lev;
						if($levAux==0){
							if($init>0){
								$lev = -1;
							}
							$init++;
						}
					}
				}else{
					$levAux = levenshtein($va, $buscar);
					static::$debug[$va][$buscar] = $levAux;
					$lev = ($lev > $levAux) ? $levAux : $lev;
				}
			}
		}else{
			if(is_array($buscar_array)){
				foreach ($buscar_array as $pb => $vb) {
					$levAux = levenshtein($palavra, $vb);
					static::$debug[$palavra][$vb] = $levAux;
					$lev = ($lev > $levAux) ? $levAux : $lev;
				}
			}else{
				$levAux = levenshtein($palavra, $buscar);
				static::$debug[$palavra][$buscar] = $levAux;
				$lev = ($lev > $levAux) ? $levAux : $lev;
			}
		}

		return($lev);
	}

	public static function encontrarOcorrencia($info, $buscar)
	{
		$limite = 3;
		foreach ($info as $k1 => $p1):
			$lev = 30;
			$levAux = static::verificarLeven(strtolower($buscar), strtolower($p1['nome']),$lev);
			$lev = ($lev > $levAux) ? $levAux : $lev ; 
			$levAux = static::verificarLeven(strtolower($buscar), strtolower($p1['crm']),$lev);
			$lev = ($lev > $levAux) ? $levAux : $lev ; 
			$levAux = static::verificarLeven(strtolower($buscar), strtolower($p1['cidade']),$lev);
			$lev = ($lev > $levAux) ? $levAux : $lev ; 
			foreach ($p1['especialidade'] as $k2 => $p2) :
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
			endforeach;
			foreach ($p1['convenio'] as $k2 => $p2) :
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
			endforeach;
			foreach ($p1['doenca'] as $k2 => $p2) :
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2['nome']),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2['desc']),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
			endforeach;
			foreach ($p1['sintoma'] as $k2 => $p2) :
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2['nome']),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2['desc']),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
			endforeach;
			foreach ($p1['consultorio'] as $k2 => $p2) :
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2['consultorio_nome']),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
				$levAux = static::verificarLeven(strtolower($buscar), strtolower($p2['consultorio_descricao']),$lev);
				$lev = ($lev > $levAux) ? $levAux : $lev ; 
			endforeach;

			$p1['lev'] = $lev;

			if($lev<$limite)
				$ocorrencias[$k1] = $p1;

		endforeach;

		return ($ocorrencias);
	}

	public static function buscaFull() 
	{
		
		$sql2 = "SELECT 
					tb_medico.id, 
					tb_medico.nome, 
					tb_medico.crm, 
					tb_medico.site,
					tb_medico.especialidade_text,
					tb_medico.imagem,
					tb_medico.telefone,
					tb_medico.whatsapp,
					tb_cidade.nome as cidade,
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
					LEFT JOIN tb_medico_convenio ON tb_medico_convenio.id = tb_medico.id
					LEFT JOIN tb_convenio ON tb_medico_convenio.tb_convenio_id = tb_convenio.id
					ORDER BY tb_medico.status desc, tb_medico.nome asc";


			$sql = "SELECT 
					tb_medico.id, 
					tb_medico.nome, 
					tb_medico.crm, 
					tb_medico.site,
					tb_medico.imagem,
					tb_medico.especialidade_text,
					tb_medico.status,
					tb_medico.telefone,
					tb_medico.whatsapp,
					tb_cidade.nome as cidade,
					tb_especialidade.id as especialidade_id,
					tb_especialidade.nome as especialidade,
					tb_convenio.id as convenio_id,
					tb_convenio.nome as convenio,
					tb_doenca.id as doenca_id,
					tb_doenca.nome as doenca,
					tb_doenca.descricao as doenca_descricao,
					tb_sintoma.id as sintoma_id,
					tb_sintoma.nome as sintoma,
					tb_sintoma.descricao as sintoma_descricao
					FROM tb_medico
					LEFT JOIN tb_medico_especialidade ON tb_medico_especialidade.tb_medico_id = tb_medico.id
					LEFT JOIN tb_especialidade ON tb_medico_especialidade.tb_especialidade_id = tb_especialidade.id
					LEFT JOIN tb_endereco ON tb_medico.tb_endereco_id = tb_endereco.id
					LEFT JOIN tb_cidade ON tb_endereco.tb_cidade_id = tb_cidade.id
					LEFT JOIN tb_telefone_medico ON tb_telefone_medico.tb_medico_id = tb_medico.id
					LEFT JOIN tb_telefone ON tb_telefone.id = tb_telefone_medico.tb_telefone_id
					LEFT JOIN tb_medico_convenio ON tb_medico_convenio.tb_medico_id = tb_medico.id
					LEFT JOIN tb_convenio ON tb_medico_convenio.tb_convenio_id = tb_convenio.id
					LEFT JOIN tb_especialidade_doencas ON tb_especialidade_doencas.tb_especialidade_id = tb_especialidade.id
					LEFT JOIN tb_doenca ON tb_especialidade_doencas.tb_doencas_id = tb_doenca.id
					LEFT JOIN tb_doencas_sintomas ON tb_doencas_sintomas.tb_doencas_id = tb_doenca.id
					LEFT JOIN tb_sintoma ON tb_doencas_sintomas.tb_sintomas_id = tb_sintoma.id
					ORDER BY tb_medico.status desc, tb_medico.nome asc";


		$op = Conexao::getInstance()->prepare($sql);
		$op->execute();
		$info = (object) $op->fetchall(PDO::FETCH_ASSOC);

		foreach ($info as $k => $v) {
			$idMedico = $v['id']; 

			if(! $infoSaida[$idMedico]['id']==$v['id']):
				$infoSaida[$idMedico] = array(
					"id" => $v['id'],
					"nome" => $v ['nome'],
					"crm" => $v['crm'],
					"site" => $v['site'],
					"cidade" => $v['cidade'],
					"telefone" => $v['telefone'],
					"whatsapp" => $v['whatsapp'],
					"imagem" => $v['imagem'],
					"especialidade_text" => $v['especialidade_text'],
					"status" => $v['status']
				);
			endif;
			if($v['especialidade']!="")
				$infoSaida[$idMedico]['especialidade'][$v['especialidade_id']] = $v['especialidade'];

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

		return (object) $infoSaida;
	}

	public static function buscaFullFiltro($cidade) 
	{
		
		$sql2 = "SELECT 
					tb_medico.id, 
					tb_medico.nome, 
					tb_medico.crm, 
					tb_medico.site,
					tb_medico.imagem,
					tb_medico.telefone,
					tb_medico.especialidade_text,
					tb_medico.whatsapp,
					tb_medico.status,
					tb_cidade.nome as cidade,
					tb_especialidade.id as especialidade_id,
					tb_especialidade.nome as especialidade,
					tb_convenio.id as convenio_id,
					tb_convenio.nome as convenio,
					tb_doenca.id as doenca_id,
					tb_doenca.nome as doenca,
					tb_doenca.descricao as doenca_descricao,
					tb_sintoma.id as sintoma_id,
					tb_sintoma.nome as sintoma,
					tb_sintoma.descricao as sintoma_descricao,
				    tb_consultorio.id as consultorio_id,
				    tb_consultorio.nome as consultorio_nome,
				    tb_consultorio.descricao as consultorio_descricao,
				    tb_consultorio.site as consultorio_site,
				    tb_consultorio.email as consultorio_email,
				    tb_consultorio.telefone as consultorio_telefone,
				    tb_consultorio.status as consultorio_status,
				    tb_consultorio_servico.id servico_id,
				    tb_consultorio_servico.nome servico_nome
				FROM tb_medico
					LEFT JOIN tb_medico_especialidade ON tb_medico_especialidade.tb_medico_id = tb_medico.id
					LEFT JOIN tb_especialidade ON tb_medico_especialidade.tb_especialidade_id = tb_especialidade.id
					LEFT JOIN tb_endereco ON tb_medico.tb_endereco_id = tb_endereco.id
					LEFT JOIN tb_cidade ON tb_endereco.tb_cidade_id = tb_cidade.id
					LEFT JOIN tb_telefone_medico ON tb_telefone_medico.tb_medico_id = tb_medico.id
					LEFT JOIN tb_telefone ON tb_telefone.id = tb_telefone_medico.tb_telefone_id
					LEFT JOIN tb_medico_convenio ON tb_medico_convenio.id = tb_medico.id
					LEFT JOIN tb_convenio ON tb_medico_convenio.tb_convenio_id = tb_convenio.id
					LEFT JOIN tb_especialidade_doencas ON tb_especialidade_doencas.tb_especialidade_id = tb_especialidade.id
					LEFT JOIN tb_doenca ON tb_especialidade_doencas.tb_doencas_id = tb_doenca.id
					LEFT JOIN tb_doencas_sintomas ON tb_doencas_sintomas.tb_doencas_id = tb_doenca.id
					LEFT JOIN tb_sintoma ON tb_doencas_sintomas.tb_sintomas_id = tb_sintoma.id
				    LEFT JOIN tb_consultorio_medico ON tb_consultorio_medico.tb_medico_id = tb_medico.id
				    LEFT JOIN tb_consultorio ON tb_consultorio_medico.tb_consultorio_id = tb_consultorio.id
				    LEFT JOIN tb_consultorio_servico ON tb_consultorio_servico.tb_consultorio_id = tb_consultorio.id
				WHERE tb_cidade.id = $cidade
				ORDER BY tb_medico.status desc, tb_medico.nome asc";

			$sql = "SELECT 
						tb_medico.id, 
						tb_medico.nome, 
						tb_medico.crm, 
						tb_medico.site,
						tb_medico.imagem,
						tb_medico.telefone,
						tb_medico.especialidade_text,
						tb_medico.whatsapp,
						tb_medico.status,
						tb_cidade.nome as cidade,
						tb_especialidade.id as especialidade_id,
						tb_especialidade.nome as especialidade,
						tb_convenio.id as convenio_id,
						tb_convenio.nome as convenio,
						tb_doenca.id as doenca_id,
						tb_doenca.nome as doenca,
						tb_doenca.descricao as doenca_descricao,
						tb_sintoma.id as sintoma_id,
						tb_sintoma.nome as sintoma,
						tb_sintoma.descricao as sintoma_descricao,
					    tb_consultorio.id as consultorio_id,
					    tb_consultorio.nome as consultorio_nome,
					    tb_consultorio.descricao as consultorio_descricao,
					    tb_consultorio.site as consultorio_site,
					    tb_consultorio.email as consultorio_email,
					    tb_consultorio.telefone as consultorio_telefone,
					    tb_consultorio.imagem as consultorio_imagem,
					    tb_consultorio.status as consultorio_status,
					    tb_consultorio_servico.id as servico_id,
					    tb_consultorio_servico.nome as servico_nome
					FROM tb_medico
						LEFT JOIN tb_medico_especialidade ON tb_medico_especialidade.tb_medico_id = tb_medico.id
						LEFT JOIN tb_especialidade ON tb_medico_especialidade.tb_especialidade_id = tb_especialidade.id
						LEFT JOIN tb_endereco ON tb_medico.tb_endereco_id = tb_endereco.id
						LEFT JOIN tb_cidade ON tb_endereco.tb_cidade_id = tb_cidade.id
						LEFT JOIN tb_telefone_medico ON tb_telefone_medico.tb_medico_id = tb_medico.id
						LEFT JOIN tb_telefone ON tb_telefone.id = tb_telefone_medico.tb_telefone_id
						LEFT JOIN tb_medico_convenio ON tb_medico_convenio.id = tb_medico.id
						LEFT JOIN tb_convenio ON tb_medico_convenio.tb_convenio_id = tb_convenio.id
						LEFT JOIN tb_especialidade_doencas ON tb_especialidade_doencas.tb_especialidade_id = tb_especialidade.id
						LEFT JOIN tb_doenca ON tb_especialidade_doencas.tb_doencas_id = tb_doenca.id
						LEFT JOIN tb_doencas_sintomas ON tb_doencas_sintomas.tb_doencas_id = tb_doenca.id
						LEFT JOIN tb_sintoma ON tb_doencas_sintomas.tb_sintomas_id = tb_sintoma.id
					    LEFT JOIN tb_consultorio_medico ON tb_consultorio_medico.tb_medico_id = tb_medico.id
				    	LEFT JOIN tb_consultorio ON tb_consultorio_medico.tb_consultorio_id = tb_consultorio.id
				    	LEFT JOIN tb_consultorio_servico ON tb_consultorio_servico.tb_consultorio_id = tb_consultorio.id
					WHERE tb_cidade.id = $cidade
					ORDER BY tb_medico.status desc, tb_medico.nome asc";
		$op = Conexao::getInstance()->prepare($sql);
		$op->execute();
		$info = (object) $op->fetchall(PDO::FETCH_ASSOC);

		foreach ($info as $k => $v) {
			$idMedico = $v['id']; 

			if(! $infoSaida[$idMedico]['id']==$v['id']):
				$infoSaida[$idMedico] = array(
					"id" => $v['id'],
					"nome" => $v ['nome'],
					"crm" => $v['crm'],
					"site" => $v['site'],
					"cidade" => $v['cidade'],
					"telefone" => $v['telefone'],
					"whatsapp" => $v['whatsapp'],
					"imagem" => $v['imagem'],
					"especialidade_text" => $v['especialidade_text'],
					"status" => $v['status']
				);
			endif;
			if($v['especialidade']!="")
				$infoSaida[$idMedico]['especialidade'][$v['especialidade_id']] = $v['especialidade'];

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
			if($v['consultorio_nome']!=""){
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_id'] = $v['consultorio_id'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_nome'] = $v['consultorio_nome'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_descricao'] = $v['consultorio_descricao'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_site'] = $v['consultorio_site'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_email'] = $v['consultorio_email'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_telefone'] = $v['consultorio_telefone'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_imagem'] = $v['consultorio_imagem'];
				$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['consultorio_status'] = $v['consultorio_status'];
				
				if($v['servico_nome']!=""){
					$infoSaida[$idMedico]['consultorio'][$v['consultorio_id']]['servicos'][$v['servico_id']] = $v['servico_nome'];
				}
				//$infoSaida[$idMedico]['sintoma'][$v['sintoma_id']]['desc'] = $v['sintoma_descricao'];
			}
		}

		return (object) $infoSaida;
	}

	public static function executar($sql, $fetch) 
	{
		try {
			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();			
			switch ($fetch) {
				case 'all':
					$op->execute();
					return (object) $op->fetchall(PDO::FETCH_ASSOC);
					break;
				case 'one':
					$op->execute();
					return (object) $op->fetch(PDO::FETCH_ASSOC);
				default:
					return $op->execute();
					# code...
					break;
			}
		} catch (Exception $e) {
			print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
		}
	}

	public static function buscarItem($dadosTag, $buscar)
	{
		$limite = 2;
		foreach ($dadosTag as $key => $palavra):
			$lev = levenshtein(strtolower($buscar), strtolower($palavra['nome']));
			if($lev>2):
				$pos = strpos($palavra['nome'], ' ');
				
				if(is_numeric($pos)):
					$aux = "";
					$aux = explode(' ', $palavra['nome']);
					foreach ($aux as $k => $v) {
						$levAux = levenshtein(strtolower($buscar), strtolower($v));
						if($lev>$levAux):
							$lev = $levAux;
						endif;
					}
				endif;
			endif;

			if ($lev == 0):
				$saida[$palavra['id']] = array ("palavra" => $palavra['nome'], "id" => $palavra['id']);
				$levResult = 0;
			elseif ($lev <= $limite):
				$saida[$palavra['id']] = array ("sugestao" => $palavra['nome'], "id" => $palavra['id']);
				$levResult = $lev;
			endif;
		endforeach;

		if ($levResult == 0) {
			$saida["tipo"] = 1;
			$saida["limite"] = $levResult;
			return $saida;
		} elseif ($levResult > 2) {
			$saida["tipo"] = 3;
			return $saida;
		} elseif ($levResult <= 2) {
			$saida["tipo"] = 2;
			$saida["limite"] = $levResult;
			return $saida;
		}
	}

}
?>