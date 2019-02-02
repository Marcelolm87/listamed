<?php header("Content-type: text/html; charset=utf-8"); require_once("config.php"); ?>
<?php
	$url = "http://www.listamed.com.br/gerenciar/upload/pagina/";
	$conteudo =	json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions)));


	foreach ($conteudo->destaques as $k => $v) :
		$exibir[$v->id]['id'] = $v->id;
		$exibir[$v->id]['nome'] = $v->nome;
		$exibir[$v->id]['imagem'] = $v->imagem;
		$exibir[$v->id]['especilidade'] .= $v->especialidade.' | ';
		$exibir[$v->id]['depoimento'] = $v->depoimento;
	endforeach;
	shuffle($exibir);

	if(isset($_POST['emailInfo'])!=""){
		$emailListamed = "marcelolauton@wdezoito.com.br";

		// incluindo classes do sendgrid
		require 'sendgrid/vendor/autoload.php';
		$apiKey = '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';
		$sg = new \SendGrid($apiKey);

		// preparando e-mail para envio
		$from = new SendGrid\Email(null, "confirmacao@listamed.com.br");
//		$from = new SendGrid\Email(null, "transacional@listamed.com.br");
		$subject = "Interesse!";
		$to = new SendGrid\Email(null, $emailListamed);

		// formatando informações para envio
		$textoEmail.= "<strong>E-mail: </strong>".$_POST['emailInfo']."<br/>";

		// enviando o email
		$content = new SendGrid\Content("text/html", $textoEmail);
		$mail = new SendGrid\Mail($from, $subject, $to, $content);
		$response = $sg->client->mail()->send()->post($mail);
	
	}
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Faça parte do ListaMED</title>
        <meta title="Faça parte do ListaMED">
        <meta description="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="./css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="./images/favicon/favicon-96x96.png">
    </head>
<body>
	<div class="page page-seja" id="listamed-seja">
	    <div class="page-nav" id="listamed-nav">
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
		    <div id="listamed-cover" class="page-cover page-bg" style="background-image: url('<?php echo $url.$conteudo->banner_imagem; ?>');">
		        <div class="container">
		        	<div class="page-seja-block">
			        	<h2 class="page-cover--title"><?php echo $conteudo->banner_titulo; ?></h2>
		        		<div class="page-cover--desc">
							<p><?php echo $conteudo->banner_desc; ?></p>
		        		</div>
		        		<a href="<?php echo $conteudo->banner_link; ?>" class="btn btn-theme-blue">Vamos lá ?</a>
		        	</div>	        	
		        </div>
		    </div>
		    <div class="page-section page-seja-video">
		    	<iframe width="560" height="315" src="https://www.youtube.com/embed/MbIyE7PmUmQ" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
		    </div>
		    <div class="page-section">
			    <div class="page-seja-medicos">
		    		<div class="container text-center">
		    			<div class="page-seja-medicos--header">
				    		<h2><?php echo $conteudo->conteudo_titulo; ?></h2>
				    		<p><?php echo $conteudo->conteudo_texto; ?></p>
		    			</div>
		    			<div class="page-seja-medicos-list">
		    				<div class="row">
			    				<?php
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
								    $count = 0;
								    foreach ($exibir as $key => $v):
								    	$count++;
								    	if($count<=3):
							    ?>
					    			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
					    				<div class="medico">
					    					<a class="medico-foto" target="_blank" href="<?php echo $caminho."profissional/".$v['id']."/".slug($v['nome']); ?>">
					    						<span>
					    							<img src="http://www.listamed.com.br//gerenciar/upload/profissionais/<?php echo $v['imagem']; ?>">							    							
					    						</span>
					    					</a>
						    				<h3 class="medico-nome">
							    				<a target="_blank" href="<?php echo $caminho."profissional/".$v['id']."/".slug($v['nome']); ?>">
							    					<?php echo $v['nome']; ?>
							    				</a>
						    				</h3>
							    			<p class="medico-especialidade">
							    				<span><?php echo substr( $v['especilidade'], 0, -3); ?></span>
							    			</p>
											<div class="medico-depoimento">
					    						<p>
							    					<?php echo $v['depoimento']; ?>
					    						</p>
						    				</div>
						    			</div>
					    			</div>
					    		<?php 
					    				endif; 
					    			endforeach; 
					    		?>
		    				</div>
		    			</div>
			    	</div>
			</div>
			<div class="page-section">
				<div class="page-seja-planos">
			    	<div class="container text-center">
			    		<h2 class="sr-only">Nossos Planos</h2>
			    		<div class="row page-seja-planos-list ">
			    			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
	    						<div class="plano">
	    							<div class="plano-card">
	    								<div class="plano-card-header">
	    									<img src="./images/icon-1.png">
		    								<h3>Profissionais</h3>	    									
	    								</div>
	    								<p class="plano-price">
	    									<strong>R$</strong>119<strong>,00</strong>
	    								</p>
	    								<div class="plano-details">
	    									<?php echo $conteudo->planos_texto1; ?>	    									
	    								</div>
	    								<a href="/cadastro" class="btn btn-block btn-theme-blue--borded">Começar Já</a>
	    							</div>
	    						</div>		    				
			    			</div>
			    			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			    				<div class="plano">
	    							<div class="plano-card">
	    								<div class="plano-card-header">
	    									<img src="./images/icon-2.png">
		    								<h3>Centro Médico</h3>	    									
	    								</div>
	    								<p class="plano-price">
	    									<strong>Consulte</strong>
	    								</p>
	    								<div class="plano-details">
	    									<?php echo $conteudo->planos_texto2; ?>	    									
	    								</div>
	    								<a href="/contato?centro-medico=ok" class="btn btn-block btn-theme-blue--borded">Começar Já</a>
	    							</div>
	    						</div>
			    			</div>
			    		</div>
			    	</div>				
				</div>
			</div>
			<div class="page-section">
				<div class="page-seja-call">
					<div class="container">
						<h2><?php echo $conteudo->conteudo_rodape; ?></h2>
			    		<button type="button" data-toggle="modal" data-target="#listamed-modal-ligar" class="btn btn-theme-blue--borded">Ligar para mim</button>
					</div>	
				</div>
			</div>	
		</div>
		<?php include 'footer-pages.php'; ?>
		<div class="page-modals">
			<?php include 'modal-form.php'; ?>			
		</div>
	</div>
	<script type="text/javascript">
	   /* jQuery(document).ready(function($) {
	    	$('.btnSubmit').click(function(){
	    		$('.formPagSeguro').submit();
	    	});

			$(".ModalFormSair").on('click', function(){
				var modalExists = new Modal(),
				cloneExists = $(".ModalFormSair").clone();
				modalExists.setContainer(cloneExists[0]);
				modalExists.setClassModal("fade-in");
				modalExists.setClassModal("modal-exists");
				modalExists.setClassModalContainer("open");
				modalExists.setClassModalContainer("center");
				modalExists.setClassModalContainer("col-lg-3");
				modalExists.setClassModalContainer("col-xs-10");
				modalExists.setClassModalContainer("col-sm-6");
				modalExists.showModal();
			});

			var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
				aggressive: true,
				timer: 0,
				callback: function() {
					$(".ModalFormSair").click();
					_ouibounce.disable();
				}
			});

				/*$('body').on('click', function() {
					$('#ouibounce-modal').hide();
				});
				$('#ouibounce-modal .modal-footer').on('click', function() {
					$('#ouibounce-modal').hide();
				});
				$('#ouibounce-modal .modal').on('click', function(e) {
					e.stopPropagation();
				});*/
	    //});
	</script>

<div id="ModalFormSair" class="ModalFormSair modal-block--perfil">
	<div class="col-lg-12 text-center center">
		<div class="perfil-title">
			<p><h3 style="color:#01abeb;">Receba mais informações sobre o Listamed</h3></p>
		</div>
		<div class="perfil-content">
			<form id="formClose" action="#" method="POST">
				<input type="text" id="emailInfo" value="" name="emailInfo" placeholder="E-mail" >
				<input type="submit" id="btnEnviar" name="btnEnviar" value="Enviar" >
			</form>
		</div>
	</div>
</div>
<!-- <div id="ouibounce-modal" style="display:none">
	<div class="modal">
		<div class="modalConteudo container center">
			<div class="modal-title">
				<h3 style="color:#01abeb;">Receba mais informações sobre o LISTAMED!</h3>
			</div>

			<div class="modal-body">
				<form id="formClose" action="#" method="POST">
					<input type="text" id="emailInfo"  name="emailInfo" placeholder="E-mail" >
					<input type="button" onclick="enviarForm()" id="btnEnviar" name="btnEnviar" value="Enviar" >
				</form>
			</div>
			
			<div class="modal-footer">
				<p style="cursor: pointer;"><i class="fa fa-times" aria-hidden="true"></i> Fechar</p>
			</div>
		</div>
	</div>
</div> -->
	<script src="/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo $caminho; ?>js/champs.min.js"></script>
    <script src="<?php echo $caminho; ?>js/ouibounce.js"></script>
    <script src="<?php echo $caminho; ?>js/script.js"></script>
    <!--CHAT-->
        <!--Start of Zendesk Chat Script-->
        <script type="text/javascript">
        window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
        d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
        _.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
        $.src="https://v2.zopim.com/?575BQqZ3NMbzKkeViOuFfFRLXADIqnsx";z.t=+new Date;$.
        type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");
        </script>
        <!--End of Zendesk Chat Script-->
    <!--//CHAT-->
    </body>
</html>