<?php session_start(); header('Content-Type: text/html; charset=utf-8'); session_start(); ?>
<?php
	require_once("config.php");

	function removeAcentos( $string ) {

	    $string = strtolower($string);
	    
	    $string = str_replace('á', 'a', $string);
	    $string = str_replace('à', 'a', $string);
	    $string = str_replace('â', 'a', $string);
	    $string = str_replace('ã', 'a', $string);
	    $string = str_replace('ä', 'a', $string);

	    $string = str_replace('é', 'e', $string);
	    $string = str_replace('è', 'e', $string);
	    $string = str_replace('ê', 'e', $string);

	    $string = str_replace('í', 'i', $string);
	    $string = str_replace('ì', 'i', $string);
	    
	    $string = str_replace('ó', 'o', $string);
	    $string = str_replace('ò', 'o', $string);
	    $string = str_replace('ô', 'o', $string);
	    $string = str_replace('õ', 'o', $string);
	    $string = str_replace('ö', 'o', $string);

	    $string = str_replace('ú', 'u', $string);
	    $string = str_replace('ù', 'u', $string);
	    $string = str_replace('ü', 'u', $string);

	    $string = str_replace('ç', 'c', $string);

	    return ($string);
	}

	function slug($nome){
	    $aux = removeAcentos($nome);
	    $aux = strtolower( strip_tags( preg_replace( array( '/[`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/' ), array( null, '-', '-' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', $aux ) ) ) );
	    return str_replace(".", "", $aux);
	}

	function cUrlFunction($url, $data){
		$ch      = curl_init();
		$timeout = 10; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$request_headers = array();
		$request_headers[] = "Authorization: Basic VEVNTk9USUNJQTppZW5rbU50Rw=="; //USUÁRIO E SENHA CODIFICADO EM BASE64
		$request_headers[] = "Content-Type: application/json" ;
		$request_headers[] = "Accept: application/json";
	            
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
		curl_setopt($ch, CURLOPT_POST, 1);
		
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
		
		$txt     = curl_exec($ch);
		curl_close($ch);
		return $txt;
	}


	if($_GET['action']=="edit"):
		$action = true;
	endif;

	// pegando o id do médico da url
	$auxID = $_SERVER['REDIRECT_URL'];
	$auxID = explode('/', $auxID);
	//$id = $auxID['2'];
	//$id = $auxID['3'];
	$id = $_GET['id'];

	// buscando informações do médico
	/*	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "443",
	  CURLOPT_URL => "https://listamed.com.br/api/medico/".$id."/full",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_SSL_VERIFYPEER => false,
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	));*/

	$response =	json_decode(file_get_contents("https://listamed.com.br/api/medico/".$id."/full", false, stream_context_create($arrContextOptions)));

	/*
	$response = json_decode(curl_exec($curl));
	$err = curl_error($curl);
	curl_close($curl);*/

  	// preparando o retorno
    $info = $response->data;
    foreach ($info as $k => $inf) {
	    $id = $inf->id;
	    $nome = $inf->nome;
	    $cidade = $inf->cidade;
	    $estado = $inf->estado;
	    $texto = $inf->texto;
	    $crm = $inf->crm;
	    $especialidade_text = $inf->especialidade_text;
	    $email = $inf->email;
	    $telefone = $inf->telefone;
	    $whatsapp = $inf->whatsapp;
	    $site = $inf->site;
	    $endereco = $inf->endereco;
	    $numero = $inf->numero;
	    $bairro = $inf->bairro;
	    $cep = $inf->cep;
	    $periodo = $inf->periodo;
	    $agenda_email = $inf->agenda_email;
	    $agenda_telefone = $inf->agenda_telefone;
	    $desconto = $inf->desconto;
	    $link_artigo = $inf->link_artigo;

	    $caminhoImagem = '/gerenciar/upload/profissionais/'.$inf->imagem;
	    $imagem = ($inf->imagem!="") ? 'https://listamed.com.br'.$caminhoImagem : 'https://listamed.com.br/medico.jpg';
	    
	    $convenios = $inf->convenio;
	    $especialidade = "";
	    
	    $facebook = $inf->facebook;
	    $instagram = $inf->instagram;
	    $twitter = $inf->twitter;

	    foreach ($inf->especialidade as $ke => $ve) {
	        $especialidade = ($especialidade == "") ? $especialidade = $ve : $especialidade .= " | ".$ve; 
	        $especialidade_full[] = $ve; 
	    }
	    foreach ($inf->consultorio as $ke => $ve) {
	        $consultorio[$ke] = $ve;
	    }
	    foreach ($inf->experiencia as $ke => $ve) {
	        $experiencia[$ke]['nome'] = $ve->nome;
	        $experiencia[$ke]['desc'] = $ve->desc;
	        $experiencia[$ke]['imagem'] = $ve->imagem;
	        $experiencia[$ke]['datainicio'] = $ve->datainicio;
	        $experiencia[$ke]['datafim'] = $ve->datafim;
	        $experiencia[$ke]['local'] = $ve->local;
	        $experiencia[$ke]['orientador'] = $ve->orientador;
	        $experiencia[$ke]['titulo'] = $ve->titulo;
	    }

	    if($telefone!="")
	        $telefone2 = substr($telefone, 0, 5).' <span class="medico-info--contact">...Ver Telefone</span>';
	    if($whatsapp!="")
	        $whatsapp2 = substr($whatsapp, 0, 5).' <span class="medico-info--contact">...Ver Whatsapp</span>';

	    if($site!="")
	        $site2 = substr($site, 0, 5)."...Ver Site";

    }

    // se foi enviado formulario de retorno
    if(isset($_POST['agendamento'])):

    	if($_SESSION['agendamento']!= $id):



    		$_SESSION['agendamento'] = $id;
			if($agenda_email!=""):
				$emails = explode(',', trim($agenda_email));
			else:
				$emails[0] = "marcelolauton@wdezoito.com.br";
			endif;

	    	// incluindo classes do sendgrid
			require 'sendgrid/vendor/autoload.php';
			$apiKey = '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';
			$sg = new \SendGrid($apiKey);
			
			foreach ($emails as $kMail => $vMail) :
		
				// preparando e-mail para envio
				$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
				//	$from = new SendGrid\Email(null, "transacional@listamed.com.br");
				$subject = "Agendamento!";
				$to = new SendGrid\Email(null, $vMail);

				$convenio = ($_POST['agendamento']['convenio']=="") ? $_POST['agendamento']['convenio2'] : $_POST['agendamento']['convenio'];
				$data_aux = explode('/',$_POST['agendamento']['data']);
				$data = $data_aux[1].'/'.$data_aux[0].'/'.$data_aux[2];


				$textoEmail = "<strong>Paciente: </strong>".$_POST['agendamento']['nome']."<br/>";
				$textoEmail.= "<strong>Email: </strong>".$_POST['agendamento']['email']."<br/>";
				$textoEmail.= "<strong>Telefone: </strong>".$_POST['agendamento']['telefone']."<br/>";
				$textoEmail.= "<strong>Convenio: </strong>".$_POST['agendamento']['convenio']."<br/>";
				$textoEmail.= "<strong>Data: </strong>".$data."<br/>";
				$textoEmail.= "<strong>Horario: </strong>".$_POST['agendamento']['horario']."<br/>";

				// enviando o email
				$content = new SendGrid\Content("text/html", $textoEmail);
				$mail = new SendGrid\Mail($from, $subject, $to, $content);
				$response = $sg->client->mail()->send()->post($mail);
				$enviado = 2;

			endforeach;

			// ENVIANDO EMAIL PARA O CLIENTE
				$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
				//	$from = new SendGrid\Email(null, "transacional@listamed.com.br");
				$subject = "Agendamento!";
				$to = new SendGrid\Email(null, $_POST['agendamento']['email']);

				$convenio = ($_POST['agendamento']['convenio']=="") ? $_POST['agendamento']['convenio2'] : $_POST['agendamento']['convenio'];
				$data_aux = explode('/',$_POST['agendamento']['data']);
				$data = $data_aux[1].'/'.$data_aux[0].'/'.$data_aux[2];


				$textoEmail = "Sua solicitação foi enviada com sucesso, aguarde o nosso contato para confirmação. ListaMED ";

				// enviando o email
				$content = new SendGrid\Content("text/html", $textoEmail);
				$mail = new SendGrid\Mail($from, $subject, $to, $content);
				$response = $sg->client->mail()->send()->post($mail);



			$sg = new \SendGrid($apiKey);
			// preparando e-mail para envio
			$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
			//	$from = new SendGrid\Email(null, "transacional@listamed.com.br");
			$subject = "Agendamento!";
			$to = new SendGrid\Email(null, $_POST['agendamento']['email']);

			$textoEmail =  $sms->sms_cliente;

			// enviando o email
			$content = new SendGrid\Content("text/html", $textoEmail);
			$mail = new SendGrid\Mail($from, $subject, $to, $content);
			$response = $sg->client->mail()->send()->post($mail);

			// get sms text
			$url= 'https://listamed.com.br/api/page';
			$arrContextOptions=array(
			      "ssl"=>array(
			            "verify_peer"=>false,
			            "verify_peer_name"=>false,
			        ),
			    ); 
			$sms =	json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)));

			// enviando sms para o cliente
			$telefone = "+55".preg_replace("/[^0-9]/", "", $_POST['agendamento']['telefone']);

			$data = json_encode(array(
	        	'from' => 'ListaMED',
	        	'to' => $telefone,
	        	'text' => $sms->sms_cliente
	        ));
	        $url   = "http://api.allcancesms.com.br/sms/1/text/single";
			$res   =  cUrlFunction($url, $data);
			$resJson = json_decode($res, false);

			// enviando sms para o profissional
			if($agenda_telefone!=""):
				$telefones = explode(',', trim($agenda_telefone));

				if(is_array($telefones)):
					foreach ($telefones as $kTel => $vTel) :
						$telefone = "+55".preg_replace("/[^0-9]/", "", $vTel);;

						$data = json_encode(array(
				        	'from' => 'ListaMED',
				        	'to' => $telefone,
				        	'text' => $sms->sms_profissional
				        ));
				        $url   = "http://api.allcancesms.com.br/sms/1/text/single";
						$res   =  cUrlFunction($url, $data);
						$resJson = json_decode($res, false);
					endforeach;
				endif;
			endif;
    	endif;
    endif;

	$periodo = explode(',', $periodo);
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>ListaMED</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo $caminho; ?>css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $caminho; ?>images/favicon/favicon-96x96.png">
    
        <script>
          (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
          (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
          m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
          })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

          ga('create', 'UA-93204909-1', 'auto');
          ga('send', 'pageview');
        </script>
    </head>
<body>
	<div class="page page-perfil" id="listamed-perfil">
        <div class="page-nav" id="listamed-nav">
            <div class="container">
                <div class="row container">
                    <div class="pull-left">
                        <h1 class="logo">
                            <a href="<?php echo $caminho; ?>">
                                <img src="<?php echo $caminho; ?>/images/logo-internas-top.png" />
                            </a>
                        </h1>
                    </div>
                    <div class="pull-right">
                        <div class="page-search">
                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                <button class="nora-toggle page-search-buttons--openSearch" nora-target="listamed-medicos-search"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="page-search-container" id="listamed-medicos-search">
                                <form  id="formBuscar" action="medicos.php" method="get">
                                    <fieldset>
                                        <legend class="sr-only">Busque por médicos</legend>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label class="sr-only">Busca</label>
                                                <?php if($_GET['buscar']!=""): $_SESSION['buscar'] = $_GET['buscar']; ?>
                                                    <input class="form-control" id="listamed-medicos-search--busca" type="text" value="<?php echo str_replace('-', ' ', $_GET['buscar']); ?>" name="buscar" autocomplete="off" placeholder="Busque por médico, clínica ou especialidade">
                                                <?php else: ?>
                                                    <input class="form-control" id="listamed-medicos-search--busca" type="text" value="<?php echo str_replace('-', ' ', $_SESSION['buscar']); ?>" name="buscar" autocomplete="off">
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    $cidade = ($_SESSION['buscar_cidade']!="") ? $_SESSION['buscar_cidade'] : $_GET['cidade'];
                                                    $response = json_decode(file_get_contents('http://listamed.com.br/api/cidades/cadastradas/', false, stream_context_create($arrContextOptions)));
                                                ?>
                                                <label class="sr-only">Cidade</label>
                                                <select id="listamed-medicos-search--cidade" name="cidade" class="form-control">
                                                    <option placeholder="Cidade" disabled="" selected="">Cidade</option>
                                                    <?php foreach ($response->data as $k => $v) {  ?>
                                                        <option <?php if($cidade==$v->id) echo "SELECTED"; ?> value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <button id="listamed-medicos-search--submit" type="button" class="btn btn-theme-blue">Buscar</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-main">
			<section class="container">  
				<div class="medico">
					<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
							<div class="medico-perfil">
								<div class="medico-perfil-section medico-perfil-header">
									<div class="row">
										<div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
											<div class="medico-foto">
												<span><img src="<?php echo $imagem; ?>"/></span>
											</div>
										</div>
										<div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
											<h2><?php echo $nome ?></h2>
											<p>Número de identificação profissional:<span> CRM <?php echo $crm; ?></span></p>
											<div class="medico-especialidades">
												<h3><?php echo $especialidade; ?></h3>
												<p>Especialista em: <?php echo $especialidade_text; ?></p>
											</div>
											<button type="button" data-toggle="modal" data-target="#listamed-modals-medicos-convenios" class="btn btn-theme-blue">Convênios</button>
										</div>
									</div>
								</div>
								<div class="medico-perfil-section medico-info">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="medico-info-contato">
												<div class="medico-info--item medico-info-contato--telefones">
											        <h3><i class="fa fa-phone"></i> Telefone(s):</h3>
											        <ul class="list list-items--block">
											        	<li class="list--item">
															<a style="cursor: pointer;" id="showTelefone" onclick="showTelefone('<?php echo $telefone; ?>', '<?php echo $id; ?> - <?php echo $nome; ?>' )" ><?php echo $telefone2; ?></a>													        		
											        	</li>
											        	<li class="list--item">
															<a style="cursor: pointer;" id="showTelefone2" onclick="showTelefone2('<?php echo $whatsapp; ?>', '<?php echo $id; ?> - <?php echo $nome; ?>' )" ><?php echo $whatsapp2; ?></a>													        		
											        	</li>
											        </ul>														
												</div>
												<div class="medico-info--item medico-info-contato--social">
													<ul class="list list-items--inline">
														<?php if($facebook!=""): ?>
															<li class="list--item">
																<a class="linkSocial" href="http://facebook.com/<?php echo $facebook; ?>" target="_blank">
																	<i class="fa fa-facebook icon-social" aria-hidden="true"></i>
																</a>
															</li>
														<?php endif; ?>
														<?php if($instagram!=""): ?>
															<li class="list--item">
																<a class="linkSocial" href="http://instagram.com/<?php echo $instagram; ?>" target="_blank">
																	<i class="fa fa-instagram icon-social" aria-hidden="true"></i>
																</a>
															</li>
														<?php endif; ?>
														<?php if($twitter!=""): ?>
															<li class="list--item">
														    	<a class="linkSocial" href="http://twitter.com/<?php echo $twitter; ?>" target="_blank">
														    		<i class="fa fa-twitter icon-social" aria-hidden="true"></i>
														    	</a>
														    </li>
														<?php endif; ?>													
													</ul>
												</div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="medico-info--item medico-info-endereco">
												<h3><i class="fa fa-flag"></i> Endereço:</h3>
												<p>
													<?php echo $endereco; ?>, <?php echo $numero; ?><br/>
													<?php echo $bairro; ?> - <?php echo $cidade; ?> / <?php echo $estado; ?><br/>
													CEP: <?php echo $cep; ?>
												</p>												
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="medico-info--item medico-info-website">
												<h3><i class="fa fa-globe"></i> Site:</h3>
												<a onclick="ga('send', 'event', 'profissional', 'site', '<?php echo $id; ?> - <?php echo $nome; ?>', {'nonInteraction': 0} );" href="http://<?php echo $site; ?>" target="_blank"><?php echo $site; ?></a>							
											</div>
											<div class="medico-info--item medico-info-email">
											    <h3><i class="fa fa-envelope"></i> E-mail:</h3>
												<a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
											</div>
											<?php if($link_artigo!=""): ?>
											    <div class="medico-info--item medico-info-artigos">
											    	<a target="_blank" style="text-decoration: none; font-weight: 400; position: relative; top: 5px; color: #858585;" href="<?php echo $link_artigo; ?>" >
											    		<i class="fa fa-file-text-o"></i> Ver artigos
											    	</a>
												</div>
											<?php endif; ?>
										</div>
									</div>									
								</div>
								<div class="medico-perfil-section medico-agenda">
									<div class="row">
										<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6">
											<h3 class="medico-perfil-section--title">Pré Agendamento de Consulta</h3>
											<?php if($_SESSION['agendamento']!=$id): ?>
												<p>Escolha a data e preencha os campos</p>
											<?php endif; ?>
										</div>
										<div class="col-lg-6 col-md-6 col-xs-12 col-sm-6" >
											<?php if($_SESSION['agendamento']==$id): ?>
												<div class="alert alert-success">
													<p>
														Sua solicitação foi enviada com sucesso, aguarde o nosso contato para confirmação.
													</p>
												</div>
											<?php else: ?>
												<?php if($desconto!=""): ?>
													<div class="row container-fluid">
														<input type="checkbox" id="campoDesconto" name="desconto" style="width: 15px; float: left; margin: -11px 4px;" > Agendar sua consulta com <label class="descontoLabel"> <?php echo $desconto; ?></label> de desconto!			
														<style type="text/css">
															.descontoLabel{
																padding: 5px;
																background-color: #f88d0d;
																color: #FFF;
																border-radius: 4px;
															}
														</style>														
													</div>
												<?php endif; ?>
												<form action="" method="post" id="formAgendamento" class="medico-agenda-form">
													<fieldset>
														<legend class="sr-only">Pré Agendamento de Consulta</legend>
														<div class="row">
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="sr-only">Data</label>
																	<input type="text" id="datapicker" name="agendamento[data]" class="form-control" placeholder="Data">	
																	<span class="help-block">Campo Obrigatório, por favor preencha.</span>													
																</div>																
															</div>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="sr-only">Convênio</label>
									    							<select class="form-control" id="selectConvenio" name="agendamento[convenio]">
									    								<option value="" disabled selected>Convênio</option>
									    								<option value="particular" >Particular</option>
									    								<?php foreach ($convenios as $kConv => $vConv) : ?>
									    									<option value="<?php echo $vConv; ?>"> <?php echo $vConv; ?> </option>
									    								<?php endforeach; ?>
									    							</select>
									    							<select class="form-control" id="selectConvenio2" name="agendamento[convenio2]" style="display: none;">
									    								<option value="particular" >Particular</option>
									    							</select>
									    							<span class="help-block">Campo Obrigatório, por favor selecione um convênio.</span>		
																</div>																
															</div>
														</div>
														<div class="form-group">
															<label class="sr-only">Nome Completo</label>
															<input class="form-control" name="agendamento[nome]" type="text" id="txtNome" placeholder="Nome Completo" autocomplete="off" required/>
															<span class="help-block">Campo Obrigatório, por favor preencha.</span>		
														</div>
														<div class="form-group">
															<label class="sr-only">Email</label>
															<input class="form-control" name="agendamento[email]" type="email" id="txtEmail" placeholder="E-mail" autocomplete="off" required/>
															<span class="help-block">Campo Obrigatório, por favor preencha.<strong>exemplo@exemplo.com</strong></span>		
														</div>
														<div class="row">
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="sr-only">Telefone</label>
																	<input class="form-control" name="agendamento[telefone]" type="text" id="txtTelefone" placeholder="Telefone" autocomplete="off" required/>
																	<span class="help-block">Campo Obrigatório, por favor preencha. <strong>(12) 34567-8912</strong></span>		
																</div>
															</div>
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
																<div class="form-group">
																	<label class="sr-only">Horario</label>
									    							<select class="form-control" id="selectHorario" name="agendamento[horario]" placeholder="" required>
									    								<option value="" disabled selected>Período</option>
									    								<?php foreach ($periodo as $kp => $vp) : ?>
										    								<?php
										    									if($vp=="manha"):
										    										$vp = "manhã";
									    										endif;
										    								?>
									    									<option value="<?php echo ucfirst($vp); ?>"><?php echo ucfirst($vp); ?></option>
									    								<?php endforeach; ?>
									    							</select>
									    							<span class="help-block">Campo Obrigatório, por favor selecione um periodo.</span>		
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pull-right">
																<button type="button" class="btn btn-block btn-theme-orange" id="formAgendamento-button">Enviar</button>																
															</div>
														</div>
													</fieldset>
												</form>
										</div>
									</div>
									<div class="row">
												
										<?php 
											endif;
										?>
										<script type="text/javascript">
								    		function enviarAgendamento(){
												var convenio = document.getElementById("selectConvenio");
												var convenio2 = document.getElementById("selectConvenio2");
												var horario = document.getElementById("selectHorario");
												var nome = document.getElementById("txtNome");
												var email = document.getElementById("txtEmail");
												var telefone = document.getElementById("txtTelefone");
												var error;					
												
												if((convenio.value == "")&&(convenio2.value == "")){
													error = "true";
													$("#errorAgenda").css({'display':'block'});
													convenio.className += " error";
												}else{
													convenio.className = "";
												}
												if(horario.value==""){
													error = "true";
													$("#errorAgenda").css({'display':'block'});
													horario.className += " error";
												}else{
													horario.className = "";
												}
												if(nome.value.length<3){
													error = "true";
													$("#errorAgenda").css({'display':'block'});
													nome.className += " error";
												}else{
													nome.className = "";
												}

												if(email.value.length<3){
													error = "true";
													$("#errorAgenda").css({'display': 'block'});
													email.className += " error";
												}else{
													email.className = "";
												}

												if(telefone.value.length<3){
													error = "true";
													telefone.className += " error";
													$("#errorAgenda").css({'display':'block'});
												}else{
													telefone.className = "";
												}
												if(!error){
													ga('send', 'event', 'profissional', 'agendamento', '<?php echo $id; ?> - <?php echo $nome; ?>', {'nonInteraction': 0} );
													document.getElementById("formAgendamento").submit();
												}
								    		}
										</script>
									</div>
								</div>		
								<div class="medico-perfil-section medico-endereco">
									<div class="row container-fluid">
										<div class="pull-left">
											<h3 class="medico-perfil-section--title">Endereços de Atendimento</h3>												
										</div>
										<div class="pull-right">
											<a href="#" id="mapFull">Visualizar Mapa</a>												
										</div>
									</div>
									<?php
									    foreach ($consultorio as $k => $v) { 
											/* 
												$curl = curl_init();
												curl_setopt_array($curl, array(
												  CURLOPT_PORT => "80",
												  CURLOPT_URL => "http://listamed.com.br/api/consultorio/$k",
												  CURLOPT_RETURNTRANSFER => true,
												  CURLOPT_ENCODING => "",
												  CURLOPT_MAXREDIRS => 10,
												  CURLOPT_TIMEOUT => 30,
												  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
												  CURLOPT_CUSTOMREQUEST => "GET",
												));

												$responseConsul = curl_exec($curl);
												$responseConsul = json_decode($responseConsul);
												$err = curl_error($curl);
												curl_close($curl);
											*/
											$responseConsul =	json_decode(file_get_contents("http://listamed.com.br/api/consultorio/$k", false, stream_context_create($arrContextOptions)));	
										}
										$buscar = $responseConsul->data->endereco.'  ,'.$responseConsul->data->numero.' , '.$responseConsul->data->cidade; 
									?>											
									<?php if(@$responseConsul->data->endereco!=""): ?>
											<div class="medico-endereco-mapa" id="map2"></div>
											<div class="medico-endereco-list">
												<div class="row">
									    			<?php 
									    				$count=1;
														foreach ($consultorio as $k => $v): 
															/*	
																$curl = curl_init();
																curl_setopt_array($curl, array(
																  CURLOPT_PORT => "80",
																  CURLOPT_URL => "http://listamed.com.br/api/consultorio/$k",
																  CURLOPT_RETURNTRANSFER => true,
																  CURLOPT_ENCODING => "",
																  CURLOPT_MAXREDIRS => 10,
																  CURLOPT_TIMEOUT => 30,
																  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
																  CURLOPT_CUSTOMREQUEST => "GET",
																));

																$responseConsul = curl_exec($curl);
																$responseConsul = json_decode($responseConsul);
																$err = curl_error($curl);
																curl_close($curl);
															*/
															$responseConsul =	json_decode(file_get_contents("http://listamed.com.br/api/consultorio/$k", false, stream_context_create($arrContextOptions)));
													?>
						        						<div class="col-xs-12 col-lg-6 col-md-6">
						        							<div class="medico-endereco-item">
						        								<h4>
						        									<a class="linkConsultorio 1" href="/centro-medico/<?php echo $responseConsul->data->id ?>/<?php echo slug( $responseConsul->data->nome ); ?>" target="_blank">
						        										<i class="fa fa-caret-right" ></i>
						        										<?php echo ucfirst($v); ?>
						        									</a>
						        								</h4>
						        								<h5>Endereço</h5>
									        					<p>
									        						<?php echo $responseConsul->data->endereco ?>, <?php echo $responseConsul->data->numero ?> | <?php echo $responseConsul->data->bairro ?>
									        						<br/>
																	<?php echo $responseConsul->data->cidade ?>-<?php echo $responseConsul->data->estado_sigla ?> CEP <?php echo $responseConsul->data->cep ?>
																	<div class="medico-ver--localizacao">
																		<a style="cursor: pointer;" onclick="addPonto('<?php echo $responseConsul->data->endereco ?>,<?php echo $responseConsul->data->numero ?> - <?php echo $responseConsul->data->cidade ?>-<?php echo $responseConsul->data->estado_sigla ?> ')"><i class="fa fa-map-marker"></i> Ver no mapa</a>
																	</div>
																</p>				
						        							</div>									        							
						        						</div>
									        			<?php if($count == 1) :?>
															<input type="hidden" name="" value="<?php echo $responseConsul->data->endereco ?>,<?php echo $responseConsul->data->numero ?> - <?php echo $responseConsul->data->cidade ?>-<?php echo $responseConsul->data->estado_sigla ?> " id="pointMap">
									        			<?php endif; ?>
								    				<?php 
								    					$count++; 
								    					endforeach; 
								    				?>
												</div>
											</div>
									<?php else: ?>
											NENHUM CONSULTÓRIO DISPONIVEL!
									<?php endif; ?>
								</div>
								<div class="medico-perfil-section medico-academic">
									<h3 class="medico-perfil-section--title">Formação/Experiência</h3>
									<div class="medico-academic-text" id="texto-block">
										<?php
											/*
											foreach ($experiencia as $kExp => $vExp) : ?>
												<div class="col-lg-9 block-content">
													<p>
														<strong><?php echo $vExp['datainicio']; ?> - <?php echo $vExp['datafim']; ?></strong> <br/> 
														<?php echo $vExp['nome']; ?> <br/> <?php echo $vExp['local']; ?>
														<?php echo (@$vExp['titulo']!="") ? "<br/>Titulo: ".$vExp['titulo']  : "";  ?>
														<?php echo (@$vExp['orientador']!="") ? "<br/>Orientador: ".$vExp['orientador']  : "";  ?>
														<?php echo $vExp['desc']; ?>
													</p>
												</div>	
											<?php endforeach;
											*/ 
										?>
										<div><?php echo $texto; ?></div>
									</div>
									<div class="medico-academic-mais" id="medico-academic-mais">
										<button type="button" class="btnVerMais" onclick="exibeTexto()">Ver Mais</button>
									</div>
									<script type="text/javascript">
										function exibeTexto(){
											$("#texto-block").addClass("open");
											$("#medico-academic-mais").fadeOut('fast').css("display", "none");
										}
									</script>
								</div>				
							</div>
						</div>
						<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
							<div class="page-anuncios" id="page-anuncios"></div>
						</div>
					</div>			
				</div>
			</section>
		</div>
		<footer class="page-footer">
			<div class="page-footer--gray">
				<div class="container">
					<div class="row">
						<div class="col-lg-2 col-md-3 hidden-xs hidden-sm visible-md visible-lg">
							<a href="<?php echo $caminho; ?>seja">Sou profissional da área</a>							
						</div>
						<div class="col-xs-12 col-sm-12 col-md-9 col-lg-10">
							<div class="page-footer--links">
								<ul class="list list-items--inline">
									<li class="list--item"><a href="<?php echo $caminho; ?>contato">Contato</a></li>
									<li class="list--item"><a href="<?php echo $caminho; ?>perguntas-frequentes">Perguntas Frequentes</a></li>
									<li class="list--item"><a href="<?php echo $caminho; ?>sobre">Sobre a ListaMed</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="page-footer--light">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-2 col-md-3 col-lg-4">
							<div class="page-footer--links">
								<ul class="list list-items--inline">
									<li class="list--item">
										<a href="<?php echo $caminho; ?>">
											<img src="<?php echo $caminhoOnline; ?>/images/logo-internas-bot.png" />
										</a>									
									</li>
									<li class="list--item cfm">
				                        <a href="https://portal.cfm.org.br/" target="_blank">
				                        	<img src="<?php echo $caminhoOnline; ?>images/logo-cfm.png" alt="" />
				                       	</a>
									</li>
								</ul>								
							</div>
						</div>	
	                    <div class="col-xs-12 col-sm-8 col-md-7 col-lg-6">
	                        <p>ListaMED é desenvolvida dentro das normas e termos do CFM e da CODAME.</p>
	                    </div>
						<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
				            <?php $conteudo2 =   json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions))); ?>
		 					<div class="page-footer--links text-right">
		 						<ul class="list list-items--inline">
		 							<li class="list--item">
		 								<a href="<?php echo $conteudo2->instagram; ?>"><i class="fa fa-twitter-square" aria-hidden="true"></i></a>		 								
		 							</li>
		 							<li class="list--item">
		                    			<a href="<?php echo $conteudo2->facebook; ?>"><i class="fa fa-facebook-square" aria-hidden="true"></i></a>		 								
		 							</li>
		 							<li class="list--item">
		                    			<a href="<?php echo $conteudo2->linkedin; ?>"><i class="fa fa-linkedin-square" aria-hidden="true"></i></a>		 								
		 							</li>
		 						</ul>
		 					</div>
						</div>
					</div>
				</div>
			</div>					
			<div class="page-footer--dark">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
							<div class="page-footer--copyright">
								<p>Todos os direitos reservados - ListaMED <?php echo date('Y'); ?> ®</p>								
							</div>
						</div>						
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="page-footer--dev">
								<p>
									Feito por 
									<a href="http://www.wdezoito.com.br/" target="_blank"><img src="./images/logo-w18.png" /></a>
								</p>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="page-modals">
			<?php include 'modal-form-convenios.php'; ?>
			<?php include 'modal-form-perfil.php'; ?>
			<?php include 'modal-map.php'; ?>			
		</div>
	</div>
	<script src="/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo $caminho ?>js/champs.min.js"></script>
    <script src="<?php echo $caminho ?>js/ouibounce.js"></script>
    <script src="<?php echo $caminho ?>js/script.js"></script>
	<script type="text/javascript">
		function showTelefone(telefone,info){
			ga('send', 'event', 'profissional', 'telefone', info, {'nonInteraction': 0} );
			document.getElementById("showTelefone").innerHTML = telefone;
		}
		function showTelefone2(telefone,info){
			ga('send', 'event', 'profissional', 'telefone', info, {'nonInteraction': 0} );
			document.getElementById("showTelefone2").innerHTML = telefone;
		}
		function showWhats(telefone,info){
			ga('send', 'event', 'profissional', 'whatsapp', info, {'nonInteraction': 0} );
			document.getElementById("showWhatsapp").innerHTML = '<i class="fa fa-whatsapp"></i>'+telefone;
		}
		function showSite(site,info){
			ga('send', 'event', 'profissional', 'site', info, {'nonInteraction': 0} );
			document.getElementById("showSite").innerHTML = '<i class="fa fa-mouse-pointer"></i>'+site;
		}
	</script>
	<script type="text/javascript">
	    var map;
		var markers = [];    
		function initMap() {
			var image = {
		        url: '/images/marcador.png',
		        size: new google.maps.Size(48, 48),
		        origin: new google.maps.Point(0, 0),
		        anchor: new google.maps.Point(0, 32)
		    };

		  	$.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?address=<?php echo $buscar; ?>&key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg", function( data ) {
				var myLatLng = {lat: data.results[0].geometry.location.lat, lng: data.results[0].geometry.location.lng};
				map = new google.maps.Map(document.getElementById('map2'), {
				  center: myLatLng,
				  zoom: 15,
				  scrollwheel: false
				});
			    var marker = new google.maps.Marker({
				  position: myLatLng,
				  map: map,
				  icon : image
				});
			});	
		}
		function removePonto(ponto){
		    if(ponto['id_onibus']>0){
		        if (typeof markers[ponto['id_consultorio']] === "undefined"){
		            console.log('Ponto novo no mapa'); 
		        }else{
		            console.log('Atualizou a posição de um ponto'); 
		            markers[ponto['id_consultorio']].setMap(null);
		        }
		    }
		}
		function addPonto(ponto){
			var image = {
		        url: '/images/marcador.png',
		        size: new google.maps.Size(48, 48),
		        origin: new google.maps.Point(0, 0),
		        anchor: new google.maps.Point(0, 32)
		    };
			$.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?address="+ponto+"&key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg", function( data ) {
				var myLatLng = {lat: data.results[0].geometry.location.lat, lng: data.results[0].geometry.location.lng};
					map = new google.maps.Map(document.getElementById('map2'), {
				  center: myLatLng,
				  zoom: 15,
				  scrollwheel: false
				});
			    var marker = new google.maps.Marker({
			        position: myLatLng,
			        map: map,
			        icon: image
			    });
		    	markers[ponto['id_consultorio']] = [ marker ];
			});	
			$("#pointMap").val(ponto);
		}
		<?php if($enviado==2): ?>
				var modalExists = new Modal(),
				cloneExists = $("#ModalFormConfirmacao").clone();
				modalExists.setContainer(cloneExists[0]);
				modalExists.setClassModal("fade-in");
				modalExists.setClassModal("modal-exists");
				modalExists.setClassModalContainer("open");
				modalExists.setClassModalContainer("center");
				modalExists.setClassModalContainer("col-lg-3");
				modalExists.setClassModalContainer("col-xs-10");
				modalExists.setClassModalContainer("col-sm-6");
				modalExists.showModal();
		<?php endif; ?>
	</script> 
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg&callback=initMap&sensor=false" async defer></script>
	<?php if($desconto!=""): ?>
		<script type="text/javascript">
			jQuery(document).ready(function($) {
				$("#campoDesconto").click(function(){
					if( $(this).is(':checked') ) {
						// com desconto
						$("#selectConvenio").css("display","none");
						$("#selectConvenio2").css("display","block");
					}else{
						// sem desconto
						$("#selectConvenio2").css("display","none");
						$("#selectConvenio").css("display","block");
					}					

				});				
			});
		</script>
	<?php endif; ?>
	<script type="text/javascript">
	    $(document).ready(function() {
	        jQuery.expr[':'].focus = function( elem ) {
	          return elem === document.activeElement && ( elem.type || elem.href );
	        };
	        $(window).keydown(function(event){
	            if(event.keyCode == 13) {
	                if ($( "#campoBuscar" ).is(":focus")) {
	                    enviarForm();
	                }
	                event.preventDefault();
	                return false;
	            }
	        });
	        $.ajax({
	            url: '/banner_list.php',
	            type: 'POST',
	            data: {dados: '<?php echo json_encode($especialidade_full); ?>'},
	            success: function(data){
	            	$("#page-anuncios").html(data);
	            }
	        });
	       	function getMakerPoint(){
	       		var mapMaker = $("#pointMap").val();
	   			initMap2(mapMaker);
	       	}
			function initMap2(ponto) {
		 		var map;
				var markers = [];    
				var image = {
			        url: '/images/marcador.png',
			        size: new google.maps.Size(48, 48),
			        origin: new google.maps.Point(0, 0),
			        anchor: new google.maps.Point(0, 32)
			    };

			  	$.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?address="+ponto+"&key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg", function( data ) {
					var myLatLng = {lat: data.results[0].geometry.location.lat, lng: data.results[0].geometry.location.lng};
					map = new google.maps.Map(document.getElementById('map3'), {
					  center: myLatLng,
					  zoom: 15,
					  scrollwheel: false
					});
				    var marker = new google.maps.Marker({
					  position: myLatLng,
					  map: map,
					  icon : image
					});
				});	
			}
	        $("#mapFull").click(function(e){
	        	e.preventDefault();

				var modalMap = new Modal(),
					clone = $("#ModalMapFull").clone();
				var DivModalMapFull = document.createElement('div');
				DivModalMapFull.setAttribute('class', 'modal-block--perfil');
				DivModalMapFull.setAttribute('id', 'ModalMapFull');
				var Divrow = document.createElement('div');
				Divrow.setAttribute('class', 'col-lg-12 text-center center');
				var DivPerfilContent = document.createElement('div');
				DivPerfilContent.setAttribute('class', 'perfil-content');
				var DivMap3 = document.createElement('div');
				DivMap3.setAttribute('id', 'map3');

				DivPerfilContent.appendChild(DivMap3);
				Divrow.appendChild(DivPerfilContent);
				DivModalMapFull.appendChild(Divrow);



				modalMap.setContainer(DivModalMapFull);
				modalMap.setClassModal("modalMap");
				modalMap.setClassModalContainer("open");
				modalMap.setClassModalContainer("col-lg-10");
				modalMap.setClassModalContainer("col-sm-10");
				modalMap.setClassModal("fade-in");
				modalMap.setClassModalContainer("col-xs-10");
				modalMap.setClassModalContainer("container");
				modalMap.setClassModalContainer("center");
				modalMap.cbOnload = getMakerPoint;
				modalMap.showModal();
			});
	    });
	</script>
</body>
</html>