<?php
    require_once "../pagseguro/vendor/autoload.php";

    $pagseguro_email = 'marcelolm@hotmail.com.br';
    $pagseguro_token = 'A12CF8F7DE7B493A927840D93FE0E9F0';

    \PagSeguro\Library::initialize();
    \PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
    \PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

    \PagSeguro\Configuration\Configure::setEnvironment('sandbox');//production or sandbox
    \PagSeguro\Configuration\Configure::setAccountCredentials(
            $pagseguro_email,
            $pagseguro_token
    );
    \PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
    \PagSeguro\Configuration\Configure::setLog(true, 'log_pagseguro.log');
    
    try {
        if (\PagSeguro\Helpers\Xhr::hasPost()) {
            $response = \PagSeguro\Services\Transactions\Notification::check(
                \PagSeguro\Configuration\Configure::getAccountCredentials()
            );
        } else {
            throw new \InvalidArgumentException($_POST);
        }
        
        $pedido_id = $_GET['pedido_id'];
        $pagamento_id_externo = $response->getCode();
        $pagamento_evento = $_POST['notificationType'];

        $status_lista = [
            1=>"Aguardando pagamento", 
            2=>"Pagamento em análise", 
            3=>"Pago", 
            4=>"Pagamento disponível", 
            5=>"Pagamento em disputa", 
            6=>"Pagamento devolvido", 
            7=>"Pagamento cancelado", 
            8=>"Pagamento debitado", 
            9=>"Pagamento em retenção temporária"
            ];

        $status_codigo = $response->getStatus();
        $status_descricao = $status_lista[$status_codigo];

        $pagamento_situacao = $status_codigo.":".$status_descricao;
    
    } 
    catch (Exception $e) {
        echo 'Erro ao inserir retorno do pagamento!';
    }
?>