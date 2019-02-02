<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";
require_once "classes/upload.php";

class ConsultorioController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
    }

    public static function BuscarPorCEP($cep)
    {
        $cepOrganiza = str_replace("-", "", $cep);
        $cepOrganizaTraco  = sprintf( '%s-%s', substr( $cepOrganiza, 0, strlen( $cepOrganiza ) - 3), substr( $cepOrganiza, -3, strlen( $cepOrganiza ) + 1  ) );
        $sql = "SELECT tb_consultorio.id, tb_consultorio.nome, tb_consultorio.tb_endereco_id, tb_endereco.endereco, tb_endereco.numero, tb_endereco.bairro, tb_endereco.bairro, tb_endereco.cep, tb_endereco.tb_cidade_id FROM tb_consultorio, tb_endereco where tb_endereco.id = tb_consultorio.tb_endereco_id and ( tb_endereco.cep = '$cepOrganiza' or tb_endereco.cep = '$cepOrganizaTraco' ) GROUP BY tb_endereco.id ASC "; 
        $dados = parent::executar($sql, 'all');
        return $dados;
    }

    public static function BuscarPorNome($nome)
    {
        $sql = "SELECT tb_consultorio.id, tb_consultorio.nome, tb_consultorio.tb_endereco_id, tb_endereco.endereco, tb_endereco.numero, tb_endereco.bairro, tb_endereco.bairro, tb_endereco.cep, tb_endereco.tb_cidade_id FROM tb_consultorio, tb_endereco where tb_endereco.tipo = 'c' and tb_endereco.id = tb_consultorio.tb_endereco_id and ( tb_consultorio.nome LIKE '%$nome%' ) GROUP BY tb_endereco.id ASC "; 
        $dados = parent::executar($sql, 'all');
        return $dados;
    }

    /**
     * preparando os dados
     * @param  [string] $metodo metodo de envio
     * @param  [object] $dados do registro
     * @return [object] Codigo do retorno e mensagem (as vezes dados).
     */
    function save($metodo=null, $imagem=null)
    {
        $op = null;

        // recebendo informações do request
        $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);
        $dados['imagem'] = $imagem;

        foreach ($dados[periodo] as $kP => $vP) :
            $periodo .= $kP." ";  
        endforeach;
        

        $periodo = str_replace(" ", ",", trim($periodo));
        $dados['periodo'] = $periodo;

        // buscando os campos no model - consultorio
        if(@$dados['id']>0):
            $objDados = $this->BuscarPorCOD($dados['id'],false)->data;
        else:
            $objDados = $this->getCampos();
        endif;

        // populando os campos  - consultorio
        foreach ($this->campos as $key => $value) {
            if($key!="imagem"):
                $objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
            endif;
        }

        // apagando os valores antigos
        unset($objDados->data);
        //unset($objDados->status);

        // inserindo model relation
        require_once("model/endereco.php");
        // iniciando o model
        $enderecoModel = new EnderecoModel();
        // buscando os campos
        if(@$objDados->tb_endereco_id>0):
            $objDadosEndereco = $enderecoModel->BuscarPorCOD($objDados->tb_endereco_id);
            $objDadosEndereco = $objDadosEndereco->data;
        elseif(@$objDados->data->tb_endereco_id>0):
            $objDadosEndereco = $enderecoModel->BuscarPorCOD($objDados->data->tb_endereco_id);
            $objDadosEndereco = $objDadosEndereco->data;
        else:
            $objDadosEndereco = $enderecoModel->getCampos();
        endif;

        /* populando os campos */
        foreach ($objDadosEndereco as $key => $value) {
            $objDadosEndereco->$key = (isset($dados['endereco'][$key])) ? $dados['endereco'][$key] : null ;
        }
        /* verificando se é insert ou update */
        if(@$objDados->tb_endereco_id>0):
            $objDadosEndereco->id = $objDados->tb_endereco_id;
        elseif(@$objDados->data->tb_endereco_id>0):
            $objDadosEndereco->id = $objDados->data->tb_endereco_id;
        endif;
        
        $objDadosEndereco->tipo = 'c';
        /* salvando as informações */
        $retornoEndereco = $enderecoModel->processando($_SERVER['REQUEST_METHOD'],$objDadosEndereco,$this->permissoes,$op);

        /* ligando a informações relation ao model principal 
        if($_SERVER['REQUEST_METHOD']=="POST"):
            if($retornoEndereco==true):
                $dadosEndereco = $enderecoModel->UltimoRegistro();
                // inserindo informações de consultorio 
                $objDados->tb_endereco_id = $dadosEndereco->data->id;
            endif;
        endif;*/

        /* verificando permissoes */
        if(isset($dados['op']))
            $op = $dados['op'];

        if(@$imagem!=null):
            $objDados->imagem = $imagem;
        endif;

        /* salvando informações do model principal */
        return $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);
    }

    /**
     * BuscarPorCOD encontra o registro usando o id
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarPorCODMedico($id, $cls=true) {
        try {
            $sql = "SELECT * FROM tb_consultorio_medico 
                    INNER JOIN tb_consultorio ON tb_consultorio.id = tb_consultorio_medico.tb_consultorio_id
                    WHERE tb_consultorio_medico.tb_medico_id = :cod";

            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":cod", $id);
            $op->execute();
            return (object) $op->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
            print_r ($e);
        }
    }

    /**
     * Buscar ultimo id inserido
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarUltimaID() {
        try {
            $sql = "SELECT max(id) as id FROM tb_consultorio";
            $op = Conexao::getInstance()->prepare($sql);
            $op->execute();
            return (object) $op->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
            print_r ($e);
        }
    }

    /**
     * BuscarPorCOD encontra o registro usando o id
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarConvenioPorCOD($id, $cls=true) {
        try {
            $sql = "SELECT * FROM tb_consultorio_convenio 
                    INNER JOIN tb_convenio ON tb_convenio.id = tb_consultorio_convenio.tb_convenio_id
                    WHERE tb_consultorio_convenio.tb_consultorio_id = :cod";

            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":cod", $id);
            $op->execute();
            return (object) $op->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
            print_r ($e);
        }
    }

    public function saveConsultorioConvenio($consultorio, $convenio)
    {
        try {
            $sql = "INSERT INTO tb_consultorio_convenio ( tb_consultorio_id, tb_convenio_id ) VALUES ( $consultorio, $convenio )";
            $op = Conexao::getInstance()->prepare($sql);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }

    public function deleteConvenioConsultorio($consultorio, $convenio)
    {
        try {
            $sql = "DELETE FROM tb_consultorio_convenio WHERE tb_consultorio_id = :tb_consultorio_id and  tb_convenio_id = :tb_convenio_id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":tb_consultorio_id", $consultorio);
            $op->bindValue(":tb_convenio_id", $convenio);
            $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
   
    /**
     * BuscarPorCOD encontra o registro usando o id
     * @param [int] $id recebe o id do registro a ser encontrado.
     */
    public static function BuscarPorCODConsultorio($id, $cls=true) {
        try {
            $sql = "select tcm.id, tcm.tb_consultorio_id, tcm.tb_medico_id, tm.nome from tb_consultorio_medico tcm, tb_medico tm where tcm.tb_consultorio_id = :cod and tcm.tb_medico_id = tm.id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":cod", $id);
            $op->execute();
            return (object) $op->fetchall(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, tente novamente mais tarde.";
            print_r ($e);
        }
    }


}
?>
