<?php
	require_once("config.php");
	if($_POST['txtPesq']!=""):
		$conteudo =	json_decode(file_get_contents("http://listamed.com.br/api/pergunta/".$_POST['txtPesq'], false, stream_context_create($arrContextOptions)));
	else:
		$conteudo =	json_decode(file_get_contents("http://listamed.com.br/api/pergunta", false, stream_context_create($arrContextOptions)));
	endif;
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Perguntas Frequentes - ListaMED</title>
        <meta title="Perguntas Frequentes - ListaMED">
        <meta description="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> 
        <link rel="stylesheet" type="text/css" href="./css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="./images/favicon/favicon-96x96.png">
    </head>
<body>
	<div class="page page-faq" id="listamed-faq">
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
			<div class="faq">
				<div class="faq-container container">
					<h2>Perguntas Frequentes</h2>					
					<div class="faq-search">
						<form class="faq-search-form" action="" method="post" > 
							<fieldset>
								<legend class="sr-only">Pesquise nas perguntas frequentes</legend>		
								<div class="input-group">
									<input class="form-control" type="text" name="txtPesq" placeholder="Pesquisar" required/>
									<div class="input-group-btn">
										<button class="btn btn-theme-blue--transparent">
											<i class="fa fa-search"></i>
										</button>
									</div>
								</div>
							</fieldset>
						</form>		
						<?php if($_POST['txtPesq']!=""): ?>
							<div class="faq-search-find">
								<p>Buscando por: <?php echo $_POST['txtPesq']; ?></p>
								<a href="faq.php">x limpar pesquisa</a>
							</div>
						<?php endif; ?>					
					</div>
					<div class="faq-result">
						<ul class="faq-result-list list list-items--block"> 
							<?php if (count((array)$conteudo)>0): ?>
								<?php foreach ($conteudo as $kCont => $vCont) : ?>
									<li class="list--item">
										<div class="row container-fluid">
											<div class="question">
												<h3 class="faq-action" data-action="open">
													<i class="fa fa-caret-right"></i>
													<?php echo $vCont->pergunta ?>
												</h3>
												<p><?php echo $vCont->resposta ?></p>
											</div>											
										</div>
									</li>
								<?php endforeach; ?>
							<?php else: ?>
								<li class="list--item">Nenhuma pergunta encontrada com <?php echo $_POST['txtPesq']; ?>
							<?php endif; ?>
						</ul>
					</div>
					<div class="faq-buttons">
						<a href="/contato" class="btn btn-theme-blue--borded">
							Fale Conosco
						</a>
						<?php
							if( ($_SERVER['HTTP_REFERER']=="https://listamed.com.br/seja")||($_SERVER['HTTP_REFERER']=="https://listamed.com.br/sobre")||($_SERVER['HTTP_REFERER']=="https://listamed.com.br/perguntas-frequentes")):
								$link = '/seja';
							else:
								$link = '/';
							endif;
						?>
						<a href="<?php echo $link; ?>" class="btn btn-theme-blue--borded">
							Voltar para a Home
						</a>
					</div>					
				</div>
			</div>	
		</div>
		<?php include 'footer-pages.php'; ?>
		<div class="page-modals">
			<?php //include 'modal-form.php'; ?>			
		</div>
	</div>
	<script src="/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo $caminho; ?>js/champs.min.js"></script>
    <script src="<?php echo $caminho; ?>js/ouibounce.js"></script>
    <script src="<?php echo $caminho; ?>js/script.js"></script>
    </body>
</html>