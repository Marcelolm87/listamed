<?php
	require_once "classes/conexao.php";
	require_once "controller/galeria.php";

	class GaleriaModel extends GaleriaController {

	    public $tabela = "tb_consultorio_imagens";
	    public $relation = array(
	        "tabela" => " tb_consultorio ", 
	        "campo"  => 
	        	"tb_consultorio_imagens.tb_consultorio_id = tb_consultorio.id "
	    );
	    public $select = " 
	    	tb_consultorio_imagens.id, 
	    	tb_consultorio_imagens.tb_consultorio_id, 
	        tb_consultorio_imagens.imagem,
	        tb_consultorio.nome
	    	 ";
	    public $campos = array("id" => null, "tb_consultorio_id" => null, "nome" => null );
	    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>