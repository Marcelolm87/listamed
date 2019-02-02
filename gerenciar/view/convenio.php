<?php //header("Content-type: text/html; charset=utf-8"); 

require_once("model/convenio.php");
$convenio = new ConvenioModel();
?>

<?php if(@$_GET['medico'] >= 1): ?>
<?php
        $todasConvenios = $convenio->BuscarTodos();
        require_once("model/medico.php");
        $medicoModel = new MedicoModel();
        $dadosMedico = MedicoModel::retornoFull($medicoModel->BuscarPorCOD($_GET['medico']));
    ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line"><?php echo $dadosMedico->data->nome; ?>
                        <?php if(@$_GET['medico']>0): ?>
                            <div style="float:right;">
                                 <a href="/gerenciar/especialidade/medico/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >+ Especialidade</a> 
                                | <a href="/gerenciar/consultorio/medico/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >+ Consultorio</a> 
                                | <a href="/gerenciar/medico/editar/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >Editar perfil</a>
                            </div>
                        <?php endif; ?>
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
                                <th>Convenio</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConvenio">
                            <?php foreach ($dadosMedico->convenio as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a onclick="removerConvenio(<?php echo $v['id']; ?>,<?php echo $_GET['medico']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a> </td>
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
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label for="inputCep">Convenio</label>
                                    <input type="hidden" class="idMedico" name="idMedico" value="<?php echo ($_GET['medico']); ?>" />
                                    <select class="convenio" name="convenio_id">
                                        <option> Selecione uma convenio</option>
                                        <?php foreach ($todasConvenios->data as $kEsp => $vEsp) : ?>
                                            <option rel="<?php echo $vEsp['id']; ?>" value="<?php echo $vEsp['id']; ?>"><?php echo $vEsp['nome']; ?></option>    
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" class="btn btn-default adicionarConvenio">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php elseif(@$_GET['consultorio'] >= 1): ?>
<?php

    if(@$_GET['deletar']!=""){
        $convenio->delete($_GET['deletar']);
    }

    if(@$_POST['nome']!=""){
        $convenio->save();
    }

    require_once("model/consultorio.php");
    $consultorioModel = new ConsultorioModel();
    $dadosConvenio = $consultorioModel->BuscarPorCOD($_GET['consultorio']);
    $dadosConvenioConsultorio = $consultorioModel->BuscarConvenioPorCOD($_GET['consultorio']);

    $todasConvenios = $convenio->BuscarTodos();
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                  <h4 class="page-head-line"><?php echo $dadosConvenio->data->nome; ?>
                        <div style="float:right;">
                            <a href="/gerenciar/servico/consultorio/<?php echo $_GET['consultorio']; ?>" class="btn btn-xs btn-info">+ Serviços</a> 
                            | <a href="/gerenciar/galeria/consultorio/<?php echo $_GET['consultorio']; ?>" class="btn btn-xs btn-info">Galeria</a> 
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
                                <th>Convenio</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConvenio">
                            <?php foreach ($dadosConvenioConsultorio as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a onclick="removerConsultorioConvenio(<?php echo $v['id']; ?>,<?php echo $_GET['consultorio']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a> </td>
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
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label for="inputCep">Convenio</label>
                                    <input type="hidden" class="idConsultorio" name="idConsultorio" value="<?php echo ($_GET['consultorio']); ?>" />
                                    <select class="convenio" name="convenio_id">
                                        <option> Selecione uma convenio</option>
                                        <?php foreach ($todasConvenios->data as $kEsp => $vEsp) : ?>
                                            <option rel="<?php echo $vEsp['id']; ?>" value="<?php echo $vEsp['id']; ?>"><?php echo $vEsp['nome']; ?></option>    
                                        <?php endforeach; ?>
                                    </select>
                                    <button type="button" class="btn btn-default adicionarConvenioConsultorio">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php else : ?>
<?php
    if(@$_GET['deletar']!=""){
        $convenio->delete($_GET['deletar']);
    }

    if(@$_POST['nome']!=""){
        $convenio->save();
    }
    $todasConvenios = $convenio->BuscarTodos();
    ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Convenio</h4>
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
                                <th>Convenio</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConvenio">
                            <?php foreach ($todasConvenios->data as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a href="/gerenciar/convenio/deletar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Deletar</a> </td>
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
                            <form action="#" method="post">
                                <div class="form-group">
                                    <label for="inputCep">Convenio</label>
                                    <input class="convenio" name="nome">
                                    <button type="submit" class="btn btn-default adicionarConvenio">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
<?php endif; ?>
