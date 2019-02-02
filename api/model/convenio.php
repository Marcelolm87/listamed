<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ConvenioModel extends ControllerAbstract {

    public static $tabela = "tb_convenio";
    public static $campos = array("id" => null, "nome" => null, "descricao" => null, "status" => null);
    public static $select = " * ";
    public static $relation = "";
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>