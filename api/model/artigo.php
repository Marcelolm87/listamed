<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ArtigoModel extends ControllerAbstract {

    public static $tabela = "tb_artigo";
    public static $relation = array(
        "tabela" => " tb_medico ", 
        "campo"  => 
        	"tb_artigo.tb_medico_id = tb_medico.id"
    );
    public static $select = " 
    	tb_artigo.id, 
    	tb_artigo.titulo, 
    	tb_artigo.texto, 
    	tb_artigo.status, 
    	tb_artigo.tb_medico_id as medico_id, 
    	tb_medico.id as tb_endereco_id, 
    	tb_medico.nome as medico_nome, 
    	tb_medico.crm as medico_crm, 
    	tb_medico.email as medico_email, 
    	tb_medico.site as medico_site
    	 ";
    public static $campos = array("id" => null, "titulo" => null, "texto" => null, "status" => null, "tb_medico_id" => null);
    public static $permissoes = array (
    	"public" => array (
    		"get" => true,
    		"post" => false,
    		"delete" => false,
    		"put" => false
    	),
    	"logado" => array (
    		"get" => true,
    		"post" => true,
    		"delete" => true,
    		"put" => true
    	),
    );


}
?>