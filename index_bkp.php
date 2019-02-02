<!DOCTYPE html>
<html>
<head>
	<title></title>
		<meta charset="utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('template_directory'); ?>/css/champs.min.css">
        <!--[if lt IE 8]>
        	<script type="text/javascript" src="js/html5shiv.min.js"></script>
        <![endif]-->
</head>
<body>
	<div class="page-bg page-bg--index layout-control--js layout-height--full layout-container--center ">
		<div class="row text-center comp-selec-cidade mobile-hide tablet-hide">
			<div class="comp-selec-center">
				<div class="comp-selec-text">
					<p>			
						Olá, você deseja encontrar profissionais em <strong>Presidente Prudente, SP</strong> ?
					</p>
				</div>
				<div class="comp-selec-pesq">
					<a href="http://projetos.wdezoito.com.br:82/listamed/medicos"><button class="btn">Sim</button></a>
					<select>
						<option>Outra</option>
					</select>
				</div>
			</div>
		</div>
		<div class="layout-container container">
			<section class="page-home--section col-lg-12 col-xs-12 col-sm-10 center col-md-10">
				<div class="row text-center page-home--container">
					<h1 class="logo">
						<a href="http://projetos.wdezoito.com.br:82/listamed"><img src="<?php bloginfo('template_directory'); ?>/images/logo.png" /></a>
					</h1>
					<p>Encontre um profissional e agende sua pré-consulta</p>
					<div class="page-home--container-form col-lg-10 center row col-md-12 col-sm-12">
						<form>
							<div class="col-lg-6 form-field col-xs-11 col-md-5 col-sm-12 col-md-12">
								<select class="mobile-hide notebook-hide">
									<option placeholder="Busque por médico, nome, clínica ou especialidade" disabled selected>Busque por médico, nome, clínica ou especialidade</option>
								</select>
								<select class="mobile-show notebook-show">
									<option placeholder="Médico, nome, clínica ou especialidade" disabled selected>Médico, nome, clínica ou especialidade</option>
								</select>
							</div>
							<div class="col-lg-4 form-field col-xs-11 col-md-5 col-sm-12 col-md-12">
								<select>
									<option placeholder="Cidade" disabled selected>Cidade</option>
								</select>
							</div>
							<div class="col-lg-1 form-field col-xs-11 col-md-1 row col-sm-12 col-md-12">
								<a href="http://projetos.wdezoito.com.br:82/listamed/medicos"><button class="btn">BUSCAR</button></a>
							</div>
						</form>
						<div class="row col-lg-5 center col-xs-8">
							<p>Sou um profissional da área e quero me <a href="#">cadastrar</a></p>
						</div>
					</div>
				</div>
			</section>
		</div>	
	</div>
	<footer class="row page-footer">
		<div class="row page-footer--cinza">
			<div class="container center">
				<div class="col-lg-2 mobile-hide tablet-hide">
					<a href="#">Sou profissional da área</a>
				</div>
				<div class="right mobile-hide tablet-hide">
					<nav class="nav-footer">
						<ul>
							<li><a href="#">Contato</a></li>
							<li><a href="#">Perguntas Frequentes</a></li>
							<li><a href="#">Sobre a ListaMed</a></li>
						</ul>
					</nav>
				</div>
			</div>
			<div class="container mobile-show tablet-show">
				<nav class="nav-footer index-mobile text-center">
					<ul>
						<li><a href="#">Contato</a></li>
						<li><a href="#">Perguntas Frequentes</a></li>
						<li><a href="#">Sobre a ListaMed</a></li>
					</ul>
				</nav>
			</div>
		</div>
		<div class="row page-footer--branco">
			<div class="container center">
				<div class="col-lg-1">
					<a href="http://projetos.wdezoito.com.br:82/listamed"><img src="<?php bloginfo('template_directory'); ?>/images/logo-footer.png" /></a>
				</div>
				<div class="right social-icons-align">
					<a href=""><i class="fa fa-twitter-square" aria-hidden="true"></i></a>
					<a href=""><i class="fa fa-facebook-square" aria-hidden="true"></i></a>
				</div>
			</div>
		</div>					
		<div class="row page-footer--escuro">
			<div class="container center">
				<div class="col-lg-4 page-footer--copyright mobile-hide tablet-hide">
					<p>TODOS OS DIREITOS RESERVADOS - LISTAMED 2016 ®</p>
				</div>
				<div class="col-lg-4 page-footer--copyright center mobile-show tablet-show">
					<p>TODOS OS DIREITOS RESERVADOS - LISTAMED 2016 ®</p>
				</div>
				<div class="right page-footer--dev mobile-hide tablet-hide">
					<p>Feito por 
						<a href="http://www.wdezoito.com.br/"><img src="<?php bloginfo('template_directory'); ?>/images/logo-w18.png" /></a>
					</p>
				</div>
				<div class="page-footer--dev mobile-show tablet-show center">
					<p>Feito por 
						<a href="http://www.wdezoito.com.br/"><img src="<?php bloginfo('template_directory'); ?>/images/logo-w18.png" /></a>
					</p>
				</div>
			</div>
		</div>
	</footer>
    <script src="/js/jquery-1.12.4.min.js"></script>
 	<script src="<?php bloginfo('template_directory'); ?>/js/champs.min.js"></script>
</body>
</html>