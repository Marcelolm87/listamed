<?php //header("Content-type: text/html; charset=utf-8");

require_once("model/pergunta.php");
$pergunta = new PerguntaModel();
?>

<?php
if(@$_GET['deletar']!=""){
    $pergunta->pergunta_delete($_GET['deletar'],true);
}

if(@$_POST['pergunta']!=""){
    $pergunta->pergunta_save();
}

if(isset($_GET['alterar'])):
    $dadosAlterar = $pergunta->BuscarPorCOD($_GET['alterar'])->data;
endif;

$todasPerguntas = $pergunta->BuscarTodos();

?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Perguntas Frequentes</h4>
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
                            <th>Pergunta</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody class="tabelaEspecialidade">
                        <?php foreach ($todasPerguntas->data as $k => $v) : ?>
                            <tr rel="<?php echo $v['id']; ?>">
                                <td><?php echo $v['id']; ?></td>
                                <td><?php echo $v['pergunta']; ?></td>
                                <td>
                                    <a href="/gerenciar/pergunta/alterar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Alterar</a> 
                                    <a onclick="removerGaleria(<?php echo $v['id']; ?>)" href="/gerenciar/pergunta/deletar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Deletar</a> 
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
                                <label for="id">id</label>
                                <input class="form-control id" name="id" value="<?php echo @$dadosAlterar->id; ?>" readonly="" />
                                <label for="pergunta">Pergunta</label>
                                <input value="<?php echo @$dadosAlterar->pergunta; ?>" class="form-control pergunta" name="pergunta" />
                                <label for="resposta">Resposta</label>
                                <input value="<?php echo @$dadosAlterar->resposta; ?>" class="form-control resposta" name="resposta" />                      
                                <input type="hidden" class="id" name="status" value="1">
                                <button type="submit" class="btn btn-default adicionar">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
