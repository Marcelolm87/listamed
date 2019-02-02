<?php
	require_once "classes/conexao.php";
	require_once "controller/doenca.php";

	class DoencaModel extends DoencaController {

		public $tabela = "tb_doenca";
		public $campos = array("id" => null, "nome" => null, "descricao" => null);
		public $select = " * ";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>