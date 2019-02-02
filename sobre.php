<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php
	require_once('config.php');
	$url = "https://www.listamed.com.br/gerenciar/upload/pagina/";
	$conteudo =	json_decode(file_get_contents("http://listamed.com.br/api/page", false, stream_context_create($arrContextOptions)));
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
	<div class="page page-sobre" id="listamed-sobre">
		<div class="page-nav scrolling" id="listamed-nav">
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
	    	<div class="container-fluid">
	    		<div class="row">
	    			<div class="col-xs-12 col-sm-5 col-md-6 col-lg-6 page-sobre-bg" id="listamed-sobre-bg-control" style="background-image: url('<?php echo $url.$conteudo->sobre_imagem; ?>');"></div>
	    			<div class="col-xs-12 col-sm-7 col-md-6 col-lg-6">
	    				<div class="page-sobre-content" id="listamed-sobre-content-control">
	    					<?php echo $conteudo->sobre_texto; ?>	    					
		    				<?php
								if( ($_SERVER['HTTP_REFERER']=="https://listamed.com.br/seja")||($_SERVER['HTTP_REFERER']=="https://listamed.com.br/sobre")||($_SERVER['HTTP_REFERER']=="https://listamed.com.br/perguntas-frequentes")):
									$link = '/seja';
								else:
									$link = '/';
								endif;
							?>
							<div class="text-right">
								<a href="<?php echo $link; ?>" class="btn btn-theme-blue--borded">Voltar para a home</a>							
							</div>
	    				</div>
	    			</div>
	    		</div>
	    	</div>
	    </div>
	    <?php include 'footer-pages.php'; ?>
	</div>
	<script src="/js/jquery-1.12.4.min.js"></script>
    <script src="<?php echo $caminho; ?>js/champs.min.js"></script>
    </body>
</html>
<style type="text/css">
.sobre-continer--text p {
    line-height: 26px !important;
}
</style>