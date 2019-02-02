<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ConvenioController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
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

        // buscando os campos no model
        if(@$dados['id']>0):
            $objDados = $this->BuscarPorCOD($dados['id'],false);
        else:
            $objDados = $this->getCampos();
        endif;

        // populando os campos 
        foreach ($this->campos as $key => $value) :
            $objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
        endforeach;

        // verificando permissoes
        if(isset($dados['op']))
            $op = $dados['op'];

        // salvando informações do model principal
        $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);
        $convenio = $this->UltimoRegistro();

        return $convenio;
    }
    /**
     * BuscarPorCOD encontra o registro usando o id
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarPorCODMedico($id, $cls=true) {
        try {
            $sql = "SELECT * FROM tb_medico_convenio 
					INNER JOIN tb_convenio ON tb_convenio.id = tb_medico_convenio.tb_convenio_id
					WHERE tb_medico_convenio.tb_medico_id = :cod";

            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":cod", $id);
            $op->execute();
            return (object) $op->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

        /**
    * deletar um registro
    * @param  [object] $value com o id a ser deletado
    * @return [object] retorna se o delete foi ou não executado
    */
    public function delete($value = null, $id=true)
    {
        try {
            //// deletando a ligação entre a doença e sintomas
            //$sql = "DELETE FROM tb_especialidade_doencas WHERE tb_especialidade_id = :id";
            //$op = Conexao::getInstance()->prepare($sql);
            //$op->bindValue(":id", $value->id);
            //$op->execute();
        
            // deletando a doença
            $sql = "DELETE FROM tb_convenio WHERE id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $value);
            $op->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }


}
?>