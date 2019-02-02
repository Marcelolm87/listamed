<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class ServicoController extends ControllerAbstract {

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
        unset($objDados->status);

        /* verificando permissoes */
        if(isset($dados['op']))
            $op = $dados['op'];

        /* salvando informações do model principal */
        return $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);
    }

    /**
     * BuscarPorCOD encontra o registro usando o id
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarPorCODConsultorio($id, $cls=true) {
        try {
            $sql = "SELECT * FROM tb_consultorio_servico WHERE tb_consultorio_id = :cod";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":cod", $id);
            $op->execute();
            return (object) $op->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

    /**
     * Buscar ultimo id inserido
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarUltimaID() {
        try {
            $sql = "SELECT max(id) as id FROM tb_consultorio_servico";
            $op = Conexao::getInstance()->prepare($sql);
            $op->execute();
            return (object) $op->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
        }
    }

     // function para salvar relação de medico e especialidade
    public function deleteServicoConsultorio($servico, $consultorio)
    {
        try {
            $sql = "DELETE FROM tb_consultorio_servico WHERE id = :id and tb_consultorio_id = :consultorio";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $servico);
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