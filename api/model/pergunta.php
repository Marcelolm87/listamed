<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class PerguntaModel extends ControllerAbstract {

    public static $tabela = "tb_perguntasfrequentes";
    public static $relation = "";
    public static $select = " * ";
    public static $campos = array( "id" => null, "pergunta" => null, "resposta" => null, "status" => null );
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>