<!--
    ######################
           MOBILE   
    ######################
-->
    <div class="mobile-show tablet-show col-xs-12 row header-pages--mobile">
        <div id="pesquisa-default" class="row pesquisa-default">
            <div class="left col-xs-7 center header-pages--mobile-img">
                <a href="<?php echo $caminho; ?>"><img src="<?php echo $caminho; ?>images/logo-mobile.png"></a>
            </div>
            <div class="right col-xs-2 text-center header-pages--mobile-search text-right">
                <i class="fa fa-search search-mobile" id="search"></i>
            </div>
        </div>
    </div>
    <div id="pesquisa" class="row header-pages--mobile-pesq right">
        <div class="row container search-align">
            <form id="formSearch" action="medicos.php" method="get">
                <?php if($_GET['buscar']!=""): $_SESSION['buscar'] = $_GET['buscar']; ?>
                    <input id="campoSearch" type="text" value="<?php echo $_GET['buscar']; ?>" name="buscar" autocomplete="off" autocapitalize="off" spellcheck="false" onfocus="this.value='';">
                <?php else: ?>
                    <input id="campoSearch"  type="text" value="<?php echo $_SESSION['buscar']; ?>" name="buscar" autocomplete="off" autocapitalize="off" spellcheck="false" onfocus="this.value='';">
                <?php endif; ?>
                <?php
                    $cidade = ($_SESSION['buscar_cidade']!="") ? $_SESSION['buscar_cidade'] : $_GET['cidade'];
                ?>

                <?php $response = json_decode(file_get_contents('http://listamed.com.br/api/cidades/cadastradas/', false, stream_context_create($arrContextOptions))); ?>
                <select name="cidade" id="searchCidade">
                    <option placeholder="Cidade" disabled="" selected="">Cidade</option>
                    <?php foreach ($response->data as $k => $v) {  ?>
                        <option <?php if($cidade==$v->id) echo "SELECTED"; ?> value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
                    <?php } ?>
                </select>
                <button onclick="enviarForm2()" type="button">BUSCAR</button>
            </form>
            <script type="text/javascript">
                function enviarForm2(){
                    var campoSearch = document.getElementById('campoSearch');
                    var searchCidade = document.getElementById("searchCidade");
                    var searchCidadeValue = searchCidade.options[searchCidade.selectedIndex].value;
                    campoSearch.value.replace("%20", "-");
                    campoSearch.value.replace(" ", "-");
                    var textoBuscaLimpo = replaceALL(campoSearch.value.trim(),' ','-');
                    var error;


                    if(campoSearch.value.length>3){
                    }else{
                        campoSearch.className = "erroSearch";
                        error = 'ok';
                    }
                    if(searchCidadeValue>0){
                    }else{
                        searchCidade.className = "erroSearch";
                        error = 'ok';
                    }
                    if(error!="ok"){
                        window.location.href = '<?php echo $caminho; ?>listar/'+textoBuscaLimpo+'/'+searchCidadeValue;
                    }
                }
                if(document.getElementById(campoSearch) != null){
                    $("#campoSearch").focus(function() {
                        this.value = '';
                    });
                }
            </script>
            <style>
                input#campoBuscar.erroSearch {
                    border: 2px solid red;
                }
            </style>
        </div>
    </div>

<!--
    ######################
          //MOBILE   
    ######################

-->