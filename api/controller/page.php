<?php
require_once "classes/conexao.php";
require_once "model/page.php";
require_once "model/usuario.php";

class PageController extends PageModel {
    public static function BuscarPagina()
    {
		$sql = "SELECT * FROM tb_page where tb_page.id = 1"; 
		$dados = parent::executar($sql, 'one');
		return $dados;
    }

    public static function BuscarMedicosDestaque()
    {
		$sql = "SELECT 
					tb_medico.id, 
					tb_medico.nome, 
					tb_medico.crm, 
					tb_medico.imagem,
					tb_especialidade.id as especialidade_id,
					tb_especialidade.nome as especialidade,
					tb_medico.depoimento as depoimento
				FROM tb_medico
					LEFT JOIN tb_medico_especialidade ON tb_medico_especialidade.tb_medico_id = tb_medico.id
					LEFT JOIN tb_especialidade ON tb_medico_especialidade.tb_especialidade_id = tb_especialidade.id
				WHERE
					tb_medico.status = 1 and tb_medico.destaque = 1"; 
		$dados = parent::executar($sql, 'all');
		return $dados;
    }


}

?>