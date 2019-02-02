<?php
require_once "classes/conexao.php";
require_once "model/pergunta.php";
require_once "model/usuario.php";

class perguntaController extends PerguntaModel {
    public static function BuscarPergunta($buscar)
    {
		$sql = "SELECT * FROM tb_perguntasfrequentes where pergunta like '%".$buscar."%' or resposta like '%".$buscar."%'"; 
		$dados = parent::executar($sql, 'all');

		return $dados;
    }

}

?>