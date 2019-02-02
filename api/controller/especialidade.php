<?php
require_once "classes/conexao.php";
require_once "model/especialidade.php";
require_once "model/usuario.php";

class EspecialidadeController extends EspecialidadeModel {
	
	public static function post($objDados, $admin=false)
	{
		if(!$admin){
	    	$info = UsuarioController::atualizarPermissoes();
    	}

    	// verificar se o usuario é o dono da informação
    	if( ($info->valido == "valido") || ($admin==true) ) {
			$dados = ControllerAbstract::retornaRequest();
			
			foreach (static::$campos as $key => $value) {
				$objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
			}

	        if(isset($dados['op']))
				$op = $dados['op'];

			$retornoEspecialidade = parent::Inserir(static::$tabela,$objDados, static::$campos);

			static::saveEspecialidadeDoenca($retornoEspecialidade->data->id,$dados['doencas']);
			return $retornoEspecialidade;

		}else{
			return $info;
		}
	}

	public static function saveEspecialidadeDoenca($especialidade, $doencas)
	{
        try {
        	$doenca = explode(',', $doencas);
        	foreach ($doenca as $k => $v) {
	            $sql = "INSERT INTO tb_especialidade_doencas ( tb_especialidade_id, tb_doencas_id ) VALUES ( $especialidade, $v )";
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

	public static function saveEspecialidade($medico, $especialidade)
	{
        try {
		
			$sql = "SELECT * FROM tb_medico_especialidade WHERE tb_medico_id = $medico AND tb_especialidade_id = $especialidade";
			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();
			$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

			if(! $dados->tb_medico_id > 0):
	            $sql = "INSERT INTO tb_medico_especialidade ( tb_medico_id, tb_especialidade_id ) VALUES ( $medico, $especialidade )";
	            $op = Conexao::getInstance()->prepare($sql);
	            $op->execute();
	        	return('ok');
        	endif;
        	return('registro já existe');
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }    
	}

	public static function deletarEspecialidade($medico, $especialidade)
	{
        try {
			parse_str(file_get_contents('php://input'), $dados);
			$medico = $dados['medico'];
			$especialidade = $dados['especialidade'];

			$sql = "SELECT * FROM tb_medico_especialidade WHERE tb_medico_id = $medico AND tb_especialidade_id = $especialidade";
			$op = Conexao::getInstance()->prepare($sql);
			$op->execute();
			$dados = (object) $op->fetch(PDO::FETCH_ASSOC);

			if($dados->tb_medico_id > 0):
				$sql = "DELETE FROM tb_medico_especialidade WHERE tb_medico_id = :medico and tb_especialidade_id = :especialidade";
				$op = Conexao::getInstance()->prepare($sql);
				$op->bindValue(":medico", $medico);
				$op->bindValue(":especialidade", $especialidade);
				return $op->execute();
        	else:
        		return('registro não encontrado');
    		endif;
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }    
	}

}
?>