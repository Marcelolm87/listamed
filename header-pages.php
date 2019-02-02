<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta title="">
        <meta description="">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo $caminho ?>css/champs.min.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $caminho; ?>css/estilo.css">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $caminho ?>images/favicon/favicon-96x96.png">
    </head>
<body>
    <!-- DESKTOP -->
	<div class="header-pages--border mobile-hide tablet-hide">
    </div>
    <div class="header-pages mobile-hide tablet-hide contato-bkg">
        <div class="page-home--section col-lg-12 row center container">
            <div class="page-home--container">
                <div class="col-lg-2 col-md-2">
                    <h1 class="logo left logo-align">
                        <a href="<?php echo $caminho; ?>"><img src="<?php echo $caminho ?>images/logo-internas-top.png" /></a>
                    </h1>
                </div>
            </div>
            <div class="page-home--list right lato-regular">
            	<nav>
            		<ul>
                        <li><a href="<?php echo $caminho ?>sobre" id="sobre">Sobre a ListaMed</a></li>
                        <li><a href="<?php echo $caminho ?>seja" id="seja">Seja Lista Med</a></li>
                        <li><a href="<?php echo $caminho ?>perguntas-frequentes" id="faq">Perguntas Frequentes</a></li>
                        <li><a href="<?php echo $caminho ?>blog" id="blog" target="_blank">Blog</a></li>
                        <li><a href="<?php echo $caminho ?>contato" id="contato">Contato</a></li>
            		</ul>
            	</nav>
            </div>
        </div>
    </div>
    <!-- //DESKTOP -->
    <!-- MOBILE -->
    <div class="header-pages--border--mobile notebook-hide desktop-hide tablet-show mobile-show">
        <div class="row">
            <div class="right">
                <div class="menu">
                    <div class="left container col-xs-6 logo">
                        <a href="<?php echo $caminho; ?>"><img src="<?php echo $caminho ?>images/logo-internas-top.png" /></a>
                    </div>
                    <div class="icon-menu right col-xs-6" id="open-menu">
                        <s class="bar"></s>
                        <s class="bar"></s>
                        <s class="bar"></s>
                    </div>
                </div>
                <div class="sidebar" id="close-menu">
                    <nav class="nav-menu">
                        <ul>
                            <li><a href="<?php echo $caminho ?>sobre" id="sobre">Sobre a ListaMed</a></li>
                            <li><a href="<?php echo $caminho ?>seja" id="seja-mobile">Seja Lista Med</a></li>
                            <li><a href="<?php echo $caminho ?>perguntas-frequentes" id="faq">Perguntas Frequentes</a></li>
                            <li><a href="<?php echo $caminho ?>blog" id="blog">Blog</a></li>
                            <li><a href="<?php echo $caminho ?>contato" id="contato">Contato</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- //MOBILE -->


<?php /*if(is_page('seja')): ?>
    <script>
        document.getElementsByClassName("header-pages")[0].classList.add("page-bg--seja");
        document.getElementById("seja").setAttribute("class","active");
    </script>
     <?php //else: ?>
            <?php //if(is_page('contato')): ?>
                <script>
                    document.getElementById("contato").setAttribute("class","active");
                </script>
            <?php //else: ?>
                <?php //if(is_page('faq')): ?>
                    <script>
                        document.getElementById("faq").setAttribute("class","active");
                    </script>
                <?php //else: ?>
                    <?php //if(is_page('sobre')): ?>
                        <script>
                            document.getElementById("sobre").setAttribute("class","active");
                        </script>
                    <?php //endif; ?>
                <?php //endif; ?>
            <?php //endif; ?>
<?php endif; */ ?>
