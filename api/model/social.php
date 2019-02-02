<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class SocialModel extends ControllerAbstract {

	public static $tabela = "tb_redesocial";
	public static $campos = array("id" => null, "nome" => null, "link" => null, "tb_medico_id" => null);
	public static $select = " * ";
	public static $relation = "";
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>