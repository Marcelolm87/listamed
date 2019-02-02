<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> 
<html class="no-js"> 
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Raro! Boilerplate</title>
    <meta name="description" content="Raro! Boilerplate, padrões de css e javascript para projetos internos.">
    <meta name="viewport" content="width=device-width, initial-scale=1">
       
    <!-- Css -->
    <link rel="stylesheet" type="text/css" href="css/champs.min.css">

    <script type="text/javascript" src="js/modernizr-2.6.2.min.js"></script>

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
</head>
<body>
    <!--[if lt IE 7]>
       	<p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->

    <nav class="container-fluid left demo-nav nav">
        <div class="container center">
            <h1 class="left logo">
                <a class="logo-lk" href="#">
                    Champs
                </a>
            </h1>
            <div class="right menu">
                <ul class="menu-ls-h">
                    <li class="menu-ls-item"><a class="menu-ls-lk" href="#">Introdução</a></li>
                    <li class="menu-ls-item"><a class="menu-ls-lk" href="componentes.php">Componentes</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <header class="container-fluid left demo-header outdoor">
        <div class="container center">
            <h2 class="typo-h-1 title">Componentes</h2>
            <div class="row">
                <p>Aqui você encontra todos os componentes que estão nesse framework.</p>
            </div>
            <a href="#" class="btn btn-primary">Download Champs</a>        
        </div>
    </header>
    <div class="container-fluid left demo-main">
        <div class="container center">



	<div class="col-xs-12 col-md-8 col-lg-9">
		<div class="row">
			<div class="layout-header"id="typograph">
				<h2 class="typo-h-1 layout-header-hl">Tipografia</h2>
				<p class="layout-header-sub">Nossa parte de <b>tipografia</b> foi voltada para títulos, sub títulos, cabeçários e textos.</p>
			</div>
			<div class="row" id="typograph-headline">
				<h3 class="typo-h-3">Headline</h3>
				<p>	
					Pode usar a tag <span class="markup">h1</span>, <span class="markup">h2</span>, <span class="markup">h3</span>, <span class="markup">h4</span>, etc. 
					Se não quiser usar as tag, você pode usar a classe <span class="markup">.typo-h-*</span> e o tamanha de 1 a 6.
				</p>
				<div class="demo-example">
					<span class="typo-display-b typo-h-1">h1 Headline</span>
					<span class="typo-display-b typo-h-2">h2 Headline</span>
					<span class="typo-display-b typo-h-3">h3 Headline</span>
					<span class="typo-display-b typo-h-4">h4 Headline</span>
					<span class="typo-display-b typo-h-5">h5 Headline</span>
					<span class="typo-display-b typo-h-6">h6 Headline</span>
				</div>
				
			</div>

			<div class="row" id="typograph-paragraph">
				<h3 class="typo-h-3">Parágrafo</h3>
				<p>	
					Nos parágrafos pode usar a tag <span class="markup">p</span> ou usar a classe <span class="markup">.typo-p</span>.
				</p>
				<div class="demo-example">
					<span class="typo-display-b typo-p">Este é um exemplo de parágrafo.</span>
				</div>				
			</div>

			<div class="row" id="typograph-blockquote">
				<h3 class="typo-h-3">Blockquote</h3>
				<p>	
					Pode fazer um blockquote basta usar a classe <span class="markup">.blockquote</span>.
				</p>
				<div class="demo-example">
					<blockquote class="blockquote">
						<p>Este é um exemplo de blockquote.</p>
						<footer>Sitação feita por <cite>Enrique Prieto</cite></footer>
					</blockquote>
				</div>
				<h3 class="typo-h-3">Blockquote Reverse</h3>
				<p>	
					Para que o <span class="markup">blockquote</span> fique no sentido a direita basta usar a classe <span class="markup">.blockquote-reverse</span>.
				</p>
				<div class="demo-example">
					<blockquote class="blockquote-reverse">
						<p>Este é um exemplo de blockquote reverse.</p>
						<footer>Sitação feita por <cite>Enrique Prieto</cite></footer>
					</blockquote>
				</div>					
			</div>			
		</div>

		<div class="row" id="table">
			<div class="layout-header">
				<h2 class="layout-header-hl typo-h-1">Table</h2>
			</div>
			<h3 class="typo-h-3">Padrão</h3>
			<p>Para que sua tabela siga as pré definições basta adicionar a classe <span class="markup">.table</span>.</p>
			<div class="demo-example">
				<table class="table">
					<thead>
						<tr>
							<td>#</td>
							<td>Nome</td>
							<td>Sobrenome</td>
							<td>Login</td>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>1</td>
							<td>Enrique</td>
							<td>Prieto</td>
							<td>@enriqueprieto</td>
						</tr>
						<tr>
							<td>2</td>
							<td>Fabiano</td>
							<td>Sodate</td>
							<td>@fabianosodate</td>
						</tr>
						<tr>
							<td>3</td>
							<td>Marcelo</td>
							<td>Lauton</td>
							<td>@marcelolauton</td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="row" id="table-border">
				<h3 class="typo-h-3">Border</h3>
				<p>Para que sua tabela fique com bordar no layout adicione a classe <span class="markup">.table</span> e a classe <span class="markup">.table-border</span>.</p>
				<div class="demo-example">
					<table class="table table-border">
						<thead>
							<tr>
								<td>#</td>
								<td>Nome</td>
								<td>Sobrenome</td>
								<td>Login</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Enrique</td>
								<td>Prieto</td>
								<td>@enriqueprieto</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Fabiano</td>
								<td>Sodate</td>
								<td>@fabianosodate</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Marcelo</td>
								<td>Lauton</td>
								<td>@marcelolauton</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row" id="table-hover">
				<h3 class="typo-h-3">Hover</h3>
				<p>Para que sua tabela fique com efeito hover em cada linha basta adicionar a classe <span class="markup">.table</span> e a classe <span class="markup">.table-hover</span>.</p>
				<div class="demo-example">
					<table class="table table-hover">
						<thead>
							<tr>
								<td>#</td>
								<td>Nome</td>
								<td>Sobrenome</td>
								<td>Login</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Enrique</td>
								<td>Prieto</td>
								<td>@enriqueprieto</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Fabiano</td>
								<td>Sodate</td>
								<td>@fabianosodate</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Marcelo</td>
								<td>Lauton</td>
								<td>@marcelolauton</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="row" id="table-striped">
				<h3 class="typo-h-3">Striped</h3>
				<p>Para que sua tabela fique com variação de estilo de uma linha para outra adicione a classe <span class="markup">.table</span> e a classe <span class="markup">.table-striped</span>.</p>
				<div class="demo-example">
					<table class="table table-striped">
						<thead>
							<tr>
								<td>#</td>
								<td>Nome</td>
								<td>Sobrenome</td>
								<td>Login</td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>1</td>
								<td>Enrique</td>
								<td>Prieto</td>
								<td>@enriqueprieto</td>
							</tr>
							<tr>
								<td>2</td>
								<td>Fabiano</td>
								<td>Sodate</td>
								<td>@fabianosodate</td>
							</tr>
							<tr>
								<td>3</td>
								<td>Marcelo</td>
								<td>Lauton</td>
								<td>@marcelolauton</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>

		<!-- List -->
		<div class="row" id="list">
			<div class="layout-header">
				<h2 class="typo-h-1 layout-header-hl">Lista</h2>
			</div>
			<div class="row" id="list-nostyle">
				<h3 class="typo-h-3">No style</h3>
				<p>Pra deixar as lista sem o estilo pro primeiro nível da lista é só adicionar a classe <span class="markup">.list-nostyle</span>.</p>
				<div class="demo-example">
					<ul class="list-nostyle">
						<li>Exemplo</li>
						<li>Exemplo</li>
						<li>
							Exemplo
							<ul>
								<li>Exemplo</li>
								<li>Exemplo</li>
								<li>Exemplo</li>
							</ul>
						</li>
						<li>Exemplo</li>
					</ul>
				</div>
			</div>
			<div class="row" id="list-inline">
				<h3 class="typo-h-3">Inline</h3>
				<p>Pra deixar as lista no sentido horizontal basta adicionar a classe <span class="markup">.list-inline</span>.</p>
				<div class="demo-example">
					<ul class="list-inline">
						<li>Exemplo</li>
						<li>Exemplo</li>
						<li>Exemplo</li>
						<li>Exemplo</li>
					</ul>
				</div>
			</div>
		</div>

		<!-- Form -->
		<div class="row" id="form">
			<div class="layout-header">
				<h2 class="typo-h-1 layout-header-hl">Formulários</h2>
			</div>
			<div class="row" id="form-mask">
				<h3 class="typo-h-3">Máscara</h3>
				<p>
					Pra adicionar um tipo de dado no <span class="markup">input</span> basta usar a classe <span class="markup">.form-mask-js</span> e adicionar o tipo com o 
					<span class="markup">data-mask="valor"</span> e tem as opção  <span class="markup">celular</span>, <span class="markup">telefone</span>, 
					<span class="markup">data</span>, <span class="markup">cpf</span>, <span class="markup">cnpj</span>.
				</p>
				<div class="demo-example form-example">
					<div class="row">
						<label class="row">Exemplo <span class="markup">celular</span></label>
						<input type="text" class="form-mask-js" data-mask="celular">
					</div>
					<div class="row">
						<label class="row">Exemplo <span class="markup">telefone</span></label>
						<input type="text" class="form-mask-js" data-mask="telefone">
					</div>
					<div class="row">
						<label class="row">Exemplo <span class="markup">data</span></label>
						<input type="text" class="form-mask-js" data-mask="data">
					</div>
					<div class="row">
						<label class="row">Exemplo <span class="markup">cpf</span></label>
						<input type="text" class="form-mask-js" data-mask="cpf">
					</div>
					<div class="row">
						<label class="row">Exemplo <span class="markup">cnpj</span></label>
						<input type="text" class="form-mask-js" data-mask="cnpj">
					</div>
				</div>
			</div>
			<div class="row" id="form-dropdown">
				<h3 class="typo-h-3">Dropdown</h3>
				<p>
					Pra adicionar um tipo de dado no <span class="markup">input</span> basta usar a classe <span class="markup">.form-mask-js</span> e adicionar o tipo com o 
					<span class="markup">data-mask="valor"</span> e tem as opção  <span class="markup">celular</span>, <span class="markup">telefone</span>, 
					<span class="markup">data</span>, <span class="markup">cpf</span>, <span class="markup">cnpj</span>.
				</p>
				<div class="demo-example form-example">
					<div class="row form-dropdown-local">
						<select type="text" class="form-dropdown-js form-dropdown-local-city"></select>
						<select type="text" class="form-dropdown-js form-dropdown-local-state"></select> 
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="col-md-4 col-lg-3">
		<div class="row demo-sidebar">
			<ul class="list-nostyle demo-sidebar-nav">
				<li><a href="#">Ir para o topo</a></li>
				<li>
					<a href="#typograph">Tipografia</a>
					<ul>
						<li><a href="#typograph-headline">Headline</a></li>
						<li><a href="#typograph-paragraph">Parágrafo</a></li>
						<li><a href="#typograph-blockquote">Blockquote</a></li>
					</ul>
				</li>
				<li>
					<a href="#table">Table</a>
					<ul>
						<li><a href="#table-border">Border</a></li>
						<li><a href="#table-hover">Hover</a></li>
						<li><a href="#table-striped">Striped</a></li>
					</ul>
				</li>
				<li>
					<a href="#list">Lista</a>
					<ul>
						<li><a href="#list-nostyle">No Style</a></li>
						<li><a href="#list-inline">Inline</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	
<?php include 'footer.php'; ?>