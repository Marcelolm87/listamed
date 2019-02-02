<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class MedicoController extends ControllerAbstract {
    
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


        foreach ($dados[periodo] as $kP => $vP) :
            $periodo .= $kP." ";  
        endforeach;
        $periodo = str_replace(" ", ",", trim($periodo));
        $dados['periodo'] = $periodo;

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

        // inserindo model relation
        require_once("model/endereco.php");
        // iniciando o model
        $enderecoModel = new EnderecoModel();
        
        // buscando os campos
        if(@$objDados->data->tb_endereco_id > 0):
            $objDadosEndereco = $enderecoModel->BuscarPorCOD($objDados->data->tb_endereco_id);
        else:
            $objDadosEndereco = $enderecoModel->getCampos();
        endif;
        if (property_exists($objDadosEndereco, 'data')){
            // populando os campos
            foreach ($objDadosEndereco->data as $key => $value) {
                $objDadosEndereco->$key = (isset($dados['endereco'][$key])) ? $dados['endereco'][$key] : null ;
            }
        }else{
            // populando os campos
            foreach ($objDadosEndereco as $key => $value) {
                $objDadosEndereco->$key = (isset($dados['endereco'][$key])) ? $dados['endereco'][$key] : null ;
            }
        }
        // verificando se é insert ou update
        if (property_exists($objDados, 'data')){
            if($objDados->data->tb_endereco_id>0):
                $objDadosEndereco->id = $objDados->data->tb_endereco_id;
            endif;
        }else{
            if($objDados->tb_endereco_id>0):
                $objDadosEndereco->id = $objDados->data->tb_endereco_id;
            endif;
        }
        $objDadosEndereco->tipo = 'm';
        unset($objDadosEndereco->status);
        unset($objDadosEndereco->data);

        // salvando as informações
        $retornoEndereco = $enderecoModel->processando($_SERVER['REQUEST_METHOD'],$objDadosEndereco,$this->permissoes,$op);
        
        // ligando a informações relation ao model principal
        if($_SERVER['REQUEST_METHOD']=="POST"):
            if($retornoEndereco==true):
        
                if($objDadosEndereco->id < 1){
                    $dadosEndereco = $enderecoModel->UltimoRegistro();
                    $objDados->tb_endereco_id = $dadosEndereco->data->id;
                }else{
                    $objDados->tb_endereco_id = $objDadosEndereco->id;
                }
            endif;
        endif;

        // verificando permissoes
        if(isset($dados['op']))
            $op = $dados['op'];

        unset($objDados->data);
        
        if(@$imagem!=null):
            $objDados->imagem = $imagem;
        endif;

        // salvando informações do model principal
        $this->processando($_SERVER['REQUEST_METHOD'], $objDados, $this->permissoes, $op);
        $medico = $this->UltimoRegistro();

        /*********************************************
        *** INSERIR CONVENIOS
        **********************************************/
/*        require_once('model/convenio.php');
        $convenioModel = new ConvenioModel();

        $sql = "DELETE FROM tb_medico_convenio WHERE tb_medico_id = :id";
        $op = Conexao::getInstance()->prepare($sql);
        $op->bindValue(":id", $medico['id']);
        $op->execute();

        if(isset($dados['convenio'])):
            foreach ($dados['convenio']['id'] as $ks => $vs) :
                $convenio = $convenioModel->BuscarPorCOD($vs,false);
                if($convenio->id > 0):
                    $retorno = $this->saveMedicoConvenio($convenio->id, $medico['id']);
                endif;
            endforeach;
        endif;*/

        /*********************************************
        *** INSERIR CONSULTÓRIOS
        **********************************************/
/*        require_once('model/consultorio.php');
        $consultorioModel = new ConsultorioModel();

        $sql = "DELETE FROM tb_consultorio_medico WHERE tb_medico_id = :id";
        $op = Conexao::getInstance()->prepare($sql);
        $op->bindValue(":id", $medico['id']);
        $op->execute();

        if(isset($dados['consultorio'])):
            foreach ($dados['consultorio']['id'] as $ks => $vs) :
                $consultorio = $consultorioModel->BuscarPorCOD($vs,false);
                if($consultorio->id > 0):
                    $retorno = $this->saveMedicoConsultorio($consultorio->id, $medico['id']);
                endif;
            endforeach;
        endif;*/

        /*********************************************
        *** INSERIR ESPECIALIDADES
        **********************************************/
/*        require_once('model/especialidade.php');
        $especialidadeModel = new EspecialidadeModel();

        $sql = "DELETE FROM tb_medico_especialidade WHERE tb_medico_id = :id";
        $op = Conexao::getInstance()->prepare($sql);
        $op->bindValue(":id", $medico['id']);
        $op->execute();

        if(isset($dados['especialidade'])):
            foreach ($dados['especialidade']['id'] as $ks => $vs) :
                $especialidade = $especialidadeModel->BuscarPorCOD($vs,false);
                if($especialidade->id > 0):
                    $retorno = $this->saveMedicoEspecialidade($especialidade->id, $medico['id']);
                endif;
            endforeach;
        endif;*/

        /*********************************************
        *** INSERIR TELEFONE
        **********************************************/
        //require_once('model/telefone.php');
        //$telefoneModel = new TelefoneModel();
//
        //$sql = "DELETE FROM tb_telefone_medico WHERE tb_medico_id = :id";
        //$op = Conexao::getInstance()->prepare($sql);
        //$op->bindValue(":id", $medico->data->id);
        //$op->execute();
//
        //if(isset($dados->telefone)):
        //    foreach ($dados['telefone']['id'] as $ks => $vs) :
        //        $telefone = $telefoneModel->BuscarPorCOD($vs,false);
        //        if($telefone->id > 0):
        //            $retorno = $this->saveMedicoTelefone($telefone->id, $medico['id']);
        //        endif;
        //    endforeach;
        //endif;

        /*********************************************
        *** INSERIR USUARIO E SENHA
        **********************************************/
/*        if($_SERVER['REQUEST_METHOD']=="POST"):
            //inserir usuario
            require_once("model/usuario.php");
            $usuarioModel = new UsuarioModel();
            
            $_POST['login'] = $_SERVER['PHP_AUTH_USER'];
            $_POST['pass'] = $_SERVER['PHP_AUTH_PW'];
            $_POST['tb_medico_id'] = $medico['id'];
        
            $valor = $usuarioModel->save();    
        endif;*/

        //$medico = $this->retornoFull($medico);

    }

    public static function retornoFull($medico)
    {

        // buscar todas experiencias
        require_once "model/experiencia.php";
        $experiencia = ExperienciaModel::BuscarPorCODMedico($medico->data->id);
        //$medico->experiencia = ExperienciaModel::BuscarPorCODMedico($medico->id);

        // buscar todos telefones
        //require_once "model/telefone.php";
        //$medico->telefone = TelefoneModel::BuscarPorCODMedico($medico->data->id);

        // buscar todas redes sociais
        //require_once "model/social.php";
        //$medico->social = SocialModel::BuscarPorCODMedico($medico->data->id);

        // buscar todas especialidades
        require_once "model/especialidade.php";
        $medico->especialidade = EspecialidadeModel::BuscarPorCODMedico($medico->data->id);

        // buscar todos convenio
        require_once "model/convenio.php";
        $medico->convenio = ConvenioModel::BuscarPorCODMedico($medico->data->id);
        
        // buscar todos consultorios
        require_once "model/consultorio.php";
        $medico->consultorio = ConsultorioModel::BuscarPorCODMedico($medico->data->id);

        return $medico;

    }


    // function para salvar relação de medico e convenio
    public function saveMedicoConvenio($convenio, $medico)
    {
        try {
            $sql = "INSERT INTO tb_medico_convenio ( tb_medico_id, tb_convenio_id ) VALUES ( $medico, $convenio )";
       
            $op = Conexao::getInstance()->prepare($sql);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
    
    // function para salvar relação de medico e consultorio
    public static function saveMedicoConsultorio($consultorio, $medico)
    {
        try {

            $sql = "SELECT * FROM tb_consultorio_medico WHERE tb_consultorio_medico.tb_medico_id =  $medico and tb_consultorio_medico.tb_consultorio_id = $consultorio";
            $op = Conexao::getInstance()->prepare($sql);
            $op->execute();
            $dados = $op->fetchall(PDO::FETCH_ASSOC);

            if(@$dados['0']['id']<1){
                $sql = "INSERT INTO tb_consultorio_medico ( tb_medico_id, tb_consultorio_id ) VALUES ( $medico, $consultorio )";
                $op = Conexao::getInstance()->prepare($sql);
                return $op->execute();
            }else{
                return (object) array(
                    "status" => 200,
                    "msg" => "Consultório já adicionado"
                );
            }           
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
        
    // function para salvar relação de medico e especialidade
    public function saveMedicoEspecialidade($especialidade, $medico)
    {
        try {
            $sql = "INSERT INTO tb_medico_especialidade ( tb_medico_id, tb_especialidade_id ) VALUES ( $medico, $especialidade )";
            $op = Conexao::getInstance()->prepare($sql);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
    // function para salvar relação de medico e especialidade
    public function deleteMedicoConvenio($convenio, $medico)
    {
        try {
            $sql = "DELETE FROM tb_medico_convenio WHERE tb_medico_id = :id and tb_convenio_id = :convenio";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $medico);
            $op->bindValue(":convenio", $convenio);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
    // function para salvar relação de medico e especialidade
    public function deleteMedicoConsultorio($consultorio, $medico)
    {
        try {
            $sql = "DELETE FROM tb_consultorio_medico WHERE tb_medico_id = :id and tb_consultorio_id = :consultorio";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $medico);
            $op->bindValue(":consultorio", $consultorio);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
    // function para salvar relação de medico e especialidade
    public function deleteMedicoExperiencia($experiencia, $medico)
    {
        try {
            $sql = "DELETE FROM tb_experiencia WHERE tb_medico_id = :id and id = :experiencia";
            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $medico);
            $op->bindValue(":experiencia", $experiencia);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }

    // function para salvar relação de medico e especialidade
    public function deleteMedicoEspecialidade($especialidade, $medico)
    {
        try {
            $sql = "DELETE FROM tb_medico_especialidade WHERE tb_medico_id = :id and tb_especialidade_id = :especialidade";
           echo $sql;

            $op = Conexao::getInstance()->prepare($sql);
            $op->bindValue(":id", $medico);
            $op->bindValue(":especialidade", $especialidade);
            $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }

    // function para salvar relação de medico e telefone
    public function saveMedicoTelefone($telefone, $medico)
    {
        try {
            $sql = "INSERT INTO tb_telefone_medico ( tb_medico_id, tb_telefone_id ) VALUES ( $medico, $telefone )";
            $op = Conexao::getInstance()->prepare($sql);
            return $op->execute();
        }
        catch (Exception $e) {
            print "Ocorreu um erro ao tentar executar esta ação, foi gerado um LOG do mesmo, tente novamente mais tarde.";
            print_r ($e);
        }
    }
    

}
?>