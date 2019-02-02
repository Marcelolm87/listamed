<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class EspecialidadeController extends ControllerAbstract {

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
        $especialidade = $this->UltimoRegistro();

        return $especialidade;
    }

    public function saveDoencaEspecialidade($doenca, $especialidade)
    {
        try {
            $sql = "INSERT INTO tb_especialidade_doencas ( tb_doencas_id, tb_especialidade_id ) VALUES ( $doenca, $especialidade )";
            $op = Conexao::getInstance()->prepare($sql);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
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
            $sql = "DELETE FROM tb_especialidade WHERE id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $value);
            $op->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }

    /**
    * atualizar um registro
    * @param  [object] $value todas as informações e id a ser atualizadas
    * @return [object] retorna se o updade foi ou não executado
    */
    public function put($value = null)
    {
        try {
            $count=0;
            $infoUpdate = "";

            foreach ($this->campos as $k => $v) {
                if($k!="id"):
                    $infoUpdate .= ($count==0) ? "$k = :$k" : ", $k = :$k";
                    $count++;
                endif;
            }
            
            // recebendo informações do request
            $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);

            foreach ($dados as $k => $v) {
                if($k!="doenca")
                    $infoDados[":$k"] = $v;
            }
            $sql = "UPDATE tb_especialidade set $infoUpdate WHERE id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->execute($infoDados);
            
            // deletando a ligação entre a especialidade e a doença 
            $sql = "DELETE FROM tb_especialidade_doencas WHERE tb_especialidade_id = :id";
            $deleteID = array ( ":id" => $infoDados[':id'] );
            $op = Conexao::getInstance()->prepare($sql);
            $op->execute($deleteID);

            // inserir doença
            require_once('model/doenca.php');
            $doencaModel = new DoencaModel();
               
            $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);
            foreach ($dados as $k => $v) {
                $infoDados[":$k"] = $v;
            }

            foreach ($infoDados[':doenca']['id'] as $ks => $vs) :
                $doenca = $doencaModel->BuscarPorCOD($vs);
                if($doenca->id > 0):
                    $retorno = $this->saveDoencaEspecialidade($doenca->id, $infoDados[':id']);
                endif;

            endforeach;
            return "Atualizado com sucesso.";
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }

    }

    /**
     * BuscarPorCOD encontra o registro usando o id
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarPorCODMedico($id, $cls=true) {
        try {
            $sql = "SELECT * FROM tb_medico_especialidade 
                    INNER JOIN tb_especialidade ON tb_especialidade.id = tb_medico_especialidade.tb_especialidade_id
                    WHERE tb_medico_especialidade.tb_medico_id = :cod";

            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":cod", $id);
            $op->execute();
            return (object) $op->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar buscar a especialidade desse medico.";
        }
    }


}
?>
