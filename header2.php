<?php require_once("config.php"); session_start(); require_once("config.php"); ?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Lista Med</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" type="text/css" href="<?php echo $caminho ?>css/champs.min.css">
        <link rel="icon" type="image/png" sizes="96x96" href="<?php echo $caminho ?>images/favicon/favicon-96x96.png">
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
    <div class="header-pages--border mobile-hide tablet-hide desktop-show notebook-show">
    </div>

    <?php include 'search-mobile.php'; ?>
    <!--
        ######################
              DESKTOP
        ######################
    -->
    <div class="header-pages">
        <div class="page-home--section col-lg-12 row center container mobile-hide tablet-hide">
            <div class="page-home--container">
                <div class="col-lg-2 col-md-2 container">
                    <h1 class="logo left logo-header">
                        <a href="<?php echo $caminho; ?>"><img src="<?php echo $caminho ?>images/logo-internas-top.png" /></a>
                    </h1>
                </div>
                <div>
                    <div class="page-home--container-form col-lg-11 container center">
                        <form id="formBuscar" action="medicos.php" method="get">
                            <div class="col-lg-5 col-md-4 form-field">
                                <?php if($_GET['buscar']!=""): $_SESSION['buscar'] = $_GET['buscar']; ?>
                                    <input id="campoBuscar" type="text" value="<?php echo str_replace('-', ' ', $_GET['buscar']); ?>" name="buscar">
                                <?php else: ?>
                                    <input id="campoBuscar"  type="text" value="<?php echo str_replace('-', ' ', $_SESSION['buscar']); ?>" name="buscar">
                                <?php endif; ?>
                                <?php
                                    $cidade = ($_SESSION['buscar_cidade']!="") ? $_SESSION['buscar_cidade'] : $_GET['cidade'];
                                ?>
                                <!--<select>
                                    <option placeholder="Busque por médico, nome, clínica ou especialidade" disabled selected>Busque por médico, nome, clínica ou especialidade</option>
                                </select> -->
                                <style>
                                    input{
                                        color: gray;
                                        width: 100%;
                                        height: 42px;
                                        font-size: 16px;
                                        padding-left: 20px;
                                        border-radius: 4px;
                                        border-color: rgb(169, 169, 169);
                                    }
                                </style>
                            </div>
                            <div class="col-lg-4 col-md-3 form-field">
                                <?php $response = json_decode(file_get_contents('http://listamed.com.br/api/cidades/cadastradas/', false, stream_context_create($arrContextOptions))); ?>
                                <select name="cidade" id="campoCidade">
                                    <option value="todas" placeholder="Cidade" >Cidade</option>
                                    <?php foreach ($response->data as $k => $v) {  ?>
                                        <option <?php if($cidade==$v->id) echo "SELECTED"; ?>  value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-2 form-field">
                                <button onclick="enviarForm()" type="button" class="btn">BUSCAR</button>
                            </div>
                        </form>

                        <script type="text/javascript">
                            function replaceALL(busca, find, replace){
                                return removerAcentos(busca.replace(new RegExp(find.replace(/[-\/\\^$*+?.()|[\]{}]/g, '\\$&'), 'g'), replace));
                            }
                            function removerAcentos( newStringComAcento ) {
                              var string = newStringComAcento;
                                var mapaAcentosHex  = {
                                    a : /[\xE0-\xE6]/g,
                                    e : /[\xE8-\xEB]/g,
                                    i : /[\xEC-\xEF]/g,
                                    o : /[\xF2-\xF6]/g,
                                    u : /[\xF9-\xFC]/g,
                                    c : /\xE7/g,
                                    n : /\xF1/g
                                };

                                for ( var letra in mapaAcentosHex ) {
                                    var expressaoRegular = mapaAcentosHex[letra];
                                    string = string.replace( expressaoRegular, letra );
                                }

                                return string;
                            }
                            function enviarForm(){
                                var campoBuscar = document.getElementById('campoBuscar');
                                var campoCidade = document.getElementById("campoCidade");
                                var campoCidadeValue = campoCidade.options[campoCidade.selectedIndex].value;
                                var textoBuscaLimpo = replaceALL(campoBuscar.value.trim(),' ','-');
                                textoBuscaLimpo = replaceALL(textoBuscaLimpo,'.','');

                                campoBuscar.value.replace("%20", "-");
                                campoBuscar.value.replace(" ", "-");
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
                        <style>
                            input#campoBuscar.erro {
                                border: 2px solid red;
                            }
                        </style>



                        <!-- <form>
                            <div class="col-lg-5 col-md-4 form-field">
                                <select>
                                    <option placeholder="Busque por médico, nome, clínica ou especialidade" disabled selected>Busque por médico, nome, clínica ou especialidade</option>
                                </select>
                            </div>
                            <div class="col-lg-4 col-md-3 form-field">
                                <select>
                                    <option placeholder="Cidade" disabled selected>Cidade</option>
                                </select>
                            </div>
                            <div class="col-lg-1 col-md-2 form-field">
                                <button class="btn">BUSCAR</button>
                            </div>
                        </form> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--
        ######################
              //DESKTOP
        ######################
    -->