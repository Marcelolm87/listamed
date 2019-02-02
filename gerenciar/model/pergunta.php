<?php
require_once "classes/conexao.php";
require_once "controller/pergunta.php";

class PerguntaModel extends PerguntaController {

    public $tabela = "tb_perguntasfrequentes";
    public $select = " * ";
    public $campos = array("id" => null, "pergunta" => null, "resposta" => null, "status" => null);
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

    function __construct() {
        //print "In BaseClass constructor\n";
    }

}
?>