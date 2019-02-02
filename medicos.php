<?php 
    header("Content-type: text/html; charset=utf-8"); 
    session_start(); 
    require_once("config.php");
    $busca['cidade'] = $_GET['cidade'];
    $busca['nome'] = str_replace("+", "", $_GET['buscar']);
    $busca['nome'] = str_replace("%20", " ", $_GET['buscar']);

    if($busca['nome']){
        $_SESSION['buscar'] = $busca['nome'];
        if($busca['cidade']!=""):
            unset($_SESSION['buscar_cidade']);
        endif;
    }

    if($busca['cidade']!=''){
        if($busca['cidade']=="todas"):
            unset($_SESSION['cidade']);
        else:
            $_SESSION['buscar_cidade'] = $busca['cidade'];
        endif;
    }

    function removeAcentos( $string ) {
        $string = strtolower($string);
        
        $string = str_replace('á', 'a', $string);
        $string = str_replace('à', 'a', $string);
        $string = str_replace('â', 'a', $string);
        $string = str_replace('ã', 'a', $string);
        $string = str_replace('ä', 'a', $string);

        $string = str_replace('é', 'e', $string);
        $string = str_replace('è', 'e', $string);
        $string = str_replace('ê', 'e', $string);

        $string = str_replace('í', 'i', $string);
        $string = str_replace('ì', 'i', $string);
        
        $string = str_replace('ó', 'o', $string);
        $string = str_replace('ò', 'o', $string);
        $string = str_replace('ô', 'o', $string);
        $string = str_replace('õ', 'o', $string);
        $string = str_replace('ö', 'o', $string);

        $string = str_replace('ú', 'u', $string);
        $string = str_replace('ù', 'u', $string);
        $string = str_replace('ü', 'u', $string);

        $string = str_replace('ç', 'c', $string);

        return ($string);
    }
    function slug($nome){
        $aux = removeAcentos($nome);
        $aux = strtolower( strip_tags( preg_replace( array( '/[`^~\'"]/', '/([\s]{1,})/', '/[-]{2,}/' ), array( null, '-', '-' ), iconv( 'UTF-8', 'ASCII//TRANSLIT', $aux ) ) ) );
        return str_replace(".", "", $aux);
    }

    $filtro = null;
    if(isset($_GET['filtro'])){
        $filtro = $_GET['filtro'];
    }  

    if($_SESSION['buscar']){
        if($_SESSION['buscar_cidade']):

            $aux  = explode(" ",$_SESSION['buscar']);
            foreach ($aux as $k => $v) :
                if(strlen($v)>3):
                    $_SESSION['buscar'] = $v." ";
                endif;
            endforeach;

            $buscarPor = str_replace(" ", "-", trim($_SESSION['buscar']));
            $buscarPor = str_replace("-", "-", $buscarPor);

            if($_SESSION['buscar_cidade']!="todas"){
                $url = "https://listamed.com.br/api/busca/".$buscarPor."/".$_SESSION['buscar_cidade'];
            }else{
                $url = "https://listamed.com.br/api/busca/".$buscarPor; 
            }
        else:
            $url = "https://listamed.com.br/api/busca/".$buscarPor;
        endif;

        //echo $url;
        $response = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)));

        $ip = $_SERVER["REMOTE_ADDR"];
        if($ip=="168.195.237.145"){
            $correto = false;
            foreach ($response->profissionais as $key => $value) {
                if($value->lev == -1){
                    $correto = 'true';
                }
            }
            foreach ($response->profissionais as $key => $value) {
                if($correto):             
                    if ($value->lev==-1) :
                        $profissionais[$key] = $value;
                    endif;
                else:
                    $profissionais[$key] = $value;
                endif;
            }
            unset($response->profissionais);
            $response->profissionais = $profissionais;
        }
    }

    $page = @$_GET['page'];  

    if($page==0) $page = 1;

    $totalProfissional = count((array)$response->profissionais);
    $totalCentro       = count((array)$response->centro);

    $count = 0;
    $pageAux = 1;
    if(@$_GET[filter]=="centro-medico"){
        foreach ($response->centro as $k => $v) {
            $dados[$k] = $v;
            if($count<9):
                $dados[$k]->page = $pageAux;
                $dados[$k]->sintoma = "";
                $dados[$k]->doenca = "";
            else:
                $dados[$k]->page = $pageAux++;
                $dados[$k]->sintoma = "";
                $dados[$k]->doenca = "";
                $count=-1;
            endif;
            $count++;
        }
        $responseInfo = $response->centro;
    }else{
        if(!empty($response->profissionais)):
            foreach ($response->profissionais as $k => $v) {
                $dados[$k] = $v;
                if($count<9):
                    $dados[$k]->page = $pageAux;
                    $dados[$k]->sintoma = "";
                    $dados[$k]->doenca = "";
                else:
                    $dados[$k]->page = $pageAux++;
                    $dados[$k]->sintoma = "";
                    $dados[$k]->doenca = "";
                    $count=-1;
                endif;
                $count++;
            }
        endif;
        $responseInfo = $response->profissionais;
    }
    $totalInfo = count($dados);
    $total = $pageAux;

    //$cidade = json_decode(file_get_contents("https://listamed.com.br/api/cidade/".$_SESSION['buscar_cidade']))->data->cidade;
    $cidade = json_decode(file_get_contents("https://listamed.com.br/api/cidade/".$_SESSION['buscar_cidade'], false, stream_context_create($arrContextOptions)))->data->cidade;
?>
<!doctype html>
<html class="no-js" lang="">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>ListaMED</title>
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
                                                <select id="listamed-medicos-search--cidade" name="cidade" class="form-control">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-main" id="listamed-medicos">
            <div class="page-toolbar page-toolbar--top">
                <div class="container">
                    <div class="row container-fluid">
                        <div class="pull-left">
                            <ul class="page-medicos-filter list list-items--inline">
                                <li class="list--item">
                                    <a href="<?php echo $caminho ?>listar/profissionais/<?php echo $_GET['buscar']?>/<?php echo $_GET['cidade']; ?>" class="<?php echo ($_GET['filter']!='centro-medico') ? 'active' : '' ; ?>" >
                                        Profissional (<?php echo $totalProfissional; ?>)
                                    </a>
                                </li>
                                <li class="list--item">
                                    <a href="<?php echo $caminho ?>listar/centro-medico/<?php echo $_GET['buscar']?>/<?php echo $_GET['cidade']; ?>" class="<?php echo ($_GET['filter']=='centro-medico') ? 'active' : '' ; ?>">
                                        Centros Médicos (<?php echo $totalCentro; ?>)
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="pull-right visible-lg visible-md visible-sm hidden-xs">
                            <div class="page-pagination">
                                <?php 
                                    if($total>1):
                                        $linkPag = ($_GET['filter']!="") ? $caminho.'/listar/'.$_GET['filter'].'/'.$_GET['buscar'].'/'.$_GET['cidade'] : $caminho.'/listar/profissionais/'.$_GET['buscar'].'/'.$_GET['cidade'];
                                        if ($page>1) : $pageAnterior = $page - 1; 
                                ?>
                                            <a class="page-pagination-item page-pagination-prev" href="<?php echo $linkPag ?>/<?php echo $pageAnterior; ?>">
                                                <i class="fa fa-angle-left"></i>
                                                Anterior
                                            </a>
                                    <?php 
                                        endif; 
                                        for($i=1; $i <= $total; $i++): 
                                            if($i==$page): 
                                    ?>
                                                <span class="page-pagination-item page-pagination-number page-pagination-current">
                                                    <?php echo $page; ?>
                                                </span>
                                        <?php   
                                            else: 
                                        ?>
                                                <a class="page-pagination-item page-pagination-number" href="<?php echo $linkPag ?>/<?php echo $i; ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                    <?php   
                                            endif; 
                                        endfor; 
                                        if ($page<$total): 
                                            $pageProxima = $page +1; 
                                    ?>
                                            <a class="page-pagination-item page-pagination-next" href="<?php echo $linkPag ?>/<?php echo $pageProxima; ?>">
                                                Próxima
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                <?php 
                                        endif; 
                                    endif; 
                                ?>
                            </div>
                        </div>
                    </div>                    
                </div>
            </div>
            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
                            <div class="page-medicos-find">
                                <p>Você buscou por: <i><strong><?php echo $_SESSION['buscar']; ?></strong></i></p>
                            </div>
                            <?php 
                                if(!empty($responseInfo)):
                                    foreach ($responseInfo as $key => $value) {
                                        if($value->lev==-1){
                                            $response2[$key] = $value;
                                            $response2[$key]->page = 1;
                                        }else if(@$value->status==1){
                                            $response2[$key] = $value;
                                            $response2[$key]->page = 1;
                                        }else if(@$value->consultorio_status==1){
                                            $response2[$key] = $value;
                                            $response2[$key]->page = 1;
                                        }
                                    }
                                    foreach ($responseInfo as $key => $value) {
                                        if($value->lev==0){
                                            $response2[$key] = $value;
                                        }
                                    }
                                    foreach ($responseInfo as $key => $value) {
                                        if($value->lev==1){
                                            $response2[$key] = $value;
                                        }
                                    }
                                    foreach ($responseInfo as $key => $value) {
                                        if($value->lev==2){
                                            $response2[$key] = $value;
                                        }
                                    }
                                endif;

                                if(count($response2)>0):
                            ?>
                                <div class="page-medicos-list">
                                    <?php
                                        foreach ($response2 as $k => $v):
                                            if($page == $v->page):
                                                if(@$_GET[filter]=="centro-medico"){


                                                    $url = 'https://listamed.com.br/api/endereco/'.$v->consultorio_enderecoid;
                                                    $arrContextOptions = array(
                                                       "ssl"=>array(
                                                           "verify_peer"=>false,
                                                           "verify_peer_name"=>false,
                                                       ),
                                                    );

                                                    $cidade = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)))->data->nome;


                                                    $id = $v->consultorio_id;
                                                    $nome = $v->consultorio_nome;
                                                    $telefone = $v->consultorio_telefone;
                                                    $site = $v->consultorio_site;
                                                    $descricao = $v->consultorio_descricao;
                                                    $whatsapp = "";
                                                    $imagem = $v->consultorio_imagem;
                                                    $especialidade_text = $v->consultorio_text;
                                                    $caminhoImagem = 'gerenciar/upload/consultorio/'.$imagem;
                                                    $imagem = ($imagem!="") ? $caminhoOnline.$caminhoImagem : 'http://listamed.com.br/medico.jpg';
                                                    $status = $v->consultorio_status;

                                                    $link = $caminho."centro-medico/".$id."/".slug($nome);
                                                }else{
                                                    $id = $v->id;
                                                    $nome = $v->nome;
                                                    $cidade = $v->cidade;
                                                    $telefone = $v->telefone;
                                                    $whatsapp = $v->whatsapp;
                                                    $imagem = $v->imagem;
                                                    $especialidade_text = $v->especialidade_text;
                                                    $caminhoImagem = '/gerenciar/upload/profissionais/'.$imagem;
                                                    $imagem = ($imagem!="") ? $caminhoOnline.$caminhoImagem : 'http://listamed.com.br/medico.jpg';
                                                    $status = $v->status;

                                                    $site = $v->site;
                                                    $convenios = "";
                                                    $especialidade = "";
                                                    if(!empty($v->convenio)){
                                                        foreach ($v->convenio as $kc => $vc) {
                                                            $convenios = ($convenios=="") ? $convenios = $vc : $convenios .= " | ".$vc; 
                                                        }
                                                    }
                                                    if(is_array($v->especialidade)):
                                                        foreach ($v->especialidade as $ke => $ve) {
                                                            $esp = (@$esp == "") ? $ve : $esp;
                                                            $especialidade = ($especialidade == "") ? $especialidade = $ve : $especialidade .= " | ".ucfirst($ve); 
                                                            $especialidade_full[] = $ve; 
                                                        }
                                                    endif;
                                                    $link = $caminho."profissional/".$id."/".slug($nome);
                                                }
                                                if($telefone!=""){
                                                    $telefone2 = substr($telefone, 0, 5)."<span> ...ver número</span>";
                                                }
                                                if($whatsapp!=""){
                                                    $whatsapp2 = substr($whatsapp, 0, 5)."<span> ...ver whatsapp</span>";
                                                }
                                    ?>
                                            <?php/*<script type="text/javascript">
                                                gravarPerfil('<?php echo $id; ?> - <?php echo $nome; ?>');
                                            </script> */ ?>  
                                            <div class="medico medico-card">
                                                <div class="row">
                                                <?php if( $status == 1 ): ?> 
                                                    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                                                        <div class="medico-card-foto">
                                                            <a href="<?php echo $link; ?>">
                                                                <img src="<?php echo $imagem; ?>"/>
                                                            </a>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>                                                        
                                                <?php if( $status == 1 ): ?> 
                                                    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-6">
                                                <?php else: ?>
                                                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-9">
                                                <?php endif; ?>
                                                        <div class="medico-card-header">
                                                            <h3>
                                                                <?php if( $status == 1 ): ?> 
                                                                    <a onclick="ga('send', 'event', 'listagem', 'clique', '<?php echo $id; ?> - <?php echo $nome; ?>', {'nonInteraction': 0} );" href="<?php echo $link; ?>">
                                                                        <?php echo $nome; ?>
                                                                    </a>
                                                                <?php else: ?>
                                                                    <?php if (@$_GET[filter]=="centro-medico"): ?>
                                                                        <a onclick="ga('send', 'event', 'listagem', 'clique', '<?php echo $id; ?> - <?php echo $nome; ?>', {'nonInteraction': 0} );" href="#" data-toggle="modal" data-target="#listamed-modal-formCentro">
                                                                            <?php echo $nome; ?>                                                                            
                                                                        </a> 
                                                                    <?php else: ?> 
                                                                        <a href="#" data-toggle="modal" data-target="#listamed-modal-formPerfil">
                                                                            <?php echo $nome; ?>
                                                                        </a>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            </h3>            
                                                            <p>
                                                                <?php if( $status == 1 ): ?> 
                                                                    <?php echo ucfirst($especialidade); ?>
                                                                <?php else: ?>
                                                                    <i class="fa fa-map-marker"></i><?php echo $cidade; ?>
                                                                <?php endif; ?>
                                                            </p>                                                    
                                                        </div>
                                                        <div class="medico-card-content">
                                                            <?php if($especialidade_text!=""): ?>
                                                                <p>Especialista em: <?php echo $especialidade_text; ?></p>
                                                            <?php endif; ?>
                                                            <?php
                                                                if(( $status == 1 )&&(@$_GET['filter']=="profissionais")):
                                                            ?>
                                                                <a onclick="ga('send', 'event', 'listagem', 'clique', '<?php echo $id; ?> - <?php echo $nome; ?>', {'nonInteraction': 0} );" class="btn btn-theme-orange" href="<?php echo $link; ?>">
                                                                    Agendar Pré-consulta
                                                                </a>
                                                            <?php 
                                                                else: 
                                                                    echo @$descricao;
                                                                endif; 
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                                        <?php  if( $status == 1 ): ?>
                                                            <ul class="medico-card-extras list list-items--block">
                                                                <li class="list--item">
                                                                    <i class="fa fa-flag"></i> 
                                                                    <?php echo $cidade; ?>
                                                                </li>
                                                                <?php if($telefone2 !="" || $whatsapp2 != ""): ?>
                                                                    <li class="list--item">
                                                                        <span>
                                                                            <i class="fa fa-phone"></i> 
                                                                            Telefone(s):
                                                                        </span>
                                                                        <?php if($telefone2 !=""): ?>
                                                                            <button type="button" onclick="showTelefone(this, '<?php echo $telefone; ?>', '<?php echo $id; ?> - <?php echo $nome; ?>')" >
                                                                                <?php echo $telefone2; ?>
                                                                            </button>
                                                                        <?php endif; ?>
                                                                        <?php if($whatsapp2 !=""): ?>
                                                                            <button type="button" onclick="showWhats(this, '<?php echo $whatsapp; ?>', '<?php echo $id; ?> - <?php echo $nome; ?>')" >
                                                                                <?php echo $whatsapp2; ?>   
                                                                            </button>
                                                                        <?php endif; ?>
                                                                    </li>
                                                                <?php endif; ?>
                                                                <?php if($site !=""): ?>
                                                                    <li class="list--item">
                                                                        <span>
                                                                            <i class="fa fa-globe"></i> Site:
                                                                        </span>
                                                                        <a href="http://<?php echo $site; ?>" target="_blank" data-toggle="tooltip" data-placement="bottom" title="Acessar o link">
                                                                            <?php echo $site; ?>
                                                                        </a>
                                                                    </li>
                                                                <?php endif; ?>
                                                            </ul>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                            endif;
                                        endforeach;
                                    ?>
                                </div>
                            <?php 
                                else:
                                    echo ($_GET[filter]!="centro-medico") ? "<br/><br/>Nenhum profissional encontrado" : "<br/><br/>Nenhum centro medico encontrado" ; 
                                endif;
                            ?> 
                            <?php if($total>1):?>
                                <div class="page-toolbar page-toolbar--bottom">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <p>
                                                Mostrando resultados
                                                <?php 
                                                    if($page>=1) : 
                                                        $inicioPage = ($page -1) * 10; 
                                                        if($page == $total):
                                                            $finalPage  = $totalInfo;
                                                        elseif($page == 1):
                                                            $inicioPage = 1; 
                                                            $finalPage  = ($page) * 10;
                                                        else:
                                                            $finalPage  = ($page) * 10;
                                                        endif;
                                                ?>
                                                    <strong><?php echo $inicioPage; ?> - <?php echo $finalPage; ?></strong> de
                                                <?php endif; ?>
                                                <strong><?php echo $totalInfo; ?></strong>
                                            </p>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                            <div class="page-pagination pull-right">
                                                <?php 
                                                    if($total>1):
                                                        $linkPag = ($_GET['filter']!="") ? $caminho.'/listar/'.$_GET['filter'].'/'.$_GET['buscar'].'/'.$_GET['cidade'] : $caminho.'/listar/profissionais/'.$_GET['buscar'].'/'.$_GET['cidade'];
                                                        if ($page>1) : $pageAnterior = $page - 1; 
                                                ?>
                                                            <a class="page-pagination-item page-pagination-prev" href="<?php echo $linkPag ?>/<?php echo $pageAnterior; ?>">
                                                                <i class="fa fa-angle-left"></i>
                                                                Anterior
                                                            </a>
                                                    <?php 
                                                        endif; 
                                                        for($i=1; $i <= $total; $i++): 
                                                            if($i==$page): 
                                                    ?>
                                                                <span class="page-pagination-item page-pagination-number page-pagination-current">
                                                                    <?php echo $page; ?>
                                                                </span>
                                                        <?php   
                                                            else: 
                                                        ?>
                                                                <a class="page-pagination-item page-pagination-number" href="<?php echo $linkPag ?>/<?php echo $i; ?>">
                                                                    <?php echo $i; ?>
                                                                </a>
                                                    <?php   
                                                            endif; 
                                                        endfor; 
                                                        if ($page<$total): 
                                                            $pageProxima = $page +1; 
                                                    ?>
                                                            <a class="page-pagination-item page-pagination-next" href="<?php echo $linkPag ?>/<?php echo $pageProxima; ?>">
                                                                Próxima
                                                                <i class="fa fa-angle-right"></i>
                                                            </a>
                                                <?php 
                                                        endif; 
                                                    endif; 
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 hidden-xs hidden-sm visible-md visible-lg">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-footer">
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
                                            <img src="<?php echo $caminhoOnline; ?>images/logo-internas-bot.png" />
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
                                    <a href="http://www.wdezoito.com.br/" target="_blank">
                                        <img src="<?php echo $caminhoOnline; ?>images/logo-w18.png" />
                                    </a>
                                </p>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-modals">
            <?php include 'modal-form-perfil.php'; ?>            
        </div>
        <script type="text/javascript">
            function gravarPerfil(info){
                ga('send', 'event', 'listagem', 'exibido', info, {'nonInteraction': 0} );
            }
        </script>
    </div>
    <style>
        .paginasMedicos{
            color: #c1c1c1;
            text-decoration: none;
            margin-top: 20px;
        }
        .nav-previous a{
            color: #c1c1c1;
        }
        .nav-next a{
            color: #c1c1c1;
        }
        .btn-medicos--top .btn-medicos--group a {
            font-size: 16px;
            width: 175px;
            height: 35px;
            color: #00b0c0;
            text-decoration: none;
        }
        .page-medicos--pages .navigation .nav-next a, .page-medicos--pages .navigation .nav-previous a {
            text-decoration: none;
            color: #c1c1c1;
        }
        .page-medicos--pages .navigation .nav-next a:hover, .page-medicos--pages .navigation .nav-previous a:hover {
            color: #00b0c0;
        }
        .page-medicos--pages .nav-pag .wp-pagenavi .pages div {
            border-bottom: none;
        }
    </style>
    <script src="/js/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"></script>
    <script src="<?php echo $caminho ?>js/champs.min.js"></script>
    <script src="<?php echo $caminho ?>js/ouibounce.js"></script>
    <script src="<?php echo $caminho ?>js/script.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            jQuery.expr[':'].focus = function( elem ) {
              return elem === document.activeElement && ( elem.type || elem.href );
            };

            $(window).keydown(function(event){
                if(event.keyCode == 13) {
                    if ($( "#campoBuscar" ).is(":focus")) {
                        enviarForm();
                    }
                    event.preventDefault();
                    return false;
                }
            });

            $.ajax({
                url: '/banner_list.php',
                type: 'POST',
                data: {dados: '<?php echo json_encode($especialidade_full); ?>'},
            }).done(function(data) {
                $(".page-medicos--blocks-list").html(data);
            });
        });
    </script>
</body>
</html>
