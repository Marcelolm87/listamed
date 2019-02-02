<?php //header("Content-type: text/html; charset=utf-8"); 

require_once("model/servico.php");
$servico = new ServicoModel();


//echo "<pre>"; print_r($_GET); echo "</pre>";

if(@$_GET['consultorio'] <= 0): 
    if(@$_GET['deletar']!=""){ $servico->delete($_GET['deletar'],false); }
    if(@$_POST['nome']!=""){ 
        $servico->save(); 
    }
    $todosServicos = $servico->BuscarTodos();

    if(@$_GET['editar']>0):
        // retorna as informações
        $dadosEditar = $obj->BuscarPorCOD($_GET['editar']);
    endif;
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Serviço</h4>
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
                                <th>Serviço</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaServico">
                            <?php foreach ($todosServicos->data as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a href="/gerenciar/servico/editar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Editar</a>
                                        <a href="/gerenciar/servico/deletar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Deletar</a> 
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
                                    <?php if(@$_GET['editar']!=""): ?>
                                        <input type="hidden" class="form-control servico" for="inputNome" value="<?php echo @$dadosEditar->data->id; ?>" name="id"><br/>
                                    <?php endif; ?>
                                    <label for="inputNome">Serviço</label><br/>
                                    <input class="form-control servico" for="inputNome" value="<?php echo @$dadosEditar->data->nome; ?>" name="nome"><br/>
                                    <button type="submit" class="btn btn-default adicionarConsultorio">Adicionar</button>
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
        if(@$_POST['nome']!=""){ 
            $retorno = $servico->save();
        }

        $todosServicos = $servico->BuscarTodos();

        require_once("model/consultorio.php");
        $consultorioModel = new ConsultorioModel();
        $dadosConsultorio = $consultorioModel->BuscarPorCOD($_GET['consultorio']);
        $dadosServicosCadastrados = $servico->BuscarPorCODConsultorio($_GET['consultorio']);
    ?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line"><?php echo $dadosConsultorio->data->nome; ?>
                        <div style="float:right;">
                            <a href="/gerenciar/galeria/consultorio/<?php echo $_GET['consultorio']; ?>" class="btn btn-xs btn-info">Galeria</a> 
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
                                <th>Serviço</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConsultorio">
                            <?php foreach ($dadosServicosCadastrados as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a onclick="removerServico(<?php echo $v['id']; ?>,<?php echo $_GET['consultorio']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a>
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
                                    <input type="hidden" class="idMedico" name="idMedico" value="<?php echo ($_GET['medico']); ?>" />
                                    <div class="exibirServico">
<!--                                         <table id="dataTable" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Consultorio</th>
                                                    <th>Opções</th>
                                                </tr>
                                            </thead>
                                            <tbody class="ulExibirServico">
 
                                            </tbody>
                                        </table> -->

                                    </div>


                                    <div class="formServicos">
                                        <div class="form-group">
                                            <?php if(@$_GET['editar']!=""): ?>
                                                <input type="hidden" class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->id; ?>" name="id"><br/>
                                                <input type="hidden" class="form-control servico" for="inputNome" value="<?php echo @$dadosEditar->data->tb_consultorio_id; ?>" name="tb_consultorio_id">
                                            <?php else: ?>
                                                <input type="hidden" class="form-control servico" for="inputNome" value="<?php echo $_GET['consultorio']; ?>" name="tb_consultorio_id">
                                            <?php endif; ?>
                                            <label for="inputNome">Serviço</label><br/>
                                            <input class="form-control servico" for="inputNome" value="<?php echo @$dadosEditar->data->nome; ?>" name="nome">
                                            <button type="submit" class="btn btn-default adicionarConsultorio">Adicionar</button>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<style type="text/css">
.exibirConsultorios{
    display: none;
    margin: 25px 0;
}
</style>
