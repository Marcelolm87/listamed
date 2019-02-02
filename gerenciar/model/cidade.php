<?php
require_once "classes/conexao.php";
require_once "controller/cidade.php";

class CidadeModel extends CidadeController {

    public $tabela = "tb_cidade";
    public $relation = array(
        "tabela" => "tb_estado", 
        "campo" => "tb_cidade.tb_estado_id = tb_estado.id", 
    );
    public $select = " tb_cidade.id, tb_cidade.nome as cidade, tb_estado.id as estado_id, tb_estado.nome as estado, tb_estado.sigla as estado_sigla ";
    public $campos = array("id" => null, "nome" => null, "tb_estado_id" => null);
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

    function __construct() {
        //print "In BaseClass constructor\n";
    }

}
?>