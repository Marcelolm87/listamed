<?php require_once("config.php"); session_start(); ?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Lista Med</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo $caminho; ?>css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $caminho; ?>images/favicon/favicon-96x96.png">
    
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

    <div class="page page-medicos" id="listamed-medicos">
        <div class="page-nav" id="listamed-nav">
            <div class="container">
                <div class="row container">
                    <div class="pull-left">
                        <h1 class="logo">
                            <a href="<?php echo $caminho; ?>">
                                <img src="<?php echo $caminho; ?>/images/logo-internas-top.png" />
                            </a>
                        </h1>
                    </div>
                    <div class="pull-right">
                        <div class="page-search">
                            <div class="visible-xs visible-sm hidden-md hidden-lg">
                                <button class="nora-toggle page-search-buttons--openSearch" nora-target="listamed-medicos-search"><i class="fa fa-search"></i></button>
                            </div>
                            <div class="page-search-container" id="listamed-medicos-search">
                                <form  id="formBuscar" action="medicos.php" method="get">
                                    <fieldset>
                                        <legend class="sr-only">Busque por médicos</legend>
                                        <div class="form-inline">
                                            <div class="form-group">
                                                <label class="sr-only">Busca</label>
                                                <?php if($_GET['buscar']!=""): $_SESSION['buscar'] = $_GET['buscar']; ?>
                                                    <input class="form-control" id="listamed-medicos-search--busca" type="text" value="<?php echo str_replace('-', ' ', $_GET['buscar']); ?>" name="buscar" autocomplete="off" placeholder="Busque por médico, clínica ou especialidade">
                                                <?php else: ?>
                                                    <input class="form-control" id="listamed-medicos-search--busca" type="text" value="<?php echo str_replace('-', ' ', $_SESSION['buscar']); ?>" name="buscar" autocomplete="off">
                                                <?php endif; ?>
                                            </div>
                                            <div class="form-group">
                                                <?php
                                                    $cidade = ($_SESSION['buscar_cidade']!="") ? $_SESSION['buscar_cidade'] : $_GET['cidade'];
                                                    $response = json_decode(file_get_contents('http://listamed.com.br/api/cidades/cadastradas/', false, stream_context_create($arrContextOptions)));
                                                ?>
                                                <label class="sr-only">Cidade</label>
                                                <select id="" name="cidade" class="form-control">
                                                    <option placeholder="Cidade" disabled="" selected="">Cidade</option>
                                                    <?php foreach ($response->data as $k => $v) {  ?>
                                                        <option <?php if($cidade==$v->id) echo "SELECTED"; ?> value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                            <button id="listamed-medicos-search--submit" type="button" class="btn btn-theme-blue">Buscar</button>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                            <script type="text/javascript">
                                function enviarForm(){
                                    var campoBuscar = document.getElementById('campoBuscar');
                                    var campoCidade = document.getElementById("campoCidade");
                                    var campoCidadeValue = campoCidade.options[campoCidade.selectedIndex].value;
                                    campoBuscar.value.replace("%20", "-");
                                    campoBuscar.value.replace(" ", "-");
                                    var textoBuscaLimpo = replaceALL(campoBuscar.value.trim(),' ','-');
                                    textoBuscaLimpo = replaceALL(textoBuscaLimpo,'.','');
                                    var error;

                                    if(campoBuscar.value.length>3){
                                    }else{
                                        campoBuscar.className = "erro";
                                        error = 'ok';
                                    }
                                    if(campoCidadeValue>0){
                                    }else{
                                        campoCidade.className = "erro";
                                        error = 'ok';
                                    }
                                    if(error!="ok"){
                                        window.location.href = '<?php echo $caminho; ?>listar/'+textoBuscaLimpo+'/'+campoCidadeValue;
                                    }
                                }
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>