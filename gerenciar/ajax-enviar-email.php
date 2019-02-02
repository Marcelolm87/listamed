<?php
require_once __DIR__ . '/vendor/autoload.php';

$url = $_POST['conteudo_email'];

$curl = curl_init();
curl_setopt_array($curl, array(
	CURLOPT_RETURNTRANSFER => 1,
	CURLOPT_URL => $url
));

$retorno = curl_exec($curl);
curl_close($curl);

$retornoArray  = json_decode($retorno, true);
$retornoObject = json_decode($retorno);

if(@$retornoArray['error']['code']==401){
	echo "Você não tem permissão para acessar esse conteudo, entre em contato com o administrador.";
	exit;
}

$html = '<h1>Relatório</h1><hr/>	
<table id="dataTable" class="table table-striped table-bordered table-hover">
	<thead> <tr> <th>Categoria</th> <th>Ação</th> <th>Rotulo</th> <th>Total de eventos</th> </tr> </thead>
	<tbody>';
	foreach ($retornoArray['rows'] as $k => $v) : 
	
		$html .= '
			<tr>
				<td>'.$v[0].'</td>
				<td>'.$v[1].'</td>
				<td>'.$v[2].'</td>
				<td>'.$v[3].'</td>
			</tr>
			';
	endforeach;
	$html .= '</tbody></table>';

	$emailListamed = $_POST['email'];

	// incluindo classes do sendgrid
	require '../sendgrid/vendor/autoload.php';
	$apiKey = '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';
	$sg = new \SendGrid($apiKey);

	// preparando e-mail para envio
	$from = new SendGrid\Email(null, "relatorio@listamed.com.br");
	$subject = "Relatório Listamed!";
	//$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");
	$to = new SendGrid\Email(null, $emailListamed);

	// formatando informações para envio
	$textoEmail = $html;

	// enviando o email
	$content = new SendGrid\Content("text/html", $textoEmail);
	$mail = new SendGrid\Mail($from, $subject, $to, $content);
	$response = $sg->client->mail()->send()->post($mail);

?>
