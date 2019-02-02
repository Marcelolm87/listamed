<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class GaleriaController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
    }

	/**
	 * BuscarPorCOD encontra o registro usando o id
	 * @param [int] $id recebe o id do registro a ser encontrado.
	 */
	public static function BuscarPorCODConsultorio($id, $cls=true) {
		try {
    		$sql = "SELECT * FROM tb_consultorio_imagens WHERE tb_consultorio_id = :cod";
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

    function salvarImagem($imagem, $consultorio){
        $sql = "INSERT INTO tb_consultorio_imagens ( tb_consultorio_id, imagem ) VALUES ( :consultorio, :imagem )";
        $op = Conexao::getInstance()->prepare($sql);
        return $op->execute(array(':consultorio' => $consultorio , ':imagem' => $imagem ));
    }
    
    public function deleteImagem($id, $consultorio)
    {
        try {
            $sql = "DELETE FROM tb_consultorio_imagens WHERE id = :id and tb_consultorio_id = :consultorio";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $id);
            $op->bindValue(":consultorio", $consultorio);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }




}
?>