<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class EnderecoModel extends ControllerAbstract {

	public static $tabela = "tb_endereco";
	public static $campos = array("id" => null, "endereco" => null, "numero" => null, "bairro" => null, "cep" => null, "tb_cidade_id" => null);
	public static $select = " * ";
       public static $relation = array(
        "tabela" => "tb_cidade", 
        "campo" => "tb_cidade.id = tb_endereco.tb_cidade_id", 
    );
   public static $permissoes = array ("get"=>true,"post"=>true,"delete"=>true,"put"=>true);

}
?>