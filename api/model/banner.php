<?php
	require_once "classes/conexao.php";
	require_once "controller/abstract.php";

	class BannerModel extends ControllerAbstract {

		public static $tabela = "tb_banners";
		public static $campos = array("id" => null, "imagem" => null, "link" => null, "limite_visualizacao" => null, "limite_clique" => null, "data_inicio" => null, "data_fim" => null, "palavra_chave" => null);
		public static $select = " * ";
		public static $relation = "";
        public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>
