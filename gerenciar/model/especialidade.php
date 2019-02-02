<?php
	require_once "classes/conexao.php";
	require_once "controller/especialidade.php";

	class EspecialidadeModel extends EspecialidadeController {

		public $tabela = "tb_especialidade";
		public $campos = array("id" => null, "nome" => null);
		public $select = " * ";
		public $relation = "";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>