<?php
	require_once "classes/conexao.php";
	require_once "controller/usuario.php";

	class UsuarioModel extends UsuarioController {

		public $tabela = "tb_users";
		public $campos = array("id" => null, "login" => null, "pass" => null, "token" => null, "dtcadastro" => null, "validtoken" => null, "tb_medico_id" => null);
		public $select = " * ";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>