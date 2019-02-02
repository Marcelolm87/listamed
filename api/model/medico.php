<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class MedicoModel extends ControllerAbstract {

    public static $tabela = "tb_medico";
    public static $relation = "";
    public static $select = " * ";
    public static $campos = array("id" => null, "nome" => null, "crm" => null, "email" => null, "site" => null, "imagem" => null, "tb_endereco_id" => null, "especialidade_text" => null, "texto" => null, "periodo" => null, "agenda_email" => null, "agenda_telefone" => null, "desconto" => null, "link_artigo" => null, "depoimento" => null );
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>