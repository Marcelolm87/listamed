<?php 
   //header("Content-type: text/html; charset=utf-8");
    require_once("model/galeria.php");
    require_once("classes/upload.php");
    $galeria = new GaleriaModel();

    if(isset($_FILES['imagem'])&&(@$_FILES['imagem']!=null)):
        foreach ($_FILES['imagem']['tmp_name'] as $kImg => $vImg) :
            $upload = new Upload($vImg); 
            if ($upload->uploaded) :
                $nomeArquivo_save = "";
                $nomeArquivo = md5(uniqid()) . '-' . time();
                if ( $_FILES['imagem']['type'][$kImg] == "image/png" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.png';
                elseif ( $_FILES['imagem']['type'][$kImg] == "image/gif" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.gif';
                elseif ( $_FILES['imagem']['type'][$kImg] == "image/jpeg" ) :
                    $nomeArquivo_save .= $nomeArquivo.'.jpg';
                endif;
                $upload->file_new_name_body = $nomeArquivo;                
                $upload->Process('upload/galeria/');
                if ($upload->processed):
                    $galeria->salvarImagem($nomeArquivo_save, $_GET['consultorio']);
                endif;
            endif;
        endforeach;
    endif;

    if(@$_GET['consultorio'] <= 0):
        if(@$_GET['deletar']!=""){
            $galeria->delete($_GET['deletar']);
        }

        if(@$_POST['nome']!=""){
            $galeria->save();
        }
        $todasImagens = $galeria->BuscarPorCODConsultorio($_GET['consultorio']);

?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Imagens</h4>
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
                                <th>Id</th>
                                <th>Imagem</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaEspecialidade">
                            <?php foreach ($todasImagens->data as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><img src="/gerenciar/upload/galeria/<?php echo $v['imagem']; ?>" /></td>
                                    <td>
                                        <a onclick="removerPergunta(<?php echo $v['id']; ?>,<?php echo $_GET['consultorio']; ?>)" href="/gerenciar/galeria/deletar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Deletar</a> </td>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
                                    <label for="inputCep">Especialidade</label>
                                    <input class="especialidade" name="nome">
                                    <button type="submit" class="btn btn-default adicionarEspecialidade">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else: ?>
    <?php
        $todasImagens = $galeria->BuscarPorCODConsultorio($_GET['consultorio']);

        require_once("model/consultorio.php");
        $consultorioModel = new ConsultorioModel();
        $dadosConsultorio = $consultorioModel->BuscarPorCOD($_GET['consultorio']);
    ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line"><?php echo $dadosConsultorio->data->nome; ?>
                        <div style="float:right;">
                            <a href="/gerenciar/servico/consultorio/<?php echo $_GET['consultorio']; ?>" class="btn btn-xs btn-info">+ Serviços</a> 
                            | <a href="/gerenciar/convenio/consultorio/<?php echo $_GET['consultorio']; ?>" class="btn btn-xs btn-info">Convenio</a>
                            | <a href="/gerenciar/consultorio/editar/<?php echo $_GET['consultorio']; ?>" class="btn btn-xs btn-info">Editar</a>
                        </div>
                    </h4>
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
                                <th>Id</th>
                                <th>Imagem</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConsultorio">
                            <?php foreach ($todasImagens as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><img style="max-width: 150px; max-height: 150px;" src="/gerenciar/upload/galeria/<?php echo $v['imagem']; ?>"/></td>
                                    <td>
                                        <a onclick="removerGaleria(<?php echo $v['id']; ?>,<?php echo $_GET['consultorio']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a> </td>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
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
                                    <label for="inputCep">Imagem (640px x 480px)</label>
                                    <input type="hidden" class="idMedico" name="idMedico" value="<?php echo ($_GET['consultorio']); ?>" />
                                    <input type="file" name="imagem[]" accept="image/*" multiple="true" >
                                    <button type="submit" class="btn btn-default adicionarImagens">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
