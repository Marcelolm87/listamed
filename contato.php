<?php require_once("config.php");
	$conteudo =	json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions)));
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Fale Conosco - ListaMED</title>
        <meta title="Fale Conosco - ListaMED">
        <meta description="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="./css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="./images/favicon/favicon-96x96.png">
    </head>
<body>
	<div class="page page-contato" id="listamed-contato">
	    <div class="page-nav page-nav-links-blue" id="listamed-nav">
	    	<div class="container">
        		<div class="row container-fluid">
	        		<div class="pull-left">
	                    <h1 class="logo">
	                        <a href="index.php">
	                        	<img src="./images/logo-internas-top.png" />
	                        </a>
	                    </h1>	        			
	        		</div>	        			
	        		<div class="pull-right text-right">
		            	<div class="nora-menu" id="listamed-menu">
		            		<div class="visible-xs visible-sm hidden-md hidden-lg">
			            		<button type="button" class="nora-menu-btn nora-menu-action" nora-action="open">
			            			<i class="fa fa-bars"></i>
			            		</button>			            			
		            		</div>
		            		<div class="nora-menu-view">
		            			<div class="nora-menu-content">
			            			<div class="visible-xs visible-sm hidden-md hidden-lg">
					            		<button type="button" class="nora-menu-btn nora-menu-action" nora-action="close">
					            			<i class="fa fa-close"></i>
					            		</button>			            			
				            		</div>
				            		<ul class="nora-menu-list list list-items--inline">
				            			<li class="list--item"><a href="/sobre">Sobre a ListaMed</a></li>
				            			<li class="list--item"><a href="/seja" id="seja-header">Seja Lista Med</a></li>
				            			<li class="list--item"><a href="/perguntas-frequentes">Perguntas Frequentes</a></li>
				            			<li class="list--item"><a target="_blank" href="/blog">Blog</a></li>
				            			<li class="list--item"><a href="/contato">Contato</a></li>
				            		</ul>			            				
		            			</div>
		            		</div>
		            	</div>		        			
	        		</div>
        		</div>    		
	    	</div>
	    </div>
	    <div class="page-main">
			<div class="contato container">
				<div class="row">
					<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
						<div class="contato-icons">
							<ul class="list list-items--block">
								<li class="list--item">
									<a href="tel:<?php echo $conteudo->contato_telefone; ?>">
										<img src="./images/phone-contato.png" />
										<span><?php echo $conteudo->contato_telefone; ?></span>
									</a>									
								</li>
								<li class="list--item">
									<a href="mailto:<?php echo $conteudo->contato_email; ?>">
										<img src="./images/email-contato.png" />
										<span><?php echo $conteudo->contato_email; ?></span>
									</a>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<div class="contato-header">
							<h2><?php echo $conteudo->contato_titulo; ?></h2>
							<p><?php echo $conteudo->contato_texto; ?></p>
						</div>
						<form class="contato-form" id="listamed-contato-form" method="post">
							<fieldset>
								<legend class="sr-only">Entre em contato conosco</legend>
								<?php if(@$_GET['centro-medico']=="ok"): ?>
									<input type="hidden" name="centromedico" value="ok" />
								<?php endif; ?>
								<div class="alert alert-success" id="EnvioOk" style="display: none">
									<p>Dados enviados com sucesso !!</p>
								</div>
								<div class="alert alert-danger" id="EnvioError"  style="display: none">
									<p>Por favor, preencha todos os campos !</p>
								</div>
								<div class="row">
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<input id="listamed-contato-form--nome" type="text" class="form-control" name="contato[nome]" placeholder="Nome*"/>
											<span class="help-block">Campo Obrigatório, por favor informe seu nome</span>
										</div>									
									</div>
									<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
										<div class="form-group">
											<input id="listamed-contato-form--sobrenome" type="text" class="form-control" name="contato[sobrenome]"  placeholder="Sobrenome*"/>
											<span class="help-block">Campo Obrigatório, por favor informe seu sobrenome</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-6">
										<div class="form-group">
											<select name="contato[estado]" id="listamed-contato-form--estado" class="form-control" >
												<option value="" disabled selected>Estado</option>
											</select>	
											<span class="help-block">Campo Obrigatório, por favor selecione um estado</span>									
										</div>
									</div>
									<div class="col-xs-6">
										<div class="form-group">
											<select name="contato[cidade]" id="listamed-contato-form--cidade" class="form-control" >
												<option value="" disabled selected>Cidade</option>
											</select>
											<span class="help-block">Campo Obrigatório, por favor selecione uma cidade</span>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="form-group">
											<input id="listamed-contato-form--email" class="form-control" type="email" name="contato[email]" placeholder="E-mail*" />
											<span class="help-block">Campo Obrigatório, por favor digite um e-mail <strong>exemplo@exemplo.com</strong></span>
										</div>									
									</div>
									<div class=" col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="form-group">
											<input id="listamed-contato-form--telefone" class="form-control" type="text" name="contato[telefone]" placeholder="Telefone"/>
											<span class="help-block">Por favor digite um telefone válido <strong>(12) 345678912</strong></span>										
										</div>
									</div>
								</div>
								<div class="form-group">
									<textarea class="form-control" name="contato[mensagem]" id="listamed-contato-form--mensagem"></textarea>
									<span class="help-block">Campo Obrigatório, por favor digite uma mensagem</span>
								</div>
								<div class="contato-buttons">
									<button type="button" class="btn btn-theme-blue" id="listamed-contato-form--submit">Enviar</button>
								</div>
							</fieldset>
						</form>
						<?php
							if( ($_SERVER['HTTP_REFERER']=="https://listamed.com.br/seja")||($_SERVER['HTTP_REFERER']=="https://listamed.com.br/sobre")||($_SERVER['HTTP_REFERER']=="https://listamed.com.br/perguntas-frequentes")):
								$link = '/seja';
							else:
								$link = '/';
							endif;
						?>
						<div class="contato-buttons">
							<a href="<?php echo $link; ?>" class="btn btn-theme-blue--borded">Voltar para a Home</a>
						</div>
					</div>
				</div>
			</div>	    	
	    </div>
		<?php include 'footer-pages.php'; ?>
	</div>
	<script src="/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo $caminho; ?>js/champs.min.js"></script>
    <script src="<?php echo $caminho; ?>js/ouibounce.js"></script>
    <script src="<?php echo $caminho; ?>js/script.js"></script>
    </body>
</html>


<?php
	//enviar

	  // emails para quem será enviado o formulário

	if (isset($_REQUEST['contato'])){

   	  $ip = $_SERVER["REMOTE_ADDR"];
  
	  $nome = $_REQUEST['contato']['nome'];
	  $sobrenome = $_REQUEST['contato']['sobrenome'];
	  $estado = $_REQUEST['contato']['estado'];
	  $cidade = $_REQUEST['contato']['cidade'];
	  $email = $_REQUEST['contato']['email'];
	  $telefone = $_REQUEST['contato']['telefone'];
	  $mensagem = $_REQUEST['contato']['mensagem'];


	  $emailenviar = $email_contato;
	  $destino = $emailenviar;
	  $assunto = "Contato pelo Site";

	  // É necessário indicar que o formato do e-mail é html
	  $headers  = 'MIME-Version: 1.0' . "\r\n";
	  $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	  $headers .= 'From: '.$nome.' <'.$destino.'>'. "\r\n";
	  $headers .= 'Reply-To: <'.$email.'>'. "\r\n";
	  //$headers .= "Bcc: $EmailPadrao\r\n";

	  $emailListamed = "contato@listamed.com.br";

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
		$textoEmail = "<strong>Nome: </strong>".$nome." ".$sobrenome."<br/>";
		$textoEmail.= "<strong>Cidade: </strong>".$cidade."-".$estado."<br/>";
		$textoEmail.= "<strong>E-mail: </strong>".$email."<br/>";
		$textoEmail.= "<strong>Telefone: </strong>".$telefone."<br/>";
		$textoEmail.= "<strong>Mensagem: </strong>".$mensagem."<br/>";

		if(@$_POST['centromedico']!=""):
			$textoEmail.= "<br/><br/><strong>Este contato se originou de um interesse por um CENTRO MÉDICO.<br/>";
		endif;

		// enviando o email
		$content = new SendGrid\Content("text/html", $textoEmail);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$response = $sg->client->mail()->send()->post($mail);

		// preparando e-mail para envio
		$from2 = new SendGrid\Email(null, "confirmacao@listamed.com.br");
//		$from2 = new SendGrid\Email(null, "transacional@listamed.com.br");
		$subject2 = "Seu contato foi enviado com sucesso!";
		//$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");
		$to2 = new SendGrid\Email(null, $email);

		// formatando informações para envio
		$textoEmail2 = "Olá ".$nome." ".$sobrenome.",<br/><br/>";
		$textoEmail2.= "Recebemos seu contato na <strong>Listamed</strong>, em breve entraremos em contato.<br/>";
	
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
