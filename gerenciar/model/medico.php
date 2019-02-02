<?php
	require_once "classes/conexao.php";
	require_once "controller/medico.php";

	class MedicoModel extends MedicoController {

    public $tabela = "tb_medico";
    public $relation = array(
        "tabela" => " tb_endereco, tb_cidade, tb_estado ", 
        "campo"  => 
        	"tb_medico.tb_endereco_id = tb_endereco.id
        	and tb_endereco.tb_cidade_id = tb_cidade.id
        	and tb_cidade.tb_estado_id = tb_estado.id 
        	"
    );
    public $select = " 
    	tb_medico.id, 
    	tb_medico.nome, 
        tb_medico.crm, 
        tb_medico.especialidade_text, 
    	tb_medico.texto, 
    	tb_medico.email, 
    	tb_medico.site, 
        tb_medico.status, 
        tb_medico.imagem, 
        tb_medico.facebook, 
        tb_medico.instagram, 
        tb_medico.twitter, 
        tb_medico.telefone, 
        tb_medico.whatsapp, 
        tb_medico.periodo, 
        tb_medico.agenda_email, 
        tb_medico.agenda_telefone, 
        tb_medico.desconto, 
        tb_medico.destaque as destaque,
    	tb_medico.depoimento as depoimento,
        tb_medico.link_artigo, 
        tb_endereco.id as tb_endereco_id, 
        tb_endereco.endereco, 
        tb_endereco.numero, 
        tb_endereco.bairro, 
        tb_endereco.cep, 
        tb_endereco.tb_cidade_id,
        tb_cidade.nome as cidade,
        tb_cidade.tb_estado_id as tb_estado_id,
        tb_estado.nome as estado,
        tb_estado.sigla as estado_sigla
    	 ";
    public $campos = array("id" => null, "nome" => null, "crm" => null, "email" => null, "site" => null, "status" => null, "tb_endereco_id" => null, "imagem" => null, "facebook" => null, "instagram" => null, "twitter" => null, "telefone" => null, "whatsapp" => null, "especialidade_text" => null, "texto" => null, "periodo" => null, "agenda_email" => null, "agenda_telefone" => null, "desconto" => null, "link_artigo" => null, "destaque" => null, "depoimento" => null );
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);
	}
?>