<?php include("verificar.php"); ?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="Marcelo Lauton" />
    <meta name="robots" content="noindex">
    <title>Lista Med!</title>
    <link href="https://listamed.com.br/gerenciar/assets/css/bootstrap.css" rel="stylesheet" />
    <link href="https://listamed.com.br/gerenciar/assets/css/font-awesome.css" rel="stylesheet" />
    <link href="https://listamed.com.br/gerenciar/assets/css/style.css" rel="stylesheet" />
    <link href="https://listamed.com.br/gerenciar/css/jquery-ui.min.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="https://listamed.com.br/gerenciar/css/jquery.datetimepicker.min.css"/ >
    <link rel="stylesheet" type="text/css" href="https://listamed.com.br/gerenciar/css/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://listamed.com.br/gerenciar/css/croppie.css"/>
    <link rel="stylesheet" type="text/css" href="https://listamed.com.br/gerenciar/css/bootstrap-datepicker.min.css"/>
    <link href="https://listamed.com.br/gerenciar/css/estilo.css" rel="stylesheet" />
</head>
<body>
<?php
    function saldoSMS(){
        $ch      = curl_init();
        $timeout = 10; // set to zero for no timeout
        $url   = "http://api.allcancesms.com.br/account/1/balance";
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        
        $request_headers = array();
        $request_headers[] = "Authorization: Basic VEVNTk9USUNJQTppZW5rbU50Rw==";

        
        $request_headers[] = "Content-Type: application/json" ;
        $request_headers[] = "Accept: application/json";
                
        curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
    
        $txt     = curl_exec($ch);
        curl_close($ch);
        
        $resJson = json_decode($txt, false);

        return "$resJson->balance";
    }
?>
    <div class="navbar navbar-inverse set-radius-zero">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/gerenciar/index.php">
                    <img class="logoImage" src="https://listamed.com.br//images/logo-internas-top.png" style="max-width:200px" />
                </a>
            </div>
            <label style="margin: 36px 0; position: relative; top: 55px; right: 25px;">
                Saldo SMS: <?php echo saldoSMS(); ?>
            </label>            
        </div>
    </div>
    <!-- LOGO HEADER END-->
    <section class="menu-section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="navbar-collapse collapse ">
                        <ul id="menu-top" class="nav navbar-nav navbar-right">
                            <li><a <?php if($menu=="medico") echo " class='menu-top-active' "; ?> href="/gerenciar/medico">Medicos</a></li>
                            <li><a <?php if($menu=="especialidades") echo " class='menu-top-active' "; ?> href="/gerenciar/especialidade">Especialidades</a></li>
                            <li><a <?php if($menu=="convenios") echo " class='menu-top-active' "; ?> href="/gerenciar/convenio">Convênios</a></li>
                            <li><a <?php if($menu=="relatorio") echo " class='menu-top-active' "; ?> href="/gerenciar/relatorio">Relatório</a></li>
                            <li><a <?php if($menu=="consultorio") echo " class='menu-top-active' "; ?> href="/gerenciar/consultorio">Centro Médico</a></li>
                            <li><a <?php if($menu=="page") echo " class='menu-top-active' "; ?> href="/gerenciar/page">Página</a></li>
                            <li><a <?php if($menu=="pergunta") echo " class='menu-top-active' "; ?> href="/gerenciar/pergunta">Perguntas</a></li>
                            <li><a <?php if($menu=="banner") echo " class='menu-top-active' "; ?> href="/gerenciar/banner">Banner</a></li>
                            <li><a href="http://listamed.com.br/blog/wp-login.php">Blog</a></li>
                            <li><a href="deslogar.php">Deslogar</a></li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </section>
