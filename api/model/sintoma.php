<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class SintomaModel extends ControllerAbstract {

	public static $tabela = "tb_sintoma";
	public static $campos = array("id" => null, "nome" => null, "descricao" => null);
	public static $select = " * ";
	public static $relation = "";
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>