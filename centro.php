<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php require_once 'config.php'; ?>
<?php 
	$url = "https://listamed.com.br/api/consultorio/".$_GET['id'];
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "80",
	  CURLOPT_URL => $url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	));
	$centro = json_decode(curl_exec($curl));
	$err = curl_error($curl);
	curl_close($curl);

	$centro = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)))->data;
	//$centro2 = file_get_contents($caminhoApi."consultorio/".$_GET['id']);
	$convenios = $centro->convenio;

	if($centro->telefone!="") {
		$telefone = $centro->telefone;
        $telefone2 = substr($centro->telefone, 0, 5)."<span> ...ver número</span>";
	}

    $caminhoImagem = 'gerenciar/upload/consultorio/'.$centro->imagem;
    $imagem = ($centro->imagem!="") ? $caminhoOnline.$caminhoImagem : $caminho.'/medico.jpg';
    // se foi enviado formulario de retorno
    if(isset($_POST['agendamento'])):

    	// incluindo classes do sendgrid
		require 'sendgrid/vendor/autoload.php';
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		// preparando e-mail para envio
		$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
		//$from = new SendGrid\Email(null, "transacional@listamed.com.br");
		$subject = "Agendamento!";
		$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");
		//$to = new SendGrid\Email(null, $email);

		// formatando informações para envio
		$texto = "<strong>Paciente: </strong>".$_POST['agendamento']['nome']."<br/>";
		$texto.= "<strong>Email: </strong>".$_POST['agendamento']['email']."<br/>";
		$texto.= "<strong>Telefone: </strong>".$_POST['agendamento']['telefone']."<br/>";
		$texto.= "<strong>Convenio: </strong>".$_POST['agendamento']['convenio']."<br/>";
		$texto.= "<strong>Data: </strong>".$_POST['agendamento']['data']."<br/>";
		$texto.= "<strong>Horario: </strong>".$_POST['agendamento']['horario']."<br/>";

		// enviando o email
		$content = new SendGrid\Content("text/html", $texto);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$response = $sg->client->mail()->send()->post($mail);
    endif;
    $periodo = explode(',', $centro->periodo);
    function slug($nome){
        $aux = strtolower( strip_tags( preg_replace( array( '/[`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/' ), array( null, '-', '-' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', $nome ) ) ) );
        return str_replace(".", "", $aux);   
    }
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
											<div class="medico-content">
												<h2><?php echo $centro->nome; ?></h2>
												<p><?php echo $centro->descricao; ?></p>
												<button type="button" data-toggle="modal" data-target="#listamed-modals-medicos-convenios" class="btn btn-theme-blue">Convênios</button>
											</div>
										</div>
									</div>
								</div>
								<div class="medico-perfil-section medico-info">
									<div class="row">
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="medico-info--item medico-info-contato">
												<div class="medico-info-contato--telefones">
													<h3><i class="fa fa-phone"></i> Telefone(s):</h3>
													<ul class="list list-items--block">
											        	<li class="list--item">
															<a style="cursor: pointer;" id="showTelefone" onclick="showTelefone('<?php echo $telefone; ?>', '<?php echo $centro->id; ?> - <?php echo $centro->nome; ?>' )" ><?php echo $telefone2; ?></a>													        		
											        	</li>
											        </ul>
											    </div>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="medico-info--item medico-info-endereco">
												<h3><i class="fa fa-flag"></i> Endereço:</h3>
												<p>
													<?php echo $centro->endereco; ?>, <?php echo $centro->numero; ?>
													<br/>
									        		<?php echo $centro->cidade; ?> - <?php echo $centro->estado_sigla; ?>
													<br/>
													CEP: <?php echo $centro->cep; ?>
												</p>
											</div>
										</div>
										<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
											<div class="medico-info--item medico-info-website">
												<h3><i class="fa fa-globe"></i> Site:</h3>
												<p><a onclick="ga('send', 'event', 'centro', 'site', '<?php echo $centro->id; ?> - <?php echo $centro->nome; ?>', {'nonInteraction': 0} );" href="<?php echo $centro->site; ?>" target="_blank"><?php echo $centro->site; ?></a></p>
											</div>
											<div class="medico-info--item medico-info-email">
												<h3><i class="fa fa-envelope"></i> E-mail:</h3>
												<a href="mailto:<?php echo $centro->email; ?>"><?php echo $centro->email; ?></a>
											</div>
										</div>
									</div>
								</div>
								<div class="medico-perfil-section centro-equipe">
									<h3 class="medico-perfil-section--title">Profissionais</h3>
									<div class="centro-equipe--container">
										<div class="row">
										 	<?php foreach ($centro->medicos as $kMed => $vMed) : ?>
										 		<?php $link = $caminho."profissional/".$vMed->id."/".slug($vMed->nome); ?>
										 		<div class="col-xs-12 col-sm-6 col-md-3 col-lg-4">
										 			<div class="equipe-block">
										 				<div class="row">
										 					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
														 		<a href="<?php echo $link; ?>" class="equipe-block--img">
														 			<span>
															 			<?php if($vMed->imagem!="") :?>
																 			<img src="<?php echo $caminhoOnline.'gerenciar/upload/profissionais/'.$vMed->imagem; ?>">
																		<?php else: ?>
																 			<img src="<?php echo $caminhoOnline.'gerenciar/upload/profissionais/default.png'; ?>">
																		<?php endif; ?>
																	</span>
														 		</a>											 						
										 					</div>
										 					<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
										 						<div class="equipe-block--info">
										 							<div>
															 			<h4>
																 			<?php if($vMed->status==1): ?>
																 				<a href="<?php echo $link; ?>" style="font-size: 16px; color: #01abeb; text-decoration: none;">
																 					<?php echo $vMed->nome; ?>
																 				</a> 
																 			<?php else: ?>
																 				<a class="btnModalPerfil" style="cursor:pointer"> 
																 					<?php echo $vMed->nome; ?>	
																 				</a>
																 			<?php endif; ?>
														 				</h4>
															 			<p><?php echo $vMed->especialidade_text; ?></p>											 																	 								
										 							</div>
										 						</div>
										 					</div>
										 				</div>
												 	</div>											 			
										 		</div>
												<!--  <script type="text/javascript">
						                            gravarPerfil('<?php //echo $vMed->id; ?> - <?php //echo $vMed->nome; ?>');
						                        </script> -->
											<?php endforeach; ?>
										</div>
									</div>
									<?php  $enderecoMapa = strtolower(trim(str_replace(" ", "+", $centro->endereco).','.str_replace(" ", "+", $centro->cidade)."+".str_replace(" ", "+", $centro->estado_sigla))); ?>
									<iframe width="100%" height="200" style="border:0"  frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg&q=<?php echo $enderecoMapa; ?>" allowfullscreen></iframe>
								</div>
								<div class="medico-perfil-section carousel-block">
									<div class="carousel-centro" id="carousel-centro">
										<?php foreach ($centro->imagens as $kImg => $vImg) : ?>
											<div class="item">
												<div class="carousel-centro--img">
													<a data-fancybox href="<?php echo $caminhoOnline.'gerenciar/upload/galeria/'.$vImg->imagem; ?>">
														<img src="<?php echo $caminhoOnline.'gerenciar/upload/galeria/'.$vImg->imagem; ?>" class="imagem-centro">
													</a>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							</div>
							<div class="medico-perfil">
								<div class="medico-perfil-section centro-services">
									<h3 class="medico-perfil-section--title">Serviços</h3>
									<div class="centro-services--container">
										<div class="centro-list" id="centro-plus">
											<ul class="row container-fluid">
												<?php foreach ($centro->servicos as $kSer => $vSer) : ?>
													<li><?php echo $vSer->nome; ?></li>
												<?php endforeach; ?>
											</ul>
										</div>
										<!-- <div class="centro-list--plus text-center">
											<a class="centro-list">Ver mais</a>
										</div> -->
									</div>
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
									<a href="http://www.wdezoito.com.br/" target="_blank"><img src="<?php echo $caminhoOnline; ?>images/logo-w18.png" /></a>
								</p>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</footer>
		<div class="page-modals">
			 <?php include 'modal-form-convenios.php'; ?>
		</div>
    </div>	
	<?php
		foreach ($convenios as $c => $vc) :
			$convenio2[$c] = $vc->nome;
		endforeach;
		unset($convenios);
		$convenios = $convenio2;

	?>
 	<?php include 'modal-form-perfil.php'; ?>
 	<script src="/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo $caminho ?>js/champs.min.js"></script>
    <script src="<?php echo $caminho ?>js/ouibounce.js"></script>
    <script src="<?php echo $caminho ?>js/script.js"></script>
	<script type="text/javascript">
        $(".centro-list--plus").click(function(){
            $(".centro-list").css({'height':'initial'});
        });
	</script>
	<script type="text/javascript">
		function showTelefone(telefone, info){
			ga('send', 'event', 'centro', 'telefone', info, {'nonInteraction': 0} );
			document.getElementById("showTelefone").innerHTML = telefone;
		}
		function showTelefone2(telefone, info){
			ga('send', 'event', 'centro', 'telefone', info, {'nonInteraction': 0} );
			document.getElementById("showTelefone2").innerHTML = telefone;
		}
		function showWhats(telefone, info){
			ga('send', 'event', 'centro', 'whatsapp', info, {'nonInteraction': 0} );
			document.getElementById("showWhatsapp").innerHTML = '<i class="fa fa-whatsapp"></i>'+telefone;
		}
		function showSite(site, info){
			ga('send', 'event', 'centro', 'site', info, {'nonInteraction': 0} );
			document.getElementById("showSite").innerHTML = '<i class="fa fa-mouse-pointer"></i>'+site;
		}
	    function gravarPerfil(info){
	        ga('send', 'event', 'centro', 'exibido', info, {'nonInteraction': 0} );
	    }
	</script>
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
	    });
	</script>
</body>
</html>
