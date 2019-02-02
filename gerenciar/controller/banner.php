<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class BannerController extends ControllerAbstract {

    /**
     * preparando os dados
     * @param  [string] $metodo metodo de envio
     * @param  [object] $dados do registro
     * @return [object] Codigo do retorno e mensagem (as vezes dados).
     */
    public static function banner_save($imagem, $metodo=null)
    {
        $op = null;

        // recebendo informações do request
        $dados = $this->retornaRequest($_SERVER['REQUEST_METHOD']);

        // buscando os campos no model
        if(@$dados['id']>0):
            $objDados = $this->BuscarPorCOD($dados['id'],false)->data;
        else:
            $objDados = $this->getCampos();
        endif;

        // populando os campos 
        foreach ($this->campos as $key => $value) :
            $objDados->$key = (isset($dados[$key])) ? $dados[$key] : null ;
        endforeach;

        $objDados->imagem = $imagem;

        // verificando permissoes
        if(isset($dados['op']))
            $op = $dados['op'];

        if(@$dados['id']>0):
    		$requestMode = "PUT";
    	else:
    		$requestMode = "POST";
		endif;

        // salvando informações do model principal
        return $this->processando($requestMode, $objDados, $this->permissoes, $op);

    }

    public static function banner_delete($id)
    {
        try {
            $sql = "DELETE FROM tb_banners WHERE id = :id";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $id);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
    
}
?>
