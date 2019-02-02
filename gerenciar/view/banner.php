<?php //header("Content-type: text/html; charset=utf-8"); 

require_once("model/banner.php");
require_once("classes/upload.php");

$banner = new BannerModel();

unset($_POST['palavra_chave']);
if(is_array($_POST['palavras_chaves'])):
    foreach ($_POST['palavras_chaves'] as $kpc => $vpc) :
        $_POST['palavra_chave'] .= $vpc.','; 
    endforeach;
endif;
unset($_POST['palavras_chaves']);

if(isset($_FILES['foto'])&&(@$_FILES['foto']['tmp_name']!=null)):
    $upload = new Upload($_FILES['foto']['tmp_name']); 
    if ($upload->uploaded) :
        $nomeArquivo_save = "";
        $nomeArquivo = md5(uniqid()) . '-' . time();
        if ( $_FILES['foto']['type'] == "image/png" ) :
            $nomeArquivo_save .= $nomeArquivo.'.png';
        elseif ( $_FILES['foto']['type'] == "image/gif" ) :
            $nomeArquivo_save .= $nomeArquivo.'.gif';
        elseif ( $_FILES['foto']['type'] == "image/jpeg" ) :
            $nomeArquivo_save .= $nomeArquivo.'.jpg';
        endif;
        $upload->file_new_name_body = $nomeArquivo;                
        $upload->Process('upload/banner/');
        if ($upload->processed):
            $imagem = '/gerenciar/upload/banner/'.$nomeArquivo_save; 
        endif;
    endif;
else:
    if($_POST['fotocadastro']!=""):
        $imagem = $_POST['fotocadastro']; 
    endif;
endif;

if(@$_POST['link']!=""){ $banner->banner_save($imagem); } 
if(@$_GET['deletar']!=""){ $banner->banner_delete($_GET['deletar'],false); }

$todosBanners = $banner->BuscarTodos()->data;

if(@$_GET['editar']>0):
    $dadosEditar = $obj->BuscarPorCOD($_GET['editar']);
endif;
?>

<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Banners</h4>
            </div>
        </div>
        <?php include("notificacao.php"); ?>

        <!-- INICIO TABELA -->
        <div class="row" id="rowTabela">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Banner</th>
                            <th>Link</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody class="tabelaConsultorio">
                        <?php if (!empty($todosBanners)) : ?>
                            <?php foreach ($todosBanners as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><img style="max-width: 100px; max-height: 100px;" src="<?php echo $v['imagem']; ?>" /></td>
                                    <td><?php echo $v['link']; ?></td>
                                    <td>
                                        <a href="/gerenciar/banner/alterar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Alterar</a> 
                                        <a onclick="removerBanner(<?php echo $v['id']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            Nenhum banner cadastrado!
                        <?php endif; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- FIM TABELA -->

        <!-- INICIO FORMULARIO -->
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <?php echo (isset($_GET['editar'])) ? "EDITAR" : "INSERIR"; ?>
                    </div>
                    <div class="panel-body">
                        <form action="#" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputImagem">Imagem (280px x 178px)</label><br/>
                                <?php if(isset($dadosEditar->data->imagem)) : echo "<img src='".$dadosEditar->data->imagem."' style='max-widht:100px; max-height:100px;'  />"; endif; ?>
                                <?php if(isset($dadosEditar->data->imagem)) : echo "<input type='hidden' name='fotocadastro' value='".$dadosEditar->data->imagem."'  />"; endif; ?>
                                <input type="file" name="foto" id="upload" value="Choose a file" accept="image/*" />
                                <label for="inputLink">Link</label><br/>
                                <input class="form-control" for="inputLink" value="<?php echo @$dadosEditar->data->link; ?>" name="link"><br/>
                                <label for="inputCliques">Cliques</label><br/>
                                <input class="form-control" for="inputCliques" value="<?php echo @$dadosEditar->data->limite_clique; ?>" name="limite_clique"><br/>
                                <label for="inputExibicoes">Exibições</label><br/>
                                <input class="form-control" for="inputExibicoes" value="<?php echo @$dadosEditar->data->limite_visualizacao; ?>" name="limite_visualizacao"><br/>
                                <label for="inputDataInicio">Data Inicio</label><br/>
                                <input class="form-control" for="inputDataInicio" value="<?php echo @$dadosEditar->data->data_inicio; ?>" name="data_inicio"><br/>
                                <label for="inputDataFim">Data fim</label><br/>
                                <input class="form-control" for="inputDataFim" value="<?php echo @$dadosEditar->data->data_fim; ?>" name="data_fim"><br/>
                                <label for="inputPalavraChave">Palavras Chaves</label><br/>
                                
                                <?php
                                    require_once("model/especialidade.php");
                                    
                                    $especialidade = new EspecialidadeModel();
                                    $todasEspecialidades = $especialidade->BuscarTodos()->data;

                                    $palavras = array_filter(explode(',', $dadosEditar->data->palavra_chave)); 
                                    foreach ($todasEspecialidades as $kEsp => $vEsp) :
                                        $dados[] = $vEsp['nome'];
                                    endforeach;
                                    sort($dados);

                                    foreach ($dados as $kEsp => $vEsp) :
                                ?>
                                       <input <?php if(in_array($vEsp, $palavras)){ echo "CHECKED"; } ?> type="checkbox" name="palavras_chaves[]" value="<?php echo $vEsp; ?>" ><?php echo $vEsp; ?><br/>
                                <?php endforeach;
                                ?>
                                <input <?php if(in_array("TODOS", $palavras)){ echo "CHECKED"; } ?> type="checkbox" name="palavras_chaves[]" value="TODOS" >TODOS<br/>

                                <input type="hidden" class="form-control" for="inputPalavraChave" value="<?php echo @$dadosEditar->data->palavra_chave; ?>" name="palavra_chave"><br/>
                                <input type="hidden" value="<?php echo @$dadosEditar->data->id; ?>" name="id">

                                <button type="submit" class="btn btn-default adicionarBanner">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
