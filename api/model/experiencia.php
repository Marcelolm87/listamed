<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ExperienciaModel extends ControllerAbstract {

    public static $tabela = "tb_experiencia";
    public static $relation = "";
    public static $select = " * ";
    public static $campos = array("id" => null, "nome" => null, "descricao" => null, "datainicio" => null, "datafim" => null, "local" => null, "imagem" => null, "status" => null, "tb_medico_id" => null);
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>