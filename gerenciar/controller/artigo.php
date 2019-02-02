<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ArtigoController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
    }

	/**
	 * BuscarPorCOD encontra o registro usando o id
	 * @param [int] $id recebe o id do registro a ser encontrado.
	 */
	public static function BuscarPorCODMedico($id, $cls=true) {
		try {
			$sql = "SELECT * FROM tb_artigo WHERE tb_artigo.tb_medico_id = :cod";

   	    	$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":cod", $id);
			$op->execute();
			$dados = (object) $op->fetchall(PDO::FETCH_ASSOC);

			return (object) array(
				"status" => 200,
				"data" => $dados
			);

		} catch (Exception $e) {
			print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
		}
	}


}
?>