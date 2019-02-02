<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class DoencaController extends ControllerAbstract {

    /**
     * preparando os dados
     * @param  [string] $metodo metodo de envio
     * @param  [object] $dados do registro
     * @return [object] Codigo do retorno e mensagem (as vezes dados).
     */
    function save($metodo=null)
    {
        $op = null;

        /* recebendo informações do request */
        $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);

        /* buscando os campos no model */
        if($dados['id']>0):
            $objDados = $this->BuscarPorCOD($dados['id'],false);
        else:
            $objDados = $this->getCampos();
        endif;

        /* populando os campos */
        foreach ($this->campos as $key => $value) :
            if($key!="tb_endereco_id")
                $objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
        endforeach;

        /* verificando permissoes */
        if(isset($dados['op']))
            $op = $dados['op'];

        /* salvando informações do model principal */
        $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);
        $doenca = $this->UltimoRegistro();

        /* inserir sintomas */
        require_once('model/sintoma.php');
        $sintomaModel = new SintomaModel();

        foreach ($dados['sintoma'] as $ks => $vs) :
        	$sintoma = $sintomaModel->BuscarPorCOD($vs,false);
        	if($sintoma->id > 0):
        		$retorno = $this->saveDoencaSintoma($sintoma->id, $doenca['id']);
        	endif;
        endforeach;
    }

	public function saveDoencaSintoma($sintoma, $doenca)
	{
		try {

echo "<pre>"; print_r($sintoma); echo "</pre>";
echo "<pre>"; print_r($doenca); echo "</pre>";
exit;


			$count=0;
			$infoCampos = "";
			$infoTags = "";
			foreach ($this->campos as $k => $v) {
				$infoCampos .= ($count==0) ? $k : ', '.$k;
				$infoTags .= ($count==0) ? ':'.$k : ', :'.$k;
				$count++;
			}
			foreach ($dados as $k => $v) {
				$infoDados[":$k"] = $v;
			}
			$sql = "INSERT INTO tb_doencas_sintomas ( tb_doencas_id, tb_sintomas_id ) VALUES ( $doenca, $sintoma )";
			$op = Conexao::getInstance()->prepare($sql);
			return $op->execute($infoDados);
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
            // deletando a ligação entre a doença e sintomas
            $sql = "DELETE FROM tb_doencas_sintomas WHERE tb_doencas_id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $value->id);
            $op->execute();
        
            // deletando a doença
            $sql = "DELETE FROM tb_doenca WHERE id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $value->id);
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
            
            /* recebendo informações do request */
            $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);

            foreach ($dados as $k => $v) {
                if($k!="sintoma")
                    $infoDados[":$k"] = $v;
            }
            $sql = "UPDATE tb_doenca set $infoUpdate WHERE id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->execute($infoDados);

            // deletando a ligação entre a doença e sintomas 
            $sql = "DELETE FROM tb_doencas_sintomas WHERE tb_doencas_id = :id";
            $deleteID = array ( ":id" => $infoDados[':id'] );
            $op = Conexao::getInstance()->prepare($sql);

            $op->execute($deleteID);

            // inserir sintomas
            require_once('model/sintoma.php');
            $sintomaModel = new SintomaModel();
               
            $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);
            foreach ($dados as $k => $v) {
                $infoDados[":$k"] = $v;
            }

            foreach ($infoDados[':sintoma']['id'] as $ks => $vs) :
                $sintoma = $sintomaModel->BuscarPorCOD($vs);
                if($sintoma->id > 0):
                    $retorno = $this->saveDoencaSintoma($sintoma->id, $infoDados[':id']);
                endif;

            endforeach;
            return "Atualizado com sucesso.";
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
        }
    }

}
?>