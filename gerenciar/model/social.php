<?php
	require_once "classes/conexao.php";
	require_once "controller/social.php";

	class SocialModel extends SocialController {

	    public $tabela = "tb_redesocial";
	    public $relation = array(
	        "tabela" => " tb_medico ", 
	        "campo"  => 
	        	"tb_redesocial.tb_medico_id = tb_medico.id"
	    );
	    public $select = " 
	    	tb_redesocial.id, 
	    	tb_redesocial.nome, 
	    	tb_redesocial.link, 
	    	tb_redesocial.tb_medico_id as medico_id, 
	    	tb_medico.id as tb_endereco_id, 
	    	tb_medico.nome as medico_nome, 
	    	tb_medico.crm as medico_crm, 
	    	tb_medico.email as medico_email, 
	    	tb_medico.site as medico_site
	    	 ";
	    public $campos = array("id" => null, "nome" => null, "link" => null, "tb_medico_id" => null);
	    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>