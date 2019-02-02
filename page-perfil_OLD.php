<?php session_start(); include 'header2.php'; ?>
<?php
	if($_GET['action']=="edit"):
		$action = true;
	endif;

	// pegando o id do médico da url
	$auxID = $_SERVER['REDIRECT_URL'];
	$auxID = explode('/', $auxID);
	$id = $auxID['3'];

    // se foi enviado formulario de retorno
    if(isset($_POST['agendamento'])):

    	// incluindo classes do sendgrid
		require 'sendgrid/vendor/autoload.php';
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		// preparando e-mail para envio
		$from = new SendGrid\Email(null, "transacional@listamed.com.br");
		$subject = "Agendamento!";
		$to = new SendGrid\Email(null, "marcelolauton@wdezoito.com.br");

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

	// buscando informações do médico
	$curl = curl_init();
	curl_setopt_array($curl, array(
	  CURLOPT_PORT => "82",
	  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/medico/".$id."/full",
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

  	// preparando o retorno
    $info = $response->data;

    foreach ($info as $k => $inf) {
	    $id = $inf->id;
	    $nome = $inf->nome;
	    $cidade = $inf->cidade;
	    $crm = $inf->crm;
	    $email = $inf->email;
	    $telefone = $inf->telefone;
	    $whatsapp = $inf->whatsapp;
	    $site = $inf->site;

	    $caminhoImagem = '/listamed-back/gerenciar/upload/'.$inf->imagem.'.png';
	    $imagem = ($inf->imagem!="") ? 'http://projetos.wdezoito.com.br:82'.$caminhoImagem : 'http://projetos.wdezoito.com.br:82/listamed/wp-content/themes/wdezoitotheme/images/medico.png';
	    
	    $convenios = $inf->convenio;
	    $especialidade = "";
	    
	    $facebook = $inf->facebook;
	    $instagram = $inf->instagram;
	    $twitter = $inf->twitter;

	    foreach ($inf->especialidade as $ke => $ve) {
	        $especialidade = ($especialidade == "") ? $especialidade = $ve : $especialidade .= " | ".$ve; 
	    }
	    foreach ($inf->consultorio as $ke => $ve) {
	        $consultorio[$ke] = $ve;
	    }
	    foreach ($inf->experiencia as $ke => $ve) {
	        $experiencia[$ke]['nome'] = $ve->nome;
	        $experiencia[$ke]['desc'] = $ve->desc;
	        $experiencia[$ke]['imagem'] = $ve->imagem;
	    }

	    if($telefone!="")
	        $telefone2 = substr($telefone, 0, 5)."...Ver Telefone";
	    if($whatsapp!="")
	        $whatsapp2 = substr($whatsapp, 0, 5)."...Ver Whatsapp";

	    if($site!="")
	        $site2 = substr($site, 0, 5)."...Ver Site";
    }

?>
<script type="text/javascript">
	function showTelefone(telefone){
		document.getElementById("showTelefone").innerHTML = '<i class="fa fa-phone"></i>'+telefone;
	}
	function showTelefone2(telefone){
		document.getElementById("showTelefone2").innerHTML = '<i class="fa fa-phone"></i>'+telefone;
	}
	function showWhats(telefone){
		document.getElementById("showWhatsapp").innerHTML = '<i class="fa fa-whatsapp"></i>'+telefone;
	}
	function showSite(site){
		document.getElementById("showSite").innerHTML = '<i class="fa fa-mouse-pointer"></i>'+site;
	}

</script>
	<!--
		MOBILE
	-->
	<div class="row">
		<section class="col-xs-12 mobile-show tablet-show medico-mobile--container">
			<div id="inicio"></div>
			<div class="medico-mobile--align">
				<div class="center medico-mobile--top container row">
					<div class="center left col-xs-7 medico-mobile--info">
						<div class="medico-mobile--nome">
							<h1><?php echo $nome ?></h1>	
						</div>
						<div class="medico-mobile--esp">
							<h2><?php echo $especialidade; ?></h2>
						</div>
						<div class="medico-mobile--crm">
							<h3>CRM <?php echo $crm; ?></h3>
						</div>
					</div>
					<div class="col-xs-5">
						<div class="right medico-mobile--button">
							<a href="" class="btn"><i class="fa fa-phone"></i>Ligar</a>
						</div>
					</div>
				</div>
			</div>
			<div class="perfil-mobile--wrapper col-xs-12">
				<div class="container row">
	                <div class="perfil-mobile-img col-xs-5 left">
	                    <img src="<?php echo $imagem; ?>"/>
	                </div>	
	                <div class="col-xs-7">
	                    <div class="perfil-mobile-detalhes container right">
	                        <h1>
	                            <?php echo $nome; ?>
	                        </h1>
	                        <h2>
	                            <?php echo $especialidade; ?>
	                        </h2>
	                        <h3>
	                            CRM <?php echo $crm; ?>
	                        </h3>
	                    </div>
	                </div>
				</div>
			</div>
			<div class="container row col-xs-12 center">
				<div class="perfil-mobile--button text-center">
					<div class="perfil-mobile--button-pre">
						<a class="btn btn-block btn-pre">Agendar Pré-Consulta</a>
						<p>Sua pré-consulta rápida e fácil!</p>
					</div>
					<div class="perfil-mobile--button-group">
						<a class="btn btn-block" href=""><i class="fa fa-phone"></i>Ligar <?php echo $ligar_perfil; ?></a>
					</div>
					<div class="perfil-mobile--button-group">
						<a class="btn btn-block" href=""><i class="fa fa-whatsapp"></i>Whatsapp <?php echo $whatsapp_perfil; ?></a>
					</div>
					<div class="perfil-mobile--button-group">
						<a class="btn btn-block btn-site" href=""><i class="fa fa-mouse-pointer"></i>Site <?php echo $site_perfil; ?></a>
					</div>
				</div>
			</div>
			<div class="perfil-atendimento--container">
				<div class="perfil-atendimento--top">
		        	<p><i class="fa fa-building-o"></i>Atendimento</p>
		        </div>
		        <div class="container col-xs-12">
		        	<div class="perfil-social">
		        		<div class="left">
							<h1>Redes Sociais:</h1>
							<div class="perfil-social--icons">
								<?php if($facebook != ""){ ?>
									<a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
								<?php } if($instagram != ""){ ?>
									<a href="<?php echo $instagram; ?>"><i class="fa fa-twitter"></i></a>
								<?php } if($twitter != ""){ ?>
									<a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
								<?php } ?>
							</div>
		        		</div>
						<div class="right">
							<h1>E-mail:</h1>
							<div class="perfil-social--email right">
								<?php echo $email; ?>
							</div>
						</div>
					</div>
		        </div>
		        <div class="perfil-localizacao">
		        	<div class="container perfil-localizacao--top">
		        		<span><i class="fa fa-location-arrow"></i>Endereços de atendimento</span>
		        	</div>
		        	<div class="perfil-localizacao--iframe" id="map">
						
					</div>
    				<?php $count=1;
					foreach ($consultorio as $k => $v) { 
					 	// buscando todas informações sobre o consultorio
						$curl = curl_init();
						curl_setopt_array($curl, array(
						  CURLOPT_PORT => "82",
						  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/$k",
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
				 	?>
						<div class="perfil-endereco col-xs-12 container">
        					<h1><i class="fa fa-caret-right" ></i><?php echo ucfirst($v); ?></h1>
        					<h2>Endereço:</h2>	
        					<p><?php echo $responseConsul->data->endereco ?>, <?php echo $responseConsul->data->numero ?> | <?php echo $responseConsul->data->bairro ?><br/>
								<?php echo $responseConsul->data->cidade ?>-<?php echo $responseConsul->data->estado_sigla ?> CEP <?php echo $responseConsul->data->cep ?>
								<div class="medico-ver--localizacao">
									<a href="#"><i class="fa fa-map-marker"></i>Ver no mapa</a>
								</div>
							</p>				
        				</div> 
    				<?php } ?>
		        </div>
		        <div class="container perfil-agenda--container col-xs-12 col-sm-12">
					<h1>Agendar Pré-Consulta</h1>
					<span>Escolha a data e preencha os campos</span>
					<div class="perfil-datepicker--align col-sm-5">
						<div id="datepicker2" class="datepicker"/></div>										
						<input type="hidden" name="agendamento[data]" class="data" />
					</div>
					<div class="col-xs-12 col-sm-7 container">
						<form class="perfil-form--contato">
							<div class="form-field">
								<select>
									<option>Convênio</option>
								</select>
							</div>
							<div class="form-field">
								<input type="text" id="txtNome" placeholder="Nome Completo" />
							</div>
							<div class="form-field">
								<input type="text" id="txtEmail" placeholder="E-mail" />
							</div>
							<div class="form-field">
								<input type="text" id="txtTelefone" placeholder="Telefone"/>
							</div>
							<div class="form-field">
								<select>
									<option>Horário</option>
								</select>
							</div>
							<div class="form-field--button col-xs-12">
								<button class="btn" id="Enviar">Enviar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="perfil-experiencia col-xs-12">
				<div class="perfil-experiencia--top">
					<p><i class="fa fa-shield"></i>Experiência</p>
				</div>
				<div class="container row">
    				<?php foreach ($experiencia as $k => $v) { ?>
        				<div class="perfil-exp--container">
        					<div class="perfil-exp--icon left col-xs-2 container">
        					</div>
        					<div class="perfil-exp--text col-xs-10 container">
        						<h1><?php echo $ve->nome ?></h1>
        						<p><?php echo $ve->desc ?></p>
        					</div>
        				</div>
    				<?php } ?>
				</div>
				<!--<div class="container">
					<div class="perfil-artigo container">
						<a href="#">Veja artigos</a>
						<p>
							Lorem ipsum dolor sit amet, consectetur adipiscing 
							elit, sed do eiusmod tempor incididunt ut labore et
							dolore magna aliqua. Ut enim ad minim veniam, quis
							nostrud exercitation ullamco laboris nisi ut aliquip
							ex ea commodo consequat. Duis aute irure dolor in
							reprehenderit in voluptate velit esse cillum dolore
							eu fugiat nulla pariatur. Excepteur Duis aute irure
							dolor in reprehenderit in voluptate velit esse
							cillum dolore eu fugiat nulla pariatur. Excepteur
						</p>
						<div class="text-center perfil-ancora">
		                    <p><a href="#inicio">Voltar ao topo <i class="fa fa-arrow-up"></i></a></p>
		                </div>
					</div>
				</div> -->
			</div>
		</section>
	</div>

	<!--
		//MOBILE
	-->


	<!--
		DESKTOP E NOTEBOOK
	-->

	<section class="medico-align container col-lg-12 center mobile-hide tablet-hide">
    	<div class="medico-perfil--container left col-lg-3 col-md-3" id="medico-perfil--container">	
        	<div class="container">
    			<div class="medico-perfil--img">
    				<img src="<?php echo $imagem; ?>" />
    			</div>
    			<div class="medico-perfil--info">
	        		<span class="medico-perfil--nome"><?php echo $nome; ?></h1>
	        		<span class="medico-perfil--esp"><?php echo $especialidade; ?></span>
	        		<span class="medico-perfil--crm">CRM <?php echo $crm; ?></span>
	        		<div class="medicos-links--pre">
                        <a class="btn btn-block" href="">Agendar Pré-consulta</a>
                   	</div>
	        		<div class="medicos-links ">
                        <a class="btn btn-block" id="showTelefone2" onclick="showTelefone2('<?php echo $telefone; ?>')" ><i class="fa fa-phone"></i><?php echo $telefone; ?></a>
                    </div>
					<!-- <div class="medicos-links art">
                        <a class="btn btn-block art" href=""><i class="fa fa-file-text"></i>Ler artigos do médico</a>
                    </div> -->
                   	<div class="text-center">
                   		<a href="https://portal.cfm.org.br/"><img src="http://projetos.wdezoito.com.br:82/listamed/wp-content/themes/wdezoitotheme/images/cfm-perfil.png" alt="" /></a>
                   	</div>
    			</div>
        		
        	</div>
    	</div>
    	<div class="medico-perfil--detalhes col-lg-9 col-md-9 right">
    		<div class="container">
        		<div class="container">
        			<div class="medico-perfil--top">
        				<p><i class="fa fa-building-o"></i>Atendimento</p>
        			</div>
        			<div class="container  medico-perfil--color">
        				<div class="container col-lg-12">
	        				<div class="medico-social col-lg-4 left">
	        					<h1>Redes Sociais:</h1>
	        					<div class="medico-social--icons">
									
									<?php if($facebook != ""){ ?>
										<a href="<?php echo $facebook; ?>"><i class="fa fa-facebook"></i></a>
									<?php } else{ ?> 
										<a><i class="fa fa-facebook desativado"></i></a>
									<?php } ?> 
									<?php if($instagram != ""){ ?>
										<a href="<?php echo $instagram; ?>"><i class="fa fa-instagram"></i></a>
									<?php } else{ ?> 
										<a><i class="fa fa-instagram desativado"></i></a>
									<?php } ?> 	
									<?php if($twitter != ""){ ?>
										<a href="<?php echo $twitter; ?>"><i class="fa fa-twitter"></i></a>
									<?php } else{ ?> 
										<a><i class="fa fa-twitter desativado"></i></a>
									<?php } ?> 
	        					</div>
	        					<?php if($email!="") :?>
	        					<h1>E-mail:</h1>
		        					<div class="medico-social--email">
		        						<?php echo $email; ?>
		        					</div>
		        				<?php endif; ?>
	        				</div>
		        			<div class="medico-button--group col-lg-4 right">
		        				<?php if($telefone!=""):?>
			        				<div class="medicos-links">
			                            <a class="btn btn-block" id="showTelefone" onclick="showTelefone('<?php echo $telefone; ?>')" ><i class="fa fa-phone"></i><?php echo $telefone; ?></a>
			                        </div>
			                    <?php endif; ?>
		        				<?php if($whatsapp!=""):?>
 			                        <div class="medicos-links">
			                            <a class="btn btn-block" id="showWhatsapp" onclick="showWhats('<?php echo $whatsapp; ?>')" ><i class="fa fa-whatsapp"></i><?php echo $whatsapp; ?></a>
			                        </div> 
			                    <?php endif; ?>
		        				<?php if($site!=""):?>
		                        <div class="medicos-links">
		                            <a class="btn btn-block" href="http://<?php echo $site; ?>"><i class="fa fa-mouse-pointer"></i><?php echo $site; ?></a>
		                        </div>
			                    <?php endif; ?>
		        			</div>	        					
        				</div>
        				<div class="container row">
        					<div class="medico-social--localizacao ">
		        				<h1><i class="fa fa-location-arrow"></i>Endereços de atendimento</h1>
								<style>
									#map2 {
									    height: 200px;
									    width: 100%;
									}
								</style>
							    <div id="ma"></div>

								    <?php
								    	foreach ($consultorio as $k => $v) { 
	    									$curl = curl_init();
											curl_setopt_array($curl, array(
											  CURLOPT_PORT => "82",
											  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/$k",
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
										}
										$buscar = $responseConsul->data->endereco.'  ,'.$responseConsul->data->numero.' , '.$responseConsul->data->cidade; 
									?>
							    <script>
									var map;

									function initMap() {
									  	$.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?address=<?php echo $buscar; ?>&key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg", function( data ) {
											var myLatLng = {lat: data.results[0].geometry.location.lat, lng: data.results[0].geometry.location.lng};
											map = new google.maps.Map(document.getElementById('map2'), {
											  center: myLatLng,
											  zoom: 15
											});
										    var marker = new google.maps.Marker({
											  position: myLatLng,
											  map: map
											});
										});	
									}
							    </script>
							    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCBQVaqBA6BwvVbTX_rw7ttjEIMTi8cxXg&callback=initMap" async defer></script>
        					</div>
	        			</div>
	        			<div class="container row">
	        				<div class="container medico-social--align col-lg-12">
		        				<?php $count=1;
	        					 foreach ($consultorio as $k => $v) { 
									$curl = curl_init();
									curl_setopt_array($curl, array(
									  CURLOPT_PORT => "82",
									  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/$k",
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
	        				 	?>
			        				<div class="medico-social--endereco col-lg-5 col-md-6 <?php echo ($count%2==0) ? 'right' : 'left' ?>">
			        					<h1><i class="fa fa-caret-right" ></i><?php echo ucfirst($v); ?></h1>
			        					<h2>Endereço:</h2>	
			        					<p><?php echo $responseConsul->data->endereco ?>, <?php echo $responseConsul->data->numero ?> | <?php echo $responseConsul->data->bairro ?><br/>
											<?php echo $responseConsul->data->cidade ?>-<?php echo $responseConsul->data->estado_sigla ?> CEP <?php echo $responseConsul->data->cep ?>
											<div class="medico-ver--localizacao">
												<a href="#"><i class="fa fa-map-marker"></i>Ver no mapa</a>
											</div>
										</p>				
			        				</div> 
		        				<?php $count++; } ?>
	        				</div>
	        			</div>
	        			<div class="container row">
	        				<div class="container medico-agenda--container">
	        					<div class="col-lg-5">
		        					<h1>Agendar Pré-Consulta</h1>
		        					<span>Escolha a data e preencha os campos</span>
	        					</div>
	        				</div>
	        				<div class="container">
        						<form action="" method="post" class="medico-form--contato">
		        					<div class="col-lg-5 col-md-5 left">
		        						<div name="data" id="datepicker" class="datepicker" ></div>										
		        						<input type="hidden" name="agendamento[data]" class="data" />
		        					</div>
		        					<div class="col-lg-6 col-md-5 right">
	        							<div class="form-field">
		        							<select name="agendamento[convenio]">
		        								<option>Convênio</option>
		        								<?php foreach ($convenios as $kConv => $vConv) : ?>
		        										<option value="<?php echo $vConv; ?>"> <?php echo $vConv; ?> </option>
		        								<?php endforeach; ?>
		        							</select>
	        							</div>
	        							<div class="form-field">
	        								<input name="agendamento[nome]" type="text" id="txtNome" placeholder="Nome Completo" />
	        							</div>
	        							<div class="form-field">
	        								<input name="agendamento[email]" type="text" id="txtEmail" placeholder="E-mail" />
	        							</div>
	        							<div class="form-field">
	        								<input name="agendamento[telefone]" type="text" id="txtTelefone" placeholder="Telefone"/>
	        							</div>
	        							<div class="form-field col-lg-4 left">
		        							<select name="agendamento[horario]">
		        								<option>Horário</option>
		        								<option value="manhã">Manhã</option>
		        								<option value="tarde">Tarde</option>
		        							</select>
	        							</div>
	        							<div class="form-field--button col-lg-7 right">
	        								<button type="button" onclick="enviarAgendamento()" class="btn" id="Enviar">Enviar</button>
	        							</div>
	        						</div>
        						</form>
	        				</div>
	        			</div>
	        		</div>
        		</div>
        	</div>
    	</div>

    	<script type="text/javascript">
    		function enviarAgendamento(){
				var nome = document.getElementById("txtNome");
				var email = document.getElementById("txtEmail");
				var telefone = document.getElementById("txtTelefone");
				console.log(nome);
				console.log('------------------');
				console.log(nome.value);
				console.log('------------------');
				console.log(nome.value.length);

				if(nome.value.length>3){
					alert('ok');
				}else{
					alert('nome invalido');
				}
				ga('send', 'event', 'perfil', 'Agendar Consulta', '<?php echo $id; ?> - <?php echo $nome; ?>', {'nonInteraction': 0} );

    		}

    	</script>

        	<!-- <div class="medico-perfil--detalhes align col-lg-9 right">
        		<div class="container">
	        		<div class="container">
	        			

		        		<?php /*if(is_array($experiencia)): ?>
		        			<div class="medico-perfil--top">
		        				<p><i class="fa fa-shield"></i>Experiência</p>
		        			</div>
			        		<div class="container  medico-perfil--color col-lg-12 col-md-12">
			        			<div  class="container col-lg-5 col-md-6 left">
			        				<?php foreach ($experiencia as $k => $v) { ?>
				        				<div class="container medico-exp col-lg-11 col-md-12">
				        					<div class="medico-exp--icon left ">
				        					</div>
				        					<div class="medico-exp--text">
				        						<h1><?php echo $ve->nome ?></h1>
				        						<p><?php echo $ve->desc ?></p>
				        					</div>
				        				</div>
			        				<?php } ?>
			        			</div>
			        			<div class="container">
			        				<div class="col-lg-6 col-md-5 medico-artigo text-right container right">
			        					<a href="">Veja artigos</a>
			        					<p>
											Lorem ipsum dolor sit amet, consectetur adipiscing 
											elit, sed do eiusmod tempor incididunt ut labore et
											dolore magna aliqua. Ut enim ad minim veniam, quis
											nostrud exercitation ullamco laboris nisi ut aliquip
											ex ea commodo consequat. Duis aute irure dolor in
											reprehenderit in voluptate velit esse cillum dolore
											eu fugiat nulla pariatur. Excepteur Duis aute irure
											dolor in reprehenderit in voluptate velit esse
											cillum dolore eu fugiat nulla pariatur. Excepteur
			        					</p>
			        					<div class="medico-like">
			        						<a href=""><i class="fa fa-thumbs-up"></i>Curtir</a>
			        					</div>
			        				</div>
			        			</div>
			        		</div>
		        		<?php endif;*/ ?>
		        	</div>
	        	</div>
	        </div> -->
	</section>

	<!--
		//DESKTOP E NOTEBOOK
	-->
<?php include 'footer-perfil2.php'; ?>
<script>
    $( "#datepicker" ).datepicker({

    	onSelect: function (selectedDate) {
	        $('.data').val(selectedDate);
	    }
    });
	$(document).ready(function() {
	  $(window).keydown(function(event){
	    if(event.keyCode == 13) {
	      event.preventDefault();
	      enviarForm();
	      return false;
	    }
	  });
	});
</script>

<style type="text/css">
	.medico-align .medico-perfil--detalhes .datepicker {
    	margin-top: 15px;
	}
	.medico-align .medico-perfil--detalhes .medico-social .medico-social--icons a i.desativado {
	    color: #d3d3d3;
	}
	#map{
		width: 100%;
		height: 200px;
	}
</style>

