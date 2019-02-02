<?php session_start(); include 'header2.php'; ?>
<?php
	// functions para gerenciamento da api
	if (!function_exists(getFullMedico)){
		function getFullMedico($id){
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
		    return $response->data;
		}
	}

	if (!function_exists(buscarToken)){
		function buscarToken($crm, $pass){
			$baseAuth = base64_encode($crm . ":" . $pass);
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/usuario",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			  CURLOPT_HTTPHEADER => array(
			    "authorization: Basic $baseAuth"
			  ),
			));

			$response = curl_exec($curl);
			$response = json_decode($response);
			$err = curl_error($curl);

			curl_close($curl);
			return $response;
		}
	}

	if (!function_exists(buscarConsultorio)){
		function buscarConsultorio($key){
			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/$key",
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

			return $responseConsul;
		}
	}

	if (!function_exists(editarConsultorio)){
		function editarConsultorio($dados, $token,$id){
			$curl = curl_init();
			$stringPost = "nome=".$dados['nome']."&endereco%5Bendereco%5D=".$dados['endereco']['endereco']."&endereco%5Bnumero%5D=".$dados['endereco']['numero']."&endereco%5Bbairro%5D=".$dados['endereco']['bairro']."&endereco%5Bcep%5D=".$dados['endereco']['cep']."&endereco%5Btb_cidade_id%5D=".$dados['endereco']['tb_cidade_id']."&endereco%5Bid%5D=".$dados['endereco']['tb_endereco_id'];

			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/$id",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "PUT",
			  CURLOPT_POSTFIELDS => $stringPost,
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "token: $token"
			  ),
			));

			$response = json_decode(curl_exec($curl));
			$err = curl_error($curl);

			curl_close($curl);

			return $response;
		}
	}

	if (!function_exists(inserirConsultorio)){
		function inserirConsultorio($dados, $token){
			$curl = curl_init();
			$stringPost = "-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"nome\"\r\n\r\n".$dados['nome']."\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"endereco[endereco]\"\r\n\r\n".$dados['endereco']['endereco']."\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"endereco[numero]\"\r\n\r\n".$dados['endereco']['numero']."\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"endereco[bairro]\"\r\n\r\n".$dados['endereco']['bairro']."\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"endereco[cep]\"\r\n\r\n".$dados['endereco']['cep']."\r\n-----011000010111000001101001\r\nContent-Disposition: form-data; name=\"endereco[tb_cidade_id]\"\r\n\r\n".$dados['endereco']['tb_cidade_id']."\r\n-----011000010111000001101001--";

			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => $stringPost,
			  CURLOPT_HTTPHEADER => array(
			    "content-type: multipart/form-data; boundary=---011000010111000001101001",
			    "token: $token"
			  ),
			));

			$response = json_decode(curl_exec($curl));
			$err = curl_error($curl);
			curl_close($curl);

			return $response->data->id;
		}
	}

	if (!function_exists(editarMedico)){
		function editarMedico($dados, $token){
			$curl = curl_init();			
			$stringPost = "nome=".$dados['nome']."&crm=".$dados['crm']."&telefone=".$dados['telefone']."&email=".$dados['email']."&site=".$dados['site']."&status=".$dados['status']."&convenio=".$dados['convenio']."&especialidade=".$dados['especialidade']."&consultorio=".$dados['consultorio']."&imagem=".$dados['imagem'];

			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/medico",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "PUT",
			  CURLOPT_POSTFIELDS => $stringPost,
			  CURLOPT_HTTPHEADER => array(
			    "content-type: application/x-www-form-urlencoded",
			    "token: $token"
			  ),
			));

			$response = json_decode(curl_exec($curl));
			$err = curl_error($curl);
			curl_close($curl);

			return $response->data;
		}
	}

	if (!function_exists(buscarEstados)){
		function buscarEstados(){
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/estado",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "GET",
			));
			$responseEstado = curl_exec($curl);
			$responseEstado = json_decode($responseEstado);
			$err = curl_error($curl);
			curl_close($curl);

			return $responseEstado;
		}
	}

	if (!function_exists(EditarSocial)){
		function EditarSocial($dados, $token){
			$curl = curl_init();
			$stringPost = "nome=".$dados['nome']."&link=".$dados['link'];
			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/social/".$dados['id'],
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 30,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "PUT",
			  CURLOPT_POSTFIELDS => $stringPost,
			  CURLOPT_HTTPHEADER => array(
			    "token: $token"
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);
		}
	}

	if (!function_exists(getEspecialidades)){
		function getEspecialidades(){
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_PORT => "82",
			  CURLOPT_URL => "http://projetos.wdezoito.com.br:82/listamed-back/dev2/especialidade",
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
			return $response->data;
		}
	}

	// capturando a id do medico da pagina
	$auxID = $_SERVER['REDIRECT_URL'];
	$auxID = explode('/', $auxID);
	$id = $auxID['3'];
	$_SESSION['token'] = 'ac1f8bb23bed72f68c14f029a07351f8';
	$_SESSION['id'] = 3;
	// se token não existe
	if (( $_SESSION['token'] == "" ) || ( $_SESSION['id'] != $id )) :
		// nao esta logado, tentar logar
		$email = ($_POST['email']) ? $_POST['email'] : null;
		$pass = ($_POST['pass']) ? $_POST['pass'] : null;

		// TEMP
		$email = 'marcelolm'; 
		$pass  = '12345';

		if ( ($email) && ($pass) ):
			$responseToken = buscarToken($email, $pass);
		endif;

		// criando a sessao como novo token
		if($responseToken->valido = "valido"):
			$_SESSION['token'] = $responseToken->data->token;
			$_SESSION['id'] = $responseToken->data->tb_medico_id;

			if($_SESSION['id'] != $id):
				header("Location: http://projetos.wdezoito.com.br:82/listamed/");
			endif;
		else:
			// não foi possivel encontrar um token valido
			header("Location: http://projetos.wdezoito.com.br:82/listamed/");
		endif;
	endif;

	if(( $_SESSION['token'] != "" ) && ( $_SESSION['id'] == $id )) :
		// verifica se foi enviado o post
		if(is_array($_POST['info'])):
		    $post = $_POST['info'];
			
			$imagem = $_FILES['foto'];
			if($imagem['tmp_name']!=""):
				$caminho = "../../../fotos/";
				$uploadfile = $caminho . basename($imagem['name']);
				$uploadfileSave = "/fotos/" . basename($imagem['name']);
				if (move_uploaded_file($imagem['tmp_name'], $uploadfile)) {
					//echo "Arquivo válido e enviado com sucesso.\n";
				}
			endif;

			// busca as informações atuais do médico
		    $info = getFullMedico($id);
		
			// começa o preparo pra envio das novas informações
			$dados['nome'] = $post['nome_medico'];
			$dados['crm']  = $post['crm_medico'];
			$dados['email']  = $post['email'];
			$dados['site'] = $post['site_medico'];
			$dados['telefone'] = $post['telefone'];
			$dados['status'] = 1;


			// preparando os convenios
			$infoArrayAux = (array) $info;
			$infoArray = array_shift($infoArrayAux);
			if($uploadfileSave!=""){
				$dados['imagem'] = $uploadfileSave;
			}else{
				$dados['imagem'] = $infoArray->imagem;
			}

			foreach ($infoArray->convenio as $kConvenio => $vConvenio) {
				if($dados['convenio']==""):
					$dados['convenio'] = $kConvenio;
				else:
					$dados['convenio'] .= ','.$kConvenio;
				endif;
			}

			// preparando as especilidades
			foreach ($infoArray->especialidade as $kEspecialidade => $vEspecialidade) {
				if($dados['especialidade']==""):
					$dados['especialidade'] = $kEspecialidade;
				else:
					$dados['especialidade'] .= ','.$kEspecialidade;
				endif;
			}

			// preparando os consultorios
			foreach ($infoArray->consultorio as $kConsultorio => $vConsultorio) {
				$existe = buscarConsultorio($kConsultorio);

				// organizando dados para envio		
				$consultorio['id'] = $post['consultorio'][$kConsultorio]['id'];
				$consultorio['nome'] = $post['consultorio'][$kConsultorio]['nome'];
				$consultorio['endereco']['endereco'] = $post['consultorio'][$kConsultorio]['endereco'];
				$consultorio['endereco']['numero'] = $post['consultorio'][$kConsultorio]['numero'];
				$consultorio['endereco']['bairro'] = $post['consultorio'][$kConsultorio]['bairro'];
				$consultorio['endereco']['cidade'] = $post['consultorio'][$kConsultorio]['cidade'];
				$consultorio['endereco']['estado_sigla'] = $post['consultorio'][$kConsultorio]['estado_sigla'];
				$consultorio['endereco']['cep'] = $post['consultorio'][$kConsultorio]['cep'];
				$consultorio['endereco']['tb_endereco_id'] = $post['consultorio'][$kConsultorio]['tb_endereco_id'];
				$consultorio['endereco']['tb_cidade_id'] = $post['consultorio'][$kConsultorio]['tb_cidade_id'];

				if(!isset($existe->data->scalar)):
					editarConsultorio($consultorio,$_SESSION['token'],$consultorio['id']);
					if($dados['consultorio']==""):
						$dados['consultorio'] = $kConsultorio;
					else:
						$dados['consultorio'] .= ','.$kConsultorio;
					endif;
				else:
					$dados = inserirConsultorio($consultorio,$_SESSION['token']);
					if($dados['consultorio']==""):
						$dados['consultorio'] = $dados;
					else:
						$dados['consultorio'] .= ','.$dados;
					endif;
				endif;
			}

			foreach ($post['redesocial'] as $ks => $vs) {
				EditarSocial(array("id"=>$ks, "nome" => $vs['nome'], "link" => $vs['link'] ) ,$_SESSION['token']);
			}

			// editando o médico
			editarMedico($dados,$_SESSION['token']);
			unset($consultorio);
		endif;	
	
		// organizando informações para exibir no formulario
	    $info = getFullMedico($_SESSION['id']);
    	foreach ($info as $k => $inf) {
		    $id = $inf->id;
		    $nome = $inf->nome;
		    $cidade = $inf->cidade;
		    $crm = $inf->crm;
		    $email = $inf->email;
		    $telefone = $inf->telefone;
		    $site = $inf->site;
		    $imagem = (file_exists($inf->imagem)) ? $inf->imagem : 'http://projetos.wdezoito.com.br:82/listamed/fotos/medico.jpg';

		    $convenios = "";
		    $especialidade = "";
	
		    foreach ($inf->convenio as $kc => $vc) {
		        $convenios = ($convenios=="") ? $convenios = $vc : $convenios .= " | ".$vc; 
		    }
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
		        $telefone = substr($telefone, 0, 5)."...Ver Telefone";
	
		    if($site!="")
		        $site = substr($site, 0, 15)."...Ver Site";
    	}

	else:
		// não foi possivel encontrar um token valido
		//header("Location:". $_SERVER['HTTP_REFERER']);
	endif;
	
?>


<form id="editPerfil" method="post" action="#" enctype="multipart/form-data">

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
							<h1>
								<input type="text" name="info[nome_medico]" value="<?php echo $nome ?>" />
							</h1>	
						</div>
						<div class="medico-mobile--esp">
							<h2 ><?php echo $especialidade; ?></h2>
						</div>
						<div class="medico-mobile--crm">
							<h3>CRM 


							<input type="text" name="info[crm_medico]" value="<?php echo $crm; ?>" /></h3>
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
	                            <input type="text" name="info[nome_medico]" value="<?php echo $nome ?>" />
	                        </h1>
	                        <h2>
	                            <?php echo $especialidade; ?>
	                        </h2>
	                        <h3>
	                        	CRM <input type="text" name="info[crm_medico]" value="<?php echo $crm; ?>" />
	                        </h3>
	                    </div>
	                </div>
				</div>
			</div>
			<div class="container row col-xs-12 center">
				<div class="perfil-mobile--button text-center">
<!-- 					<div class="perfil-mobile--button-pre">
						<a class="btn btn-block btn-pre">Agendar Pré-Consulta</a>
						<p>Sua pré-consulta rápida e fácil!</p>
					</div> -->
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
								<?php
									foreach ($inf->redesocial as $k => $v) {
										if($v->nome == "facebook"){ ?>
											<a href="<?php echo $v->link; ?>"><i class="fa fa-facebook"></i></a>

										<?php } else if($v->nome == "instagram"){ ?>
											<a href="<?php echo $v->link; ?>"><i class="fa fa-twitter"></i></a>
										<?php } 
									}
								?>
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
		        	<div class="perfil-localizacao--iframe">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d924.057893102244!2d-51.39586973895186!3d-22.117144759468573!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9493f4362bb41f77%3A0x62d4a8170004db5f!2sAv.+Pres.+Washington+Lu%C3%ADz%2C+Pres.+Prudente+-+SP!5e0!3m2!1spt-BR!2sbr!4v1481131720446" width="100%;" height="160px;" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
    				<?php $count=1;
					 foreach ($consultorio as $k => $v) { 
					 	$responseConsul = buscarConsultorio($k);
				 	?>
						<div class="perfil-endereco col-xs-12 container">
        					<h1><i class="fa fa-caret-right" ></i><?php echo ucfirst($v); ?></h1>
        					<h2 style="position: relative; top: 15px;">Endereço:</h2>	
        					<p><?php echo $responseConsul->data->endereco ?>, <?php echo $responseConsul->data->numero ?> | <?php echo $responseConsul->data->bairro ?><br/>
								<?php echo $responseConsul->data->cidade ?>-<?php echo $responseConsul->data->estado_sigla ?> CEP <?php echo $responseConsul->data->cep ?>
								<div class="medico-ver--localizacao">
									<i class="fa fa-map-marker"></i>Excluir consultório
								</div>
							</p>				
        				</div> 
    				<?php } ?>
		        </div>
		        <div class="container perfil-agenda--container col-xs-12 col-sm-12">
					<h1>Agendar Pré-Consulta</h1>
					<span>Escolha a data e preencha os campos</span>
					<div class="perfil-datepicker--align col-sm-5">
						<div id="datepicker" class="datepicker"/></div>										
					</div>
					<div class="col-xs-12 col-sm-7 container">
						<!-- <form class="perfil-form--contato"> -->
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
							<div class="text-center">
								<div class="form-text">
									<p>Não esqueça de falar que você encontrou pelo <strong>ListaMed</strong></p>
								</div>
							</div>
						<!-- </form> -->
					</div>
				</div>
			</div>
			<!-- <div class="perfil-experiencia col-xs-12">
				<div class="perfil-experiencia--top">
					<p><i class="fa fa-shield"></i>Experiência</p>
				</div>
				<div class="container row">
    				<?php /*foreach ($experiencia as $k => $v) { ?>
        				<div class="perfil-exp--container">
        					<div class="perfil-exp--icon left col-xs-2 container">
        					</div>
        					<div class="perfil-exp--text col-xs-10 container">
        						<h1><?php echo $ve->nome ?></h1>
        						<p><?php echo $ve->desc ?></p>
        					</div>
        				</div>
    				<?php }*/ ?>
				</div>
				<div class="container">
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
				</div>
			</div> -->
		</section>
	</div>

	<!--
		//MOBILE
	-->


	<!--
		DESKTOP E NOTEBOOK
	-->

	<section class="medico-align container col-lg-12 center mobile-hide tablet-hide">
        	<div class="medico-perfil--container col-lg-3 left">	
	        	<div class="container">
        			<div class="medico-perfil--img">
        				<input type="file" name="foto" />
        				<img src="<?php echo $imagem; ?>" />
        			</div>
        			<div class="medico-perfil--info">
		        		<span class="medico-perfil--nome"><input type="text" name="info[nome_medico]" value="<?php echo $nome ?>" /></h1>
		        		<span class="medico-perfil--esp">

			        			<ul class="listEspecialidadeMedico">
				        		<?php foreach ($inf->especialidade as $kiE => $viE) : ?>
				        			<li rel="<?php echo $kiE ?>"><?php echo $viE ?> <span class="btnCursor" onclick="removerEspecialidade(<?php echo $kiE ?>)" > [remover] </span></li> 
				        		<?php endforeach; ?>
			        			</ul>
			 

			        		<?php //echo $especialidade; ?>

							<?php $todasEspecilidades = getEspecialidades(); ?>
							<?php if(count($todasEspecilidades)>0): ?>
								<select class="especialidadeMedico" name="especialidadeMedico">
								<?php foreach ($todasEspecilidades as $kE => $vE) { ?>
									<option value="<?php echo $vE->id ?>"><?php echo $vE->nome ?></option>
								<?php } ?>
								</select>
								<span class="btnEdit EditEsp">Adicionar</span>
							<?php endif; ?>

		        		</span>
		        		<span class="medico-perfil--crm">CRM <input type="text" name="info[crm_medico]" value="<?php echo $crm; ?>" /></span>
                        <div class="medicos-links--pre art">
                            <span onclick="editarPerfil()" class="btn btn-block art btnSalvar" href=""></i>Salvar Perfil</span>
                        </div>

                       	<div class="text-center">
                       		<a href="https://portal.cfm.org.br/"><img src="http://projetos.wdezoito.com.br:82/listamed/wp-content/themes/wdezoitotheme/images/cfm-perfil.png" alt="" /></a>
                       	</div>
        			</div>
	        		
	        	</div>
        	</div>
        	<div class="medico-perfil--detalhes col-lg-9 right">
        		<div class="container">
	        		<div class="container">
	        			<div class="medico-perfil--top">
	        				<p><i class="fa fa-building-o"></i>Atendimento</p>
	        			</div>
	        			<div class="container  medico-perfil--color">
	        				<div class="container col-lg-12">
		        				<div class="medico-social col-lg-5 left">
		        					<h1>Redes Sociais:</h1>
		        					<div class="medico-social--icons">
										<?php foreach ($inf->redesocial as $k => $v) { ?>
													<div>
														<div style="float:left; width: 120px;">
															<label class="redeTitulo">Nome:</label>
															<input class="redeInput" type="text" name="info[redesocial][<?php echo $k; ?>][nome]" value="<?php echo $v->nome; ?>" />
														</div>
														<div style="float:left; width: 212px;">
															<label class="redeTitulo">Link:</label>
															<input class="redeInput" type="text" name="info[redesocial][<?php echo $k; ?>][link]" value="<?php echo $v->link; ?>" />
														</div>
													</div>
												<?php
											}
										?>
		        					</div>
		        					<h1>E-mail:</h1>
		        					<div class="medico-social--email">
		        						<input type="text" name="info[email]" value="<?php echo $email; ?>" />
		        					</div>
		        				</div>
			        			<div class="medico-button--group col-lg-5 right">
			        				<div class="medicos-links">
			                            <input type="text" name="info[telefone]" value="<?php echo $inf->telefone; ?>" />
			                        </div>
									<!--<div class="medicos-links">
			                            <a class="btn btn-block" href="<?php //the_permalink(); ?>"><i class="fa fa-whatsapp"></i><?php //echo $whatsapp_ver; ?></a>
			                        </div> -->
			                        <div class="medicos-links">
			                            <input type="text" name="info[site_medico]" value="<?php echo $inf->site; ?>" />
			                        </div>
			        			</div>	        					
	        				</div>

		        			<div class="container row">
		        				<div class="container medico-social--align col-lg-12" style="padding: 0;">
			        				<?php
		        					foreach ($consultorio as $k => $v) { 
										$responseConsul = buscarConsultorio($k);
		        				 	?>

				        				<div rel="<?php echo $k; ?>" class="medico-social--endereco col-lg-5 col-md-6 <?php echo ($count%2==0) ? 'right' : 'left' ?>">
				        					<h1><i class="fa fa-caret-right" ></i>
				        					<input class="consultorioTitulo" type="text" name="info[consultorio][<?php echo $k; ?>][nome]" value="<?php echo ucfirst($v); ?>" />
				        					
				        					</h1>
				        					<h2 style="position: relative; top: 15px;">Endereço:</h2>	
				        					<p class="consultorioP">
					        					<input class="idConsul" type="hidden" name="info[consultorio][<?php echo $k; ?>][id]" value="<?php echo $responseConsul->data->id; ?>" /><br/>
					        					<input type="hidden" name="info[consultorio][<?php echo $k; ?>][tb_endereco_id]" value="<?php echo $responseConsul->data->tb_endereco_id; ?>" /><br/>
					        					<input type="hidden" name="info[consultorio][<?php echo $k; ?>][tb_cidade_id]" value="<?php echo $responseConsul->data->tb_cidade_id; ?>" /><br/>
					        					<input type="hidden" name="info[consultorio][<?php echo $k; ?>][tb_estado_id]" value="<?php echo $responseConsul->data->tb_estado_id; ?>" /><br/>
					        					<input type="text" name="info[consultorio][<?php echo $k; ?>][endereco]" value="<?php echo $responseConsul->data->endereco ?>" /><br/>
					        					<input type="text" name="info[consultorio][<?php echo $k; ?>][numero]" value="<?php echo $responseConsul->data->numero; ?>" /><br/>
					        					<input type="text" name="info[consultorio][<?php echo $k; ?>][bairro]" value="<?php echo $responseConsul->data->bairro; ?>" /><br/>
					        					<input disabled type="text" name="info[consultorio][<?php echo $k; ?>][cidade]" value="<?php echo $responseConsul->data->cidade; ?>" /><br/>
					        					<input disabled type="text" name="info[consultorio][<?php echo $k; ?>][estado_sigla]" value="<?php echo $responseConsul->data->estado_sigla; ?>" /><br/>
					        					<input type="text" name="info[consultorio][<?php echo $k; ?>][cep]" value="<?php echo $responseConsul->data->cep; ?>" />
												<div class="medico-ver--localizacao excluirConsultorio">
													<i class="fa fa-trash-o"></i>Excluir consultório
												</div>
											</p>				
				        				</div> 
			        				<?php $count++; } ?>
		        				</div>
		        				<span class="btnNovoConsul"> Adicionar Novo consultório</span>
		        				<div class="formNovoConsul" style="display: block;margin: 20px 0;"> 
									<label>nome</label><input type="text" name="info[consultorio][nome]" value="" /> </br/>
									<label>endereco</label><input type="text" name="info[consultorio][endereco]" value="" /> </br/>
									<label>numero</label><input type="text" name="info[consultorio][numero]" value="" /> </br/>
									<label>bairro</label><input type="text" name="info[consultorio][bairro]" value="" /> </br/>
									<?php $estados = buscarEstados(); ?>
										<select class="estadoNovoConsul" name="info[consultorio][estado]">
											<option value="-">Selecione um estado</option>
											<?php foreach ($estados->data as $kEst => $vEst) { ?>
												<option value="<?php echo $vEst->id; ?>"><?php echo $vEst->nome; ?></option>
											<?php } ?>
										</select>
										<select class="cidadeNovoConsul" name="info[consultorio][cidade]">
											<option value="-">Selecione uma cidade</option>
										</select>
										<br/>
									<label>cep</label><input type="text" name="info[consultorio][cep]" value="" /> </br/>
		        					<span class="btnSalvarConsul"> Salvar Novo consultório</span>
		        				</div>

		        			</div>
	        			</div>
	        		</div>
        			
        		</div>
        	</div>
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
					        					<input type="text" name="info[experiencia][<?php echo $k; ?>][nome]" value="<?php echo $ve->nome; ?>" />
					        					<input type="text" name="info[experiencia][<?php echo $k; ?>][desc]" value="<?php echo $ve->desc; ?>" />
				        					</div>
				        				</div>
			        				<?php } ?>
			        			</div>
			        		</div>
		        		<?php endif; */ ?>
		        	</div>
	        	</div>
	        </div> -->
	</section>

</form>
	<!--
		//DESKTOP E NOTEBOOK
	-->
<?php include 'footer-perfil2.php'; ?>
<script type="text/javascript">
	function editarPerfil(){
		$('#editPerfil').submit();
	}

	function removerEspecialidade(id){
		var settings = {
		  "async": true,
		  "crossDomain": true,
		  "url": "http://projetos.wdezoito.com.br:82/listamed-back/dev2/medico//especialidade/",
		  "method": "DELETE",
		  "headers": {
		    "token": "6aceb13f6b857551b723a05f887832ab",
		    "content-type": "application/x-www-form-urlencoded"
		  },
		  "data": {
		    "especialidade": id,
		    "medico": "<?php echo $_SESSION['id']; ?>"
		  }
		}

		$.ajax(settings).done(function (response) {
			$('.listEspecialidadeMedico li[rel='+id+']').fadeOut('slow');
		  console.log(response);
		});
	}


$( document ).ready(function() {
 
	$('.excluirConsultorio').click(function(data){
		
		idConsul = $(this).parent().attr('rel');
		var settings = {
		  "async": true,
		  "crossDomain": true,
		  "url": "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/"+idConsul,
		  "method": "DELETE",
		  "headers": {
		    "token": "<?php echo $_SESSION['token']; ?>",
		    "content-type": "application/x-www-form-urlencoded"
		  },
		  "data": {}
		}

		$.ajax(settings).done(function (response) {
			$('.medico-social--endereco[rel='+idConsul+']').slideUp();
		});
	});

	$('.btnNovoConsul').click(function(data){
		$('.formNovoConsul').toggle('slow');
	});
		
	$('.btnSalvarConsul').click(function(data){

		// capturando os valores
		var nome = $('input[name="info[consultorio][nome]"]').val();
		var endereco = $('input[name="info[consultorio][endereco]"]').val();
		var numero =  $('input[name="info[consultorio][numero]"]').val();
		var bairro =  $('input[name="info[consultorio][bairro]"]').val();
		var cidade =  $('select[name="info[consultorio][cidade]"]').val();
		var cep =  $('input[name="info[consultorio][cep]"]').val();

		if( (nome!="") && (endereco!="") && (numero!="") && (bairro!="") && (cidade!="") && (cep!="") ){

			var form = new FormData();
			form.append("nome", nome);
			form.append("endereco[endereco]", endereco);
			form.append("endereco[numero]", numero);
			form.append("endereco[bairro]", bairro);
			form.append("endereco[cep]", cep);
			form.append("endereco[tb_cidade_id]", cidade);

			var settings = {
			  "async": true,
			  "crossDomain": true,
			  "url": "http://projetos.wdezoito.com.br:82/listamed-back/dev2/consultorio/",
			  "method": "POST",
			  "headers": {
			    "token": '<?php echo $_SESSION['token']; ?>'
			  },
			  "processData": false,
			  "contentType": false,
			  "mimeType": "multipart/form-data",
			  "data": form
			}

			$.ajax(settings).done(function (response) {
				$('input[name="info[consultorio][nome]"]').val('');
				$('input[name="info[consultorio][endereco]"]').val('');
				$('input[name="info[consultorio][numero]"]').val('');
				$('input[name="info[consultorio][bairro]"]').val('');
				$('input[name="info[consultorio][cep]"]').val('');

				$('.formNovoConsul').fadeOut('slow');
				window.location.replace("http://projetos.wdezoito.com.br:82/listamed/perfil/3/edit");
			});
		}else{
			alert("Preencha todas as informações");
		}
	});
	
	$('.estadoNovoConsul').on('change', function() {
		var estado = $(this).val();
		if(estado != '-'){
			var url = "http://projetos.wdezoito.com.br:82/listamed-back/dev2/cidade/estado/"+estado;
			jQuery.getJSON(url, function(json, textStatus) {
				$('.cidadeNovoConsul').find('option').remove().end().append('<option value="-">Selecione uma cidade</option>').val('-');
				jQuery.each(json.data , function(index, value){
					$('.cidadeNovoConsul').append($('<option>', { 
				        value: value.id,
				        text : value.nome 
				    }));
				});
			});
		}
	});

	$(".btnEdit.EditEsp").click(function(){
		var especialidadeSelecionada = $('.especialidadeMedico option:selected').val();
		var codigoMedico = <?php echo $_SESSION['id']; ?>;

		var settings = {
		  "async": true,
		  "crossDomain": true,
		  "url": "http://projetos.wdezoito.com.br:82/listamed-back/dev2/medico/especialidade/",
		  "method": "POST",
		  "headers": {
		    "token": "<?php echo $token; ?>"
		  },
		  "data": {
		    "especialidade": especialidadeSelecionada,
		    "medico": codigoMedico
		  }
		}

		$.ajax(settings).done(function (response) {
			id = $('.especialidadeMedico option:selected').val();
			text = $('.especialidadeMedico option:selected').text();
			if(response==="\"ok\""){
				$('.listEspecialidadeMedico').append($('<li>', { 
			        rel: id,
			        text : text
			    }));
				$('li[rel='+id+']').append($('<span>', { 
					onclick: 'removerEspecialidade('+id+')',
					html: '[remover]'
				}));
			}else{
				alert("especialidade já cadastrada.");
			}
		});
	});

});
</script>
<style>
	input {
	    border: 1px solid #f2f2f2;
	    font-size: 14px;
	    padding: 10px;
	}
	.btnSalvar{
	    color: #fff;
	    height: 37px;
	    background-color: #f88d0d;
	}
	.consultorioP{
		margin: -50px 0 0 0 !important;
	}
	.consultorioTitulo{
	    float: left;
	    margin: -28px 12px;
	    width: 320px;
	}
	.excluirConsultorio{
		cursor: pointer;
	}
	.medico-exp--text{
		float: left;
		width: 160px;
	}
	.btnNovoConsul{
	    background-color: #01abeb;
	    padding: 10px 20px;
	    color: white;
	    cursor: pointer;
	}
	.btnEdit{
	    background-color: #01abeb;
	    padding: 10px 20px;
	    color: white;
	    cursor: pointer;
	}
	.btnEdit.EditEsp{
	    padding: 8px 15px;
	    float: right;
	    margin: -3px 0;
	}

	.btnSalvarConsul{
	    background-color: #01abeb;
	    padding: 10px 20px;
	    color: white;
	    cursor: pointer;
	}
	select {
	    border: 1px solid #f2f2f2;
	    font-size: 14px;
	    padding: 10px;
	    margin: -5px 0px;
	    max-width: 178px;
	}
	.redeTitulo {
		font-size: 13px;
	}
	.formNovoConsul {
		display: none;
	}
	.btnCursor{
		cursor: pointer;
	}
</style>