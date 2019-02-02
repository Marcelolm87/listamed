<?php
	require_once "classes/conexao.php";
	require_once "controller/abstract.php";

	class EnderecoModel extends ControllerAbstract {

		public $tabela = "tb_endereco";
		public $campos = array("id" => null, "endereco" => null, "numero" => null, "bairro" => null, "cep" => null, "tb_cidade_id" => null, "tipo" => null);
		public $select = " * ";
		public $relation = "";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>