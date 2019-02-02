<?php
	require_once "classes/conexao.php";
	require_once "controller/banner.php";

	class BannerModel extends BannerController {

		public $tabela = "tb_banners";
		public $campos = array("id" => null, "imagem" => null, "link" => null, "limite_visualizacao" => null, "limite_clique" => null, "data_inicio" => null, "data_fim" => null, "palavra_chave" => null);
		public $select = " * ";
		public $relation = "";
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>