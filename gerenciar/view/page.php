<?php 
    require_once("model/page.php");
    require_once("classes/upload.php");
   
    $page = new PageModel();

    if($_POST['enviado']=="Salvar"):
        if(isset($_FILES['banner_imagem'])&&(@$_FILES['banner_imagem']['tmp_name']!=null)):
            $upload = new Upload($_FILES['banner_imagem']['tmp_name']); 
            if ($upload->uploaded) :
                $nomeArquivo = md5(uniqid()) . '-' . time();
                if ( $_FILES['banner_imagem']['type'] == "image/png" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.png';
                elseif ( $_FILES['banner_imagem']['type'] == "image/gif" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.gif';
                elseif ( $_FILES['banner_imagem']['type'] == "image/jpeg" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.jpg';
                endif;
                $upload->file_new_name_body = $nomeArquivo;                
                $upload->Process('upload/pagina/');
            endif;
            $_POST['banner_imagem'] = $nomeArquivo_save;
        endif;
        if(isset($_FILES['sobre_imagem'])&&(@$_FILES['sobre_imagem']['tmp_name']!=null)):
            $upload = new Upload($_FILES['sobre_imagem']['tmp_name']); 
            if ($upload->uploaded) :
                $nomeArquivo = md5(uniqid()) . '-' . time();
                if ( $_FILES['sobre_imagem']['type'] == "image/png" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.png';
                elseif ( $_FILES['sobre_imagem']['type'] == "image/gif" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.gif';
                elseif ( $_FILES['sobre_imagem']['type'] == "image/jpeg" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.jpg';
                endif;
                $upload->file_new_name_body = $nomeArquivo;                
                $upload->Process('upload/pagina/');
            endif;
            $_POST['sobre_imagem'] = $nomeArquivo_save;
        endif;
        $dados = $_POST;
        $page->save();
    endif;

    // buscando informações
    $info = $page->BuscarPorCOD(1)->data;
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Página Inicial</h4>
                </div>
            </div>
            <?php include("notificacao.php"); ?>

            <form action="#" method="post" enctype="multipart/form-data">
                <!-- INICIO FORMULARIO -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="id">id</label>
                                    <input class="form-control id" name="id" value="1" readonly="" />
                                    <label for="banner_imagem">Banner - Imagem ( 1920px x 798px )</label>
                                    <input type="file" name="banner_imagem" accept="image/*" class="form-control banner_imagem" name="banner_imagem" />
                                    <label for="banner_titulo">Banner - Titulo</label>
                                    <input value="<?php echo $info->banner_titulo; ?>" class="form-control banner_titulo" name="banner_titulo" />
                                    <label for="banner_desc">Banner - Descrição</label>
                                    <textarea id="texto" class="form-control"  name="banner_desc"> <?php echo $info->banner_desc; ?> </textarea>
                                    <label for="banner_link">Banner - Link</label>
                                    <div style="margin: 5px 0;" class="input-group">
                                        <div class="input-group-addon">http://</div>
                                        <input value="<?php echo $info->banner_link; ?>" class="form-control banner_link" name="banner_link" />
                                    </div>
                                    <hr/>
                                    <label for="video_link">Video - Link</label>
                                    <div style="margin: 5px 0;" class="input-group">
                                        <div class="input-group-addon">https://www.youtube.com/</div>
                                        <input value="<?php echo $info->video_link; ?>" class="form-control video_link" name="video_link" />
                                    </div>
                                    <hr/>
                                    <label for="conteudo_titulo">Conteudo - Titulo</label>
                                    <input value="<?php echo $info->conteudo_titulo; ?>" class="form-control conteudo_titulo" name="conteudo_titulo" />
                                    <label for="conteudo_texto">Conteudo - Texto</label>
                                    <input value="<?php echo $info->conteudo_texto; ?>" class="form-control conteudo_texto" name="conteudo_texto" />
                                    <label for="conteudo_quantidade">Conteudo - Quantidade</label>
                                    <input value="<?php echo $info->conteudo_quantidade; ?>" class="form-control conteudo_quantidade" name="conteudo_quantidade" />
                                    <label for="conteudo_rodape">Conteudo - Rodapé Texto</label>
                                    <input value="<?php echo $info->conteudo_rodape; ?>" class="form-control conteudo_rodape" name="conteudo_rodape" />
                                    <label for="conteudo_link">Conteudo - Link</label>
                                    <div style="margin: 5px 0;" class="input-group">
                                        <div class="input-group-addon">https://</div>
                                        <input value="<?php echo $info->conteudo_link; ?>" class="form-control conteudo_link" name="conteudo_link" />
                                    </div>
                                    <hr/>
                                    <label for="banner_desc">Planos - Profissional</label>
                                    <textarea id="planos_texto1" class="form-control"  name="planos_texto1"> <?php echo $info->planos_texto1; ?> </textarea>
                                    <label for="banner_desc">Planos - Centro Médico</label>
                                    <textarea id="planos_texto2" class="form-control"  name="planos_texto2"> <?php echo $info->planos_texto2; ?> </textarea>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-head-line">Contato</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="contato_telefone">Telefone</label>                            
                                    <input value="<?php echo $info->contato_telefone; ?>" class="form-control contato_telefone" name="contato_telefone" />
                                    <label for="contato_email">E-mail</label>                            
                                    <input value="<?php echo $info->contato_email; ?>" class="form-control contato_email" name="contato_email" />
                                    <label for="contato_titulo">Titulo</label>                            
                                    <input value="<?php echo $info->contato_titulo; ?>" class="form-control contato_titulo" name="contato_titulo" />
                                    <label for="contato_texto">Texto</label>                            
                                    <textarea id="texto3" class="form-control"  name="contato_texto"> <?php echo $info->contato_texto; ?> </textarea>
                                    <label for="facebook">Facebook</label>                            
                                    <input value="<?php echo $info->facebook; ?>" class="form-control facebook" name="facebook" />
                                    <label for="instagram">Twitter</label>                            
                                    <input value="<?php echo $info->instagram; ?>" class="form-control instagram" name="instagram" />
                                    <label for="linkedin">Linkedin</label>                            
                                    <input value="<?php echo $info->linkedin; ?>" class="form-control linkedin" name="linkedin" />

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-head-line">Sobre</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="sobre_imagem">Banner (850px x 650px)</label>                            
                                    <input type="file" name="sobre_imagem" accept="image/*" class="form-control sobre_imagem" />
                                    <label for="sobre_titulo">Titulo</label>                            
                                    <input value="<?php echo $info->sobre_titulo; ?>" class="form-control sobre_titulo" name="sobre_titulo" />
                                    <label for="sobre_texto">Texto</label>                            
                                    <textarea id="texto4" class="form-control"  name="sobre_texto"> <?php echo $info->sobre_texto; ?> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-head-line">SMS</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="sms_cliente">Paciente</label>                            
                                    <input maxlength="70" value="<?php echo $info->sms_cliente; ?>" class="form-control sms_cliente" name="sms_cliente" />
                                    <label for="sms_profissional">Profissional</label>                            
                                    <input maxlength="70" value="<?php echo $info->sms_profissional; ?>" class="form-control sms_profissional" name="sms_profissional" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-head-line">CONFIRMAÇÃO DE PEDIDO</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="sms_confirmacao_pedido">Sms (70 caracteres)</label>                            
                                    <input maxlength="70" value="<?php echo $info->sms_confirmacao_pedido; ?>" class="form-control sms_confirmacao_pedido" name="sms_confirmacao_pedido" />
                                    <label for="sms_profissional">E-mail</label>                            
                                    <textarea id="texto5" class="form-control"  name="email_confirmacao_pedido"> <?php echo $info->email_confirmacao_pedido; ?> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <h4 class="page-head-line">TERMOS DE USO</h4>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="termos">Texto</label>                            
                                    <textarea id="planos_texto3" class="form-control"  name="termos"> <?php echo $info->termos; ?> </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button name="enviado" value="Salvar" type="submit" class="btn btn-default adicionaConteudo">Salvar</button>
            </form>     
        </div>
    </div>

<style type="text/css">
    .page-head-line {
        font-family: 'Roboto', sans-serif;
        letter-spacing: -1px;
        padding: 10px 20px 15px 0;
        color: #01abeb;
    }
</style>
