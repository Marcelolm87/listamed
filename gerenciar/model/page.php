<?php
	require_once "classes/conexao.php";
	require_once "controller/page.php";

	class PageModel extends PageController {

        public $tabela = "tb_page";
        public $select = " 
        	tb_page.id, 
        	tb_page.banner_imagem, 
            tb_page.banner_titulo, 
            tb_page.banner_desc, 
        	tb_page.banner_link, 
        	tb_page.video_link, 
        	tb_page.conteudo_titulo, 
            tb_page.conteudo_texto, 
            tb_page.conteudo_quantidade, 
            tb_page.conteudo_rodape, 
            tb_page.conteudo_link, 
            tb_page.rodape_direitos,
            tb_page.contato_telefone,
            tb_page.contato_email,
            tb_page.contato_titulo,
            tb_page.contato_texto,
            tb_page.sobre_imagem,
            tb_page.sobre_titulo,
            tb_page.sobre_texto,
            tb_page.planos_texto1,
            tb_page.planos_texto2,
            tb_page.sms_cliente,
            tb_page.sms_profissional,
            tb_page.email_confirmacao_pedido,
            tb_page.sms_confirmacao_pedido,
            tb_page.facebook,
            tb_page.instagram,
            tb_page.linkedin,
            tb_page.termos
        	 ";
        public $campos = array( "id" => null, "banner_imagem" => null, "banner_titulo" => null, "banner_desc" => null, "banner_link" => null, "video_link" => null, "conteudo_titulo" => null, "conteudo_texto" => null, "conteudo_quantidade" => null, "conteudo_rodape" => null, "conteudo_link" => null, "rodape_direitos" => null, "contato_telefone" => "", "contato_email" => "", "contato_titulo" => "", "contato_texto" => "", "sobre_imagem" => "", "sobre_titulo" => "", "sobre_texto" => "", "planos_texto1" => "", "planos_texto2" => "", "sms_cliente" => "", "sms_profissional" => "" , "email_confirmacao_pedido" => "" , "sms_confirmacao_pedido" => "" , "facebook" => "", "instagram" => "", "linkedin" => "", "termos" => "" );
        public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

	}
?>
