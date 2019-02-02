<?php
	//enviar

	  // emails para quem será enviado o formulário

	if (isset($_REQUEST['txtNome'])){

		$ip = $_SERVER["REMOTE_ADDR"];

		$nome = $_REQUEST['txtNome'];
		$email = $_REQUEST['txtEmail'];
		$telefone = $_REQUEST['txtTel'];
		$endereco = $_REQUEST['txtEndereco'];
		$numero = $_REQUEST['txtNumero'];
		$bairro = $_REQUEST['txtBairro'];
		$cep = $_REQUEST['txtCEP'];
		$estado = $_REQUEST['txtEstado'];
		$cidade = $_REQUEST['txtCidade'];

		$emailenviar = $email_contato;
		$destino = $emailenviar;
		$assunto = "Cadastro no site";

		// É necessário indicar que o formato do e-mail é html
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$headers .= 'From: '.$nome.' <'.$destino.'>'. "\r\n";
		$headers .= 'Reply-To: <'.$email.'>'. "\r\n";
		//$headers .= "Bcc: $EmailPadrao\r\n";

		$emailListamed = "marcelolauton@wdezoito.com.br";

		// incluindo classes do sendgrid
		require 'sendgrid/vendor/autoload.php';
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		// preparando e-mail para envio
//		$from = new SendGrid\Email(null, "transacional@listamed.com.br");
		$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
		$subject = "Contato do site!";
		//$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");
		$to = new SendGrid\Email(null, $emailListamed);

		// formatando informações para envio
		$textoEmail = "<strong>Nome: </strong>".$nome."<br/>";
		$textoEmail.= "<strong>E-mail: </strong>".$email."<br/>";
		$textoEmail.= "<strong>Telefone: </strong>".$telefone."<br/>";
		$textoEmail.= "<strong>Endereço: </strong>".$endereco.", ".$numero." ".$bairro." CEP: ".$cep." ".$cidade."-".$estado." <br/>";

		// enviando o email
		$content = new SendGrid\Content("text/html", $textoEmail);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$response = $sg->client->mail()->send()->post($mail);

		if($response){
			?>
			  <script type="text/javascript">
			  $(document).ready(function(){
		  	  	document.getElementById("EnvioOk").style.display = "block";
			  		/*simpleAlert({text: 'E-mail enviado com sucesso.', theme: 'success', temporary: true});*/
			  })
			  </script>
		<?php
		}
	else {
	?>
		<script type="text/javascript">
	  	  $(document).ready(function(){
	  	  		document.getElementById("EnvioError").style.display = "block";
	  	  		/*simpleAlert({text: 'Deu ruim.', theme: 'error', temporary: true});*/
	  	  })
	  	  </script>
	<?php
	  	$mgm = "ERRO AO ENVIAR E-MAIL!";
	  }
	}
?>
