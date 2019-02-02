
<?php
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "80",
	  CURLOPT_URL => "http://listamed.com.br/api/cidades/cadastradas/",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	));

	$response = json_decode(curl_exec($curl));
	$err = curl_error($curl);
	curl_close($curl);

?>
<div class="modal fade" id="listamed-modal-ligar" tabindex="-1" role="dialog" aria-labelledby="listamed-modal-ligar" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h2>Ligar para mim</h2>
				<p>Preencha os campos para que possamos entrar em contato com você.</p>
			</div>
			<div class="modal-body">
				<form method="post" name="contato" id="listamed-modal-ligar--form">
					<fieldset>
						<div class="form-group">
							<label class="label-control">Seu Nome <span class="text-danger">*</span></label>
							<input type="text" name="contato[nome]" class="form-control" placeholder="" required id="listamed-modal-ligar--nome"/>
							<span class="help-block">Este campo é obrigatório, por favor preencha o campo.</span>
						</div>		
						<div class="form-group">
							<label class="label-control">Seu E-mail <span class="text-danger">*</span></label>
							<input type="email" name="contato[email]" placeholder="exemplo@exemplo.com" class="form-control" id="listamed-modal-ligar--email"/>
							<span class="help-block">Este campo é obrigatório, por favor informe o e-mail no formato exemplo@exemplo.com.br</span>
						</div>								
						<div class="row">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label class="control-label">Seu Celular <span class="text-danger">*</span></label>
									<input type="text" name="contato[telefone]" class="form-control" placeholder="(12) 34567-8912" id="listamed-modal-ligar--celular"/>
									<span class="help-block">Este campo é obrigatório, por favor seu telefone no formato (12) 34567-8912.</span>
								</div>									
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="form-group">
									<label class="control-label">Cidade</label>
									<select name="contato[cidade]" class="form-control" id="listamed-modal-ligar--cidade">
										<option placeholder="Cidade" disabled selected>Cidade</option>
										<?php $cidade = ($_SESSION['buscar_cidade']!="") ? $_SESSION['buscar_cidade'] : $cidadeIp ?>
										<?php foreach ($response->data as $k => $v) {  ?>
											<option <?php echo ($v->cidade == $cidade) ? "SELECTED" : "" ;?><?php echo ($cidade == $v->id) ? "SELECTED" : "" ;?>  value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
										<?php } ?>
									</select>
								</div>									
							</div>
						</div>
						<p class="small text-danger"><strong>Obs*: </strong>Campos Obrigatórios (*)</p>
					</fieldset>
				</form>			
			</div>
			<div class="modal-footer">		
				<button type="button" class="btn btn-block btn-theme-blue" id="listamed-modal-ligar--submit">Enviar</button>
				<button type="button" class="btn btn-block btn-link" data-dismiss="modal" aria-label="Close">Fechar</button>
			</div>
		</div>		
	</div>
</div>
<?php
	//enviar
	//Obs: colocar o email_contato configurado com o email fixo para receber estas informações
	  // emails para quem será enviado o formulário

	if (isset($_REQUEST['contato']))
	{
		$emailListamed = "";

		$nome = $_REQUEST['contato']['nome'];
		$cidade = $_REQUEST['contato']['cidade'];
		$telefone = $_REQUEST['contato']['telefone'];
		$email = $_REQUEST['contato']['email'];

		// incluindo classes do sendgrid
		require 'sendgrid/vendor/autoload.php';
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);
	
		// preparando e-mail para envio
		$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
//		$from = new SendGrid\Email(null, "transacional@listamed.com.br");
		$subject = "Contato do site - Ligar para mim";
		$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");
		//$to = new SendGrid\Email(null, $emailListamed);
	
		// formatando informações para envio
		$textoEmail = "<strong>Nome: </strong>".$nome."<br/>";
		$textoEmail.= "<strong>Cidade: </strong>".$cidade."<br/>";
		$textoEmail.= "<strong>E-mail: </strong>".$email."<br/>";
		$textoEmail.= "<strong>Telefone: </strong>".$telefone."<br/>";
	
		// enviando o email
		$content = new SendGrid\Content("text/html", $textoEmail);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$response = $sg->client->mail()->send()->post($mail);


		$from2 = new SendGrid\Email(null, "transacional@listamed.com.br");
		$subject2 = "Sua solicitação foi enviada com sucesso";
		//$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");
		$to2 = new SendGrid\Email(null, $email);

		// formatando informações para envio
		$textoEmail2 = "Olá ".$nome.",<br/><br/>";
		$textoEmail2.= "Recebemos seu contato na <strong>Listamed</strong>, em breve entraremos em contato pelo telefone ".$telefone."<br/>";
	
		// enviando o email
		$content2 = new SendGrid\Content("text/html", $textoEmail2);
		$mail2 = new SendGrid\Mail($from2, $subject2, $to2, $content2);
		$response = $sg->client->mail()->send()->post($mail2);







	  //$enviaremail = mail($destino, $assunto, $msg, $headers);

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
