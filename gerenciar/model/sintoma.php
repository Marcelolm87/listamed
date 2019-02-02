<?php
	require_once "classes/conexao.php";
	require_once "controller/sintoma.php";

	class SintomaModel extends SintomaController {

		public $tabela = "tb_sintoma";
		public $campos = array("id" => null, "nome" => null, "descricao" => null);
		public $select = " * ";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>