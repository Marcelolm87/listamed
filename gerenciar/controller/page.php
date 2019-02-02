<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class PageController extends ControllerAbstract {
    
    function __construct() {
        //print "In BaseClass constructor\n";
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

        // buscando os campos no model
        if($dados['id']>0):
            $objDados = $this->BuscarPorCOD($dados['id'],false);
        else:
            $objDados = $this->getCampos();
        endif;

        // populando os campos
        foreach ($this->campos as $key => $value) {
            if($key!="tb_endereco_id"){
                if(isset($dados[$key])){
                    if($dados[$key]!=""){
                        $objDados->$key = $dados[$key];
                    }else{
                        $objDados->$key = @$objDados->data->$key;
                    }
                }else{
                    $objDados->$key = @$objDados->data->$key ;
                }
            }
        }

        // verificando permissoes
        if(isset($dados['op']))
            $op = $dados['op'];

        unset($objDados->data);
        unset($objDados->status);
        

        if(@$imagem!=null):
            $objDados->imagem = $imagem;
        endif;

       // echo "<pre>"; print_r($objDados); echo "</pre>";

        // salvando informações do model principal
        $this->processando('PUT', $objDados, $this->permissoes, $op);
        $medico = $this->UltimoRegistro();

    }


}
?>