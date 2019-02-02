<?php
	require_once "classes/conexao.php";
	require_once "controller/usuario.php";

	class UsuarioModel extends UsuarioController {

		public static $tabela = "tb_users";
		public static $campos = array("id" => null, "login" => null, "pass" => null, "token" => null, "dtcadastro" => null, "validtoken" => null, "tb_medico_id" => null);
		public static $select = " * ";
        public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>