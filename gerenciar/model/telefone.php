<?php
require_once "classes/conexao.php";
require_once "controller/telefone.php";

class TelefoneModel extends TelefoneController {

    public $tabela = "tb_telefone";
    public $campos = array("id" => null, "numero" => null);
    public $select = " * ";
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

    function __construct() {
        //print "In BaseClass constructor\n";
    }

}
?>