<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class EstadoModel extends ControllerAbstract {

    public static $tabela = "tb_estado";
    public static $relation = "";
    public static $select = " * ";
    public static $campos = array("id" => null, "nome" => null, "sigla" => null);
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>