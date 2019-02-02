<?php //header("Content-type: text/html; charset=utf-8"); 

require_once("model/experiencia.php");
$experiencia = new ExperienciaModel();

if(@$_GET['medico'] > 0): 
    if(@$_GET['deletar']!=""){ $experiencia->delete($_GET['deletar'],false); }
    if(@$_POST['nome']!=""){ 
        $experiencia->save(); 
    }
    $todasExperiencias = $experiencia->BuscarPorCODMedico($_GET['medico']);

    if(@$_GET['editar']>0):
        // retorna as informações
        $dadosEditar = $obj->BuscarPorCOD($_GET['editar']);
    endif;
else:
	header("Location: /gerenciar/medico");
endif;
?>

<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Experiencias</h4>
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
                            <th>Nome</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody class="tabelaConsultorio">
                        <?php if (!empty($todasExperiencias)) : ?>
                            <?php foreach ($todasExperiencias as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a onclick="removerExperiencia(<?php echo $v['id']; ?>,<?php echo $_GET['medico']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            Nenhuma experiencia cadastrada!
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
                        <form action="#" method="post">
                            <div class="form-group">
                                <label for="inputNome">Nome</label><br/>
                                <input class="form-control experiencia" for="inputNome" value="<?php echo @$dadosEditar->data->nome; ?>" name="nome"><br/>
                                <label for="inputDescricao">Descrição</label><br/>
                                <input class="form-control experiencia" for="inputDescricao" value="<?php echo @$dadosEditar->data->descricao; ?>" name="descricao"><br/>
                                <label for="inputTitulo">Titulo</label><br/>
                                <input class="form-control experiencia" for="inputTitulo" value="<?php echo @$dadosEditar->data->titulo; ?>" name="titulo"><br/>
                                <label for="inputOrientador">Orientador</label><br/>
                                <input class="form-control experiencia" for="inputOrientador" value="<?php echo @$dadosEditar->data->orientador; ?>" name="orientador"><br/>
                                <label for="inputDescricao">Data Inicio</label><br/>
                                <input class="form-control experiencia" for="inputDescricao" value="<?php echo @$dadosEditar->data->datainicio; ?>" name="datainicio"><br/>
                                <label for="inputDescricao">Data fim</label><br/>
                                <input class="form-control experiencia" for="inputDescricao" value="<?php echo @$dadosEditar->data->datafim; ?>" name="datafim"><br/>
                                <label for="inputDescricao">Local</label><br/>
                                <input class="form-control experiencia" for="inputDescricao" value="<?php echo @$dadosEditar->data->local; ?>" name="local"><br/>
                                <input type="hidden" value="<?php echo $_GET['medico']; ?>" name="tb_medico_id">


                                <button type="submit" class="btn btn-default adicionarExperiencia">Adicionar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
