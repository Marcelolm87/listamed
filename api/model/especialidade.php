<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class EspecialidadeModel extends ControllerAbstract {

	public static $tabela = "tb_especialidade";
	public static $campos = array("id" => null, "nome" => null);
	public static $select = " * ";
	public static $relation = " * ";
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>