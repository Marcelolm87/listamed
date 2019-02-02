<?php
require_once "classes/conexao.php";
require_once "controller/servico.php";

class ServicoModel extends ServicoController {

    public $tabela = "tb_consultorio_servico";
    public $relation = array(
        "tabela" => " tb_consultorio", 
        "campo"  => 
        	"tb_consultorio.id = tb_consultorio_servico.tb_consultorio_id"
    );
    public $select = " 
    	tb_consultorio_servico.id, 
        tb_consultorio_servico.tb_consultorio_id, 
        tb_consultorio_servico.nome
    	 ";
    public $campos = array("id" => null, "tb_consultorio_id" => null, "nome" => null);
    public $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>