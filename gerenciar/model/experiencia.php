<?php 
require_once "classes/conexao.php";
require_once "controller/experiencia.php";

class ExperienciaModel extends ExperienciaController {

    public $tabela = "tb_experiencia";
    public $relation = array(
        "tabela" => " tb_medico ", 
        "campo"  => 
        	"tb_experiencia.tb_medico_id = tb_medico.id"
    );
    public $select = " 
    	tb_experiencia.id, 
    	tb_experiencia.nome, 
    	tb_experiencia.descricao, 
    	tb_experiencia.datainicio, 
    	tb_experiencia.datafim, 
    	tb_experiencia.local, 
    	tb_experiencia.imagem, 
    	tb_experiencia.status, 
        tb_experiencia.tb_medico_id as medico_id, 
        tb_experiencia.titulo,
    	tb_experiencia.orientador,
    	tb_medico.id as tb_endereco_id, 
    	tb_medico.nome as medico_nome, 
    	tb_medico.crm as medico_crm, 
    	tb_medico.email as medico_email, 
    	tb_medico.site as medico_site
    	 ";
    public $campos = array("id" => null, "nome" => null, "descricao" => null, "datainicio" => null, "datafim" => null, "local" => null, "imagem" => null, "status" => null, "tb_medico_id" => null, "titulo" => null, "orientador" => null );
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>