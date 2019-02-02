<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class CidadeModel extends ControllerAbstract {

    public static $tabela = "tb_cidade";
    public static $relation = array(
        "tabela" => "tb_estado", 
        "campo" => "tb_cidade.tb_estado_id = tb_estado.id", 
    );
    public static $select = " tb_cidade.id, tb_cidade.nome as cidade, tb_estado.id as estado_id, tb_estado.nome as estado, tb_estado.sigla as estado_sigla ";
    public static $campos = array("id" => null, "nome" => null, "tb_estado_id" => null);
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>