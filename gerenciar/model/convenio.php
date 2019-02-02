<?php
	require_once "classes/conexao.php";
	require_once "controller/convenio.php";

	class ConvenioModel extends ConvenioController {

		public $tabela = "tb_convenio";
		public $campos = array("id" => null, "nome" => null, "descricao" => null, "status" => null);
		public $select = " * ";
		public $relation = "";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>