<?php
	require_once "classes/conexao.php";
	require_once "controller/abstract.php";

	class EstadoModel extends ControllerAbstract {

		public $tabela = "tb_estado";
		public $campos = array("id" => null, "nome" => null, "sigla" => null);
		public $select = " * ";
		public $relation = "";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>