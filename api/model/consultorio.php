<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ConsultorioModel extends ControllerAbstract {

    public static $tabela = "tb_consultorio";
    public static $relation = array(
        "tabela" => " tb_endereco, tb_cidade, tb_estado ", 
        "campo"  => 
        	"tb_consultorio.tb_endereco_id = tb_endereco.id
        	and tb_endereco.tb_cidade_id = tb_cidade.id
        	and tb_cidade.tb_estado_id = tb_estado.id 
        	"
    );
    public static $select = " 
    	tb_consultorio.id, 
    	tb_consultorio.nome, 
    	tb_consultorio.descricao, 
    	tb_consultorio.site, 
    	tb_consultorio.email, 
        tb_consultorio.telefone, 
        tb_consultorio.imagem, 
        tb_consultorio.status, 
        tb_consultorio.periodo, 
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
    public static $campos = array("id" => null, "nome" => null, "tb_endereco_id" => null, "descricao" => null, "site" => null, "email" => null, "telefone" => null, "imagem" => null, "status" => null, "periodo" => null);
    public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>