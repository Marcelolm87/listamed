<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class PageModel extends ControllerAbstract {

    public static $tabela = "tb_page";
    public static $relation = "";
    public static $select = " * ";
    public static $campos = array( "id" => null, "banner_imagem" => null, "banner_titulo" => null, "banner_desc" => null, "banner_link" => null, "video_link" => null, "conteudo_titulo" => null, "conteudo_texto" => null, "conteudo_quantidade" => null, "conteudo_rodape" => null, "conteudo_link" => null, "rodape_direitos" => null, "contato_telefone" => "", "contato_email" => "", "contato_titulo" => "", "contato_texto" => "", "sobre_imagem" => "", "sobre_titulo" => "", "sobre_texto" => "", "planos_texto1" => "", "planos_texto2" => "", "termos" => "" );
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>