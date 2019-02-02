<?php
require_once "classes/conexao.php";
require_once "controller/pagina.php";

class PaginaModel extends PaginaController {

    public $tabela = "tb_paginas";
    public $select = " * ";
    public $campos = array("id" => null, "titulo" => null, "texto" => null);
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

    function __construct() {
        //print "In BaseClass constructor\n";
    }

}
?>