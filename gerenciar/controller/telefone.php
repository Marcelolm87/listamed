<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class TelefoneController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
    }

	/**
	 * BuscarPorCOD encontra o registro usando o id
	 * @param [int] $id recebe o id do registro a ser encontrado.
	 */
	public static function BuscarPorCODMedico($id, $cls=true) {
		try {
			$sql = "SELECT * FROM tb_telefone_medico 
					INNER JOIN tb_telefone ON tb_telefone.id = tb_telefone_medico.tb_telefone_id
					WHERE tb_telefone_medico.tb_medico_id = :cod";

   	    	$op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":cod", $id);
			$op->execute();
			return (object) $op->fetch(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
		}
	}

}
?>