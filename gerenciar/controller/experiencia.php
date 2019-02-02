<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ExperienciaController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
    }

	/**
	 * BuscarPorCOD encontra o registro usando o id
	 * @param [int] $id recebe o id do registro a ser encontrado.
	 */
	public static function BuscarPorCODMedico($id, $cls=true) {
		try {
    		$sql = "SELECT * FROM tb_experiencia WHERE tb_medico_id = :cod";
	   	    $op = Conexao::getInstance()->prepare($sql);
			$op->bindValue(":cod", $id);
			$op->execute();
			return (object) $op->fetchall(PDO::FETCH_ASSOC);
		} catch (Exception $e) {
			print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
		}
	}

    /**
     * preparando os dados
     * @param  [string] $metodo metodo de envio
     * @param  [object] $dados do registro
     * @return [object] Codigo do retorno e mensagem (as vezes dados).
     */
    function save($metodo=null)
    {
        $op = null;

        // recebendo informações do request
        $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);

        // buscando os campos no model - consultorio
        if(@$dados['id']>0):
            $objDados = $this->BuscarPorCOD($dados['id'],false);
        else:
            $objDados = $this->getCampos();
        endif;

        // populando os campos  - consultorio
        foreach ($this->campos as $key => $value) {
            $objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
        }
        // apagando os valores antigos
        unset($objDados->data);

        /* verificando permissoes */
        if(isset($dados['op']))
            $op = $dados['op'];

        /* salvando informações do model principal */
        return $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);
    }


}
?>