<?php

require_once $_SERVER['DOCUMENT_ROOT']."/pagseguro/vendor/autoload.php";
require_once $_SERVER['DOCUMENT_ROOT']."/pagseguro/vendor/config.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");


class PagSeguro 
{

	public static function getCredentials(){
		return \PagSeguro\Configuration\Configure::getAccountCredentials();	
	}

	public static function getSessionCode()
	{
		$sessionCode = \PagSeguro\Services\Session::create( self::getCredentials() );
		return $sessionCode;
	}

	public static function getFormasPagamentos($options)
	{
		return \PagSeguro\Services\Installment::create( self::getCredentials(), $options )->getInstallments();
	}

	public static function efetuarPagamento($sandbox, $dados)
	{

		\PagSeguro\Configuration\Configure::setEnvironment($sandbox);
	    \PagSeguro\Configuration\Configure::setCharset('UTF-8');// UTF-8 or ISO-8859-1
	    \PagSeguro\Configuration\Configure::setAccountCredentials(
            "luisfante@gmail.com",
            "5951F07A0EC541A5AB0301AFEA447BFA"
	    );
            //"9717C1AC90FC453CB383B2717E86BD78"

		\PagSeguro\Configuration\Configure::setLog(true, 'log_pagseguro.log');

	    try {
//			  <plan>3102379E93938A8664C67F8DB50506F3</plan>
	        


        $xml = '
	        <?xml version=&quot;1.0&quot;?>
			<directPreApproval>
			  <plan>C97CC7A4E3E39E1AA4FB0FAC5C9411F4</plan>

			  <reference>REF1234</reference>
			  <sender>
			    <name>'.$dados['comprador_nome'].'</name>
			    <email>'.$dados['comprador_email'].'</email>
			    <ip>1.1.1.1</ip>
			    <hash>'.$dados['cartao_hash'].'</hash>
			    <phone>
			      <areaCode>'.$dados['cartao_ddd'].'</areaCode>
			      <number>'.$dados['cartao_telefone'].'</number>
			    </phone>
			    <address>
			      <street>'.$dados['endereco_endereco'].'</street>
			      <number>'.$dados['endereco_numero'].'</number>
			      <complement> null </complement>
			      <district>'.$dados['endereco_bairro'].'</district>
			      <city>'.$dados['endereco_cidade'].'</city>
			      <state>'.$dados['endereco_estado'].'</state>
			      <country>'.$dados['endereco_pais'].'</country>
			      <postalCode>'.$dados['endereco_cep'].'</postalCode>
			    </address>
			    <documents>
			      <document>
			        <type>CPF</type>
			        <value>'.$dados['cartao_cpf'].'</value>
			      </document>
			    </documents>
			  </sender>
			  <paymentMethod>
			    <type>CREDITCARD</type>
			    <creditCard>
			      <token>'.$dados['cartao_token'].'</token>
			      <holder>
			        <name>'.$dados['comprador_nome'].'</name>
			        <birthDate>20/12/1990</birthDate>
			        <document>
			          <type>CPF</type>
			          <value>'.$dados['cartao_cpf'].'</value>
			        </document>
			        <phone>
			          <areaCode>'.$dados['cartao_ddd'].'</areaCode>
			          <number>'.$dados['cartao_telefone'].'</number>
			        </phone>
			        <address>
			          <street>'.$dados['endereco_endereco'].'</street>
			      	  <number>'.$dados['endereco_numero'].'</number>
			      	  <complement> null </complement>
			      	  <district>'.$dados['endereco_bairro'].'</district>
			      	  <city>'.$dados['endereco_cidade'].'</city>
			      	  <state>'.$dados['endereco_estado'].'</state>
			      	  <country>'.$dados['endereco_pais'].'</country>
			      	  <postalCode>'.$dados['endereco_cep'].'</postalCode>
			        </address>
			      </holder>
			    </creditCard>
			  </paymentMethod>
			</directPreApproval>';

/*
			$dados = array(
				"plan" => "C97CC7A4E3E39E1AA4FB0FAC5C9411F4",
				"reference" => "REF1234",
				"sender" => array(
					"name" => $dados['comprador_nome'],
					"email" => $dados['comprador_email'],
					"hash" => $dados['cartao_hash'],
					"phone" => array(
						"areaCode" => $dados['cartao_ddd'],
						"number" => $dados['cartao_telefone']
					),
					"address" => array(
						"street" => $dados['endereco_endereco'],
						"number" => $dados['endereco_numero'],
						"complement" => "99o andar",
						"district" => $dados['endereco_bairro'],
						"city" => $dados['endereco_cidade'],
						"state" => $dados['endereco_estado'],
						"country" => $dados['endereco_pais'],
						"postalCode" => $dados['endereco_cep']
					),
					"documents" => array(
						array(
							"type" => "CPF",
							"value" => $dados['cartao_cpf']
						)
					)
				),

				"paymentMethod" => array(
					"type" => "CREDITCARD",
					"creditCard" => array(
						"token" => $dados['cartao_token'],
						"holder" => array(
							"name" => $dados['comprador_nome'],
							"birthDate" => "20/12/1990",
							"documents" => array(
								array(
								  "type" => "CPF",
								  "value" => $dados['cartao_cpf']
								)
							),
							"phone" => array(
								"areaCode" => $dados['cartao_ddd'],
								"number" => $dados['cartao_telefone']
							),
							"billingAddress" => array(
								"street" => $dados['endereco_endereco'],
								"number" => $dados['endereco_numero'],
								"complement" => " ",
								"district" => $dados['endereco_bairro'],
								"city" => $dados['endereco_cidade'],
								"state" => $dados['endereco_estado'],
								"country" => $dados['endereco_pais'],
								"postalCode" => $dados['endereco_cep']
							)
						)
					)
				)
			);


/*echo "<pre>"; print_r('-----------------------'); echo "</pre>";
echo "<pre>"; print_r($xml); echo "</pre>";
echo "<pre>"; print_r('-----------------------'); echo "</pre>";*/

//$url = 'http://ws.pagseguro.uol.com.br/v2/pre-approvals/request?email=marcelolm@hotmail.com.br&token=6592BA9FED414F9BBF85203552C2BA58';
//$url = 'https://sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code=3102379E93938A8664C67F8DB50506F3';


  //$url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?email=marcelolm@hotmail.com.br&token=6592BA9FED414F9BBF85203552C2BA58';
  //$url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?email=luisfante@gmail.com&token=9717C1AC90FC453CB383B2717E86BD78'; // production
  //$url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?email=luisfante@gmail.com&token=1AF3C742DAEA49A997F540692D842A39'; //sandbox
  //$url = 'https://ws.sandbox.pagseguro.uol.com.br/pre-approvals?email=luisfante@gmail.com&token=5951F07A0EC541A5AB0301AFEA447BFA'; //sandbox
  $url = 'https://ws.pagseguro.uol.com.br/pre-approvals?email=luisfante@gmail.com&token=5951F07A0EC541A5AB0301AFEA447BFA';


//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request?email=marcelolm@hotmail.com.br&token=6592BA9FED414F9BBF85203552C2BA58';
//$url = 'https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request?code=3102379E93938A8664C67F8DB50506F3';
//$url = 'http://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request.html?code=3102379E93938A8664C67F8DB50506F3';




//$data_json = json_encode($data);

$headers = array('Content-Type: application/json', 'Accept: application/vnd.pagseguro.com.br.v3+json;charset=ISO-8859-1');
//$headers = array('Content-Type: application/xml', 'application/vnd.pagseguro.com.br.v3+json');

/*$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS,$xml);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);
*/

echo "<pre>"; print_r('------------- inicio var: xml -------------'); echo "</pre>";
echo "<pre>"; print_r($xml); echo "</pre>";
echo "<pre>"; print_r('------------- final  var: xml -------------'); echo "</pre>";

$curl = curl_init($url);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, Array(
        'Accept: application/vnd.pagseguro.com.br.v3+xml;charset=ISO-8859-1',
        'Content-Type: application/xml; charset=ISO-8859-1'));
curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
$resposta = curl_exec($curl);

return $resposta;
/*echo "<pre>"; print_r('-----------------------'); echo "</pre>";
echo "<pre>"; print_r($resposta); echo "</pre>";
echo "<pre>"; print_r('-----------------------'); echo "</pre>";

*/










/*
echo "<pre>"; print_r('-----------------------'); echo "</pre>";
echo "<pre>"; print_r($response); echo "</pre>";
echo "<pre>"; print_r('-----------------------'); echo "</pre>";


*/
//exit;

/*



$url = "https://ws.sandbox.pagseguro.uol.com.br/v2/pre-approvals/request?email=marcelolm@hotmail.com.br&token=6592BA9FED414F9BBF85203552C2BA58";

$curl = curl_init($url); 
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); 
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($curl, CURLOPT_HTTPHEADER, Array('Content-Type: application/xml; charset=ISO-8859-1')); 
curl_setopt($curl, CURLOPT_POSTFIELDS, $dados);

$retorno = curl_exec($curl); 
curl_close($curl); 


echo "<pre>"; print_r('-----------------------'); echo "</pre>";
echo "<pre>"; print_r($retorno); echo "</pre>";
echo "<pre>"; print_r('-----------------------'); echo "</pre>";


exit;












	        $creditCard = new \PagSeguro\Domains\Requests\DirectPayment\CreditCard();
	        
	        //$creditCard->setPreApproval('D2202A86-2E2E-C299-9432-0F8E439C6452');
	        $creditCard->setMode('DEFAULT');
	        $creditCard->setCurrency("BRL");      
	        $creditCard->setSender()->setHash($dados['cartao_hash']);
	        $creditCard->setToken($dados['cartao_token']);
	        $creditCard->setReceiverEmail($dados['email_notificacoes']);
	        $creditCard->setReference($dados['pedido_id']);
	        $creditCard->setNotificationUrl($dados['url_retorno']);
	        $creditCard->setSender()->setName($dados['comprador_nome']);
	        $creditCard->setSender()->setDocument()->withParameters('CPF', $dados['comprador_cpf']);
	        $creditCard->setSender()->setPhone()->withParameters($dados['comprador_ddd'], $dados['comprador_telefone']);
	        $creditCard->setSender()->setEmail($dados['comprador_email']);
	        
	        $creditCard->setShipping()->setAddress()->withParameters(
	            $dados['endereco_endereco'],
	            $dados['endereco_numero'],
	            $dados['endereco_bairro'],
	            $dados['endereco_cep'],
	            $dados['endereco_cidade'],
	            $dados['endereco_estado'],
	            $dados['endereco_pais'],
	            ''
	        );
	        $creditCard->setExtraAmount($dados['valor_extra']);

	        $creditCard->setInstallment()->withParameters($dados['parcelas_quantidade'], $dados['valor_total']);
	        $creditCard->setBilling()->setAddress()->withParameters(
	            $dados['cobranca_endereco'],
	            $dados['cobranca_numero'],
	            $dados['cobranca_bairro'],
	            $dados['cobranca_cep'],
	            $dados['cobranca_cidade'],
	            $dados['cobranca_estado'],
	            $dados['cobranca_pais'],
	            ''    
	        );
	        $creditCard->setHolder()->setName($dados['cartao_nome']); // Igual ao cartão de credito
	        $creditCard->setHolder()->setBirthdate($dados['cartao_nascimento']);
	        $creditCard->setHolder()->setPhone()->withParameters($dados['cartao_ddd'], $dados['cartao_telefone']);
	        $creditCard->setHolder()->setDocument()->withParameters('CPF', $dados['cartao_cpf']);
	        
	        $creditCard->addItems()->withParameters(
	            $dados['produto_sequencial'],
	            $dados['produto_descricao'],
	            $dados['produto_quantidade'],
	            $dados['produto_valor']
	        );

echo "<pre>"; print_r('-----------------------'); echo "</pre>";
echo "<pre>"; print_r($creditCard); echo "</pre>";
echo "<pre>"; print_r('-----------------------'); echo "</pre>";

exit;
	        $result = $creditCard->register(\PagSeguro\Configuration\Configure::getAccountCredentials());
	        return $result;	 */
  
        } 
        catch (Exception $e) { 
            echo "</br> <strong>";

            die($e->getMessage());
        }

	}

}
