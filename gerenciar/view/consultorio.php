<?php 
//header("Content-type: text/html; charset=utf-8"); 
require_once("model/consultorio.php");

$consultorio = new ConsultorioModel();

if(isset($_POST['imagebase64'])&&(@$_POST['imagebase64']!=null)){
    $data = $_POST['imagebase64'];

    list($type, $data) = explode(';', $data);
    list(, $data)      = explode(',', $data);
    $data = base64_decode($data);

    $nomeArquivo = md5(uniqid()) . '-' . time();

    if ( $type == "data:image/png" ) :
        $nomeArquivo_save .= $nomeArquivo.'.png';
    elseif ( $type == "data:image/gif" ) :
        $nomeArquivo_save .= $nomeArquivo.'.gif';
    elseif ( $type == "data:image/jpeg" ) :
        $nomeArquivo_save .= $nomeArquivo.'.jpg';
    endif;

    file_put_contents('upload/consultorio/'.$nomeArquivo_save, $data);
}

if ( (@$_GET['medico'] <= 0) && ((@$_GET['consultorio']<=0))): 
    if(@$_GET['deletar']!=""){ $consultorio->delete($_GET['deletar'],false); }
    if(@$_POST['nome']!=""){ 





        $consultorio->save('POST', $nomeArquivo_save);
    }
    $todasConsultorios = $consultorio->BuscarTodos();

    if(@$_GET['editar']>0):
        // retorna as informações
        $dadosEditar = $obj->BuscarPorCOD($_GET['editar']);
    endif;
?>
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line">Centro Médico</h4>
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
                                <th>Consultorio</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConsultorio">
                            <?php foreach ($todasConsultorios->data as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a href="/gerenciar/servico/consultorio/<?php echo $v['id']; ?>" class="btn btn-xs btn-info"  >+ Serviço</a>
                                        <a href="/gerenciar/galeria/consultorio/<?php echo $v['id']; ?>" class="btn btn-xs btn-info"  >Galeria</a>
                                        <a href="/gerenciar/convenio/consultorio/<?php echo $v['id']; ?>" class="btn btn-xs btn-info"  >Convenio</a>
                                        <a href="/gerenciar/consultorio/editar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Editar</a>
                                        <a href="/gerenciar/consultorio/deletar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Deletar</a> 
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
                                    <?php if(@$_GET['editar']!=""): ?>
                                        <input type="hidden" class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->id; ?>" name="id"><br/>
                                        <input type="hidden" class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->tb_endereco_id; ?>" name="tb_endereco_id"><br/>
                                    <?php endif; ?>
                                    <label for="inputNome">Consultorio</label><br/>
                                    <input class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->nome; ?>" name="nome"><br/>

                                    <div class="row">
                                        <div class="col-lg-6 col-md-6">
                                            <label for="inputFoto">Foto (195px x 195x)</label><br/>
                                            <?php if(isset($dadosEditar->data->imagem)) : echo "<img src='/gerenciar/upload/consultorio/".$dadosEditar->data->imagem."' style='max-widht:100px; max-height:100px;'  />"; endif; ?>
                                            <input type="file" name="foto" id="upload" value="Choose a file" accept="image/*" />
                                            <input type="hidden" id="imagebase64" name="imagebase64">
                                            <button type="button" class="upload-result">Cortar</button>
                                        </div>
                                        <div class="col-lg-6 col-md-6">
                                            <div class="upload-demo-wrap" style="height: 255px;">
                                                <div id="upload-demo"></div>
                                            </div>
                                        </div>
                                    </div>

                                    <label for="inputEndereco">Endereco</label><br/>
                                    <input class="form-control consultorio" for="inputEndereco" value="<?php echo @$dadosEditar->data->endereco; ?>" name="endereco[endereco]"><br/>
                                    <label for="inputNumero">Numero</label><br/>
                                    <input class="form-control consultorio" for="inputNumero" value="<?php echo @$dadosEditar->data->numero; ?>" name="endereco[numero]"><br/>
                                    <label for="inputBairro">Bairro</label><br/>
                                    <input class="form-control consultorio" for="inputBairro" value="<?php echo @$dadosEditar->data->bairro; ?>" name="endereco[bairro]"><br/>
                                    <label for="inputCep">Cep</label><br/>
                                    <input class="form-control consultorio" for="inputCep" value="<?php echo @$dadosEditar->data->cep; ?>" name="endereco[cep]"><br/>
                                    <?php
                                        require_once("model/estado.php");
                                        $estadoModel = new EstadoModel();
                                        $todosEstados = $estadoModel->BuscarTodos();
                                    ?>
                                    <div class="form-group">
                                        <label for="inputEstado">Estado</label>
                                        <select class="form-control estado" name="endereco[estado_id]">
                                            <option> Selecione um estado</option>
                                            <?php foreach ($todosEstados->data as $kEst => $vEst) : ?>
                                                <option <?php if($vEst['id'] == @$dadosEditar->data->tb_estado_id){ echo "SELECTED"; } ?> rel="<?php echo $vEst['id']; ?>" value="<?php echo $vEst['id']; ?>"><?php echo $vEst['sigla']; ?></option>    
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCep">Cidade</label>
                                        <select class="form-control cidade" name="endereco[tb_cidade_id]">
                                            <?php
                                             if($dadosEditar->data->tb_cidade_id > 0){ ?>
                                                <option value="<?php echo $dadosEditar->data->tb_cidade_id; ?>"> <?php echo $dadosEditar->data->cidade; ?> </option>
                                            <?php }else{ ?>
                                                <option> Selecione uma cidade</option>
                                            <?php } ?>

                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDesc">Descrição</label>
                                        <textarea class="form-control" name="descricao"><?php echo $dadosEditar->data->descricao; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSite">Site</label>
                                        <input type="text" class="form-control" name="site" value="<?php echo $dadosEditar->data->site; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail">Email</label>
                                        <input type="text" class="form-control" name="email" value="<?php echo $dadosEditar->data->email; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputTelefone">Telefone</label>
                                        <input type="text" class="form-control" name="telefone" value="<?php echo $dadosEditar->data->telefone; ?>" />
                                    </div>
                                    <div class="form-group">
                                        <label for="inputTelefone">Status</label>
                                        <select class="form-control" name="status">
                                            <option value="0">Selecione um status</option>                                                    
                                            <option value="0" <?php if($dadosEditar->data->status==0) echo "SELECTED" ;?> >Desativado</option>                                                    
                                            <option value="1" <?php if($dadosEditar->data->status==1) echo "SELECTED" ;?> >Ativado</option>                                                    
                                        </select>
                                    </div>
  <!--                                   <div class="form-group">
                                        <label for="inputTelefone">Periodo</label><br/>
                                        <input type="checkbox" name="periodo[manha]" /> Manhã<br/>
                                        <input type="checkbox" name="periodo[tarde]" /> Tarde<br/>
                                        <input type="checkbox" name="periodo[noite]" /> Noite<br/>
                                    </div> -->

                                    <button type="submit" class="btn btn-default adicionarConsultorio">Adicionar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php elseif(@$_GET['consultorio']>0) :

// -------------------------------------------------------------------------------------------------------------------------------------------------

















/*    if(@$_POST['nome']!=""){ 
        $retorno = $consultorio->save('POST', $nomeArquivo_save);
        $ultimoID = $consultorio->BuscarUltimaID();

        $retorno = MedicoModel::saveMedicoConsultorio($ultimoID->id, $_GET['medico']);
    }
*/
/*    require_once("model/medico.php");
    $medicoModel = new MedicoModel();
    $todosMedicos = $medicoModel->BuscarTodos();
*/
    $todosMedicos = $consultorio->BuscarPorCODConsultorio($_GET['consultorio']);
echo "<pre>"; print_r('------------- inicio var: todosMedicos -------------'); echo "</pre>";
echo "<pre>"; print_r($todosMedicos); echo "</pre>";
echo "<pre>"; print_r('------------- final  var: todosMedicos -------------'); echo "</pre>";

    require_once("model/medico.php");
    //$medicoModel = new MedicoModel();
   // $dadosMedico = MedicoModel::retornoFull($medicoModel->BuscarPorCOD($_GET['medico']));
?>

 <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4 class="page-head-line"><?php echo $dadosMedico->data->nome; ?>
                        <?php if(@$_GET['medico']>0): ?>
                            <div style="float:right;">
                                 <a href="/gerenciar/especialidade/medico/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >+ Especialidade</a> 
                                | <a href="/gerenciar/convenio/medico/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >+ Convenio</a> 
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
                                <th>Médicos</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConsultorio">
                            <?php foreach ($todosMedicos as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['tb_medico_id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a onclick="removerMedicoConsultorio(<?php echo $v['id']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a>
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
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">NOME</div>
                                            <input class="form-control nomeBuscar" type="text" name="cep" value="" style="width: 50%; float:left;" />
                                            <input type="button" class="btnCep btn btn-primary" name="btnCep" value="Ok" />
                                        </div>
                                    </div>
                                    <input type="hidden" class="idMedico" name="idMedico" value="<?php echo ($_GET['medico']); ?>" />
                                    <div class="exibirConsultorios">
                                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Médico</th>
                                                    <th>Opções</th>
                                                </tr>
                                            </thead>
                                            <tbody class="ulExibirConsultorio">
 
                                            </tbody>
                                        </table>

                                    </div>


                                    <div class="formConsultorios">
                                        <div class="form-group">
                                            <label for="inputNome">Consultorio</label><br/>
                                            <?php if(@$_GET['editar']!=""): ?>
                                                <input type="hidden" class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->id; ?>" name="id"><br/>
                                                <input type="hidden" class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->tb_endereco_id; ?>" name="tb_endereco_id"><br/>


                                          <a href="/gerenciar/servico/consultorio/<?php echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Serviço</a> 
                                        | <a href="/gerenciar/consultorio/medico/<?php echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Convenio</a> 
                                        | <a href="/gerenciar/consultorio/medico/<?php echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Consultorio</a> 
                                        <!-- | <a href="/gerenciar/experiencia/medico/<?php //echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Formação</a>  -->



                                            <?php endif; ?>
                                            <input class="form-control consultorio" for="inputNome" value="<?php echo @$dadosEditar->data->nome; ?>" name="nome">
                                                    
                                            <div class="row">
                                                <div class="col-lg-6 col-md-6">
                                                    <label for="inputFoto">Foto (195px x 195x)</label><br/>
                                                    <?php if(isset($dadosEditar->data->imagem)) : echo "<img src='/gerenciar/upload/consultorio/".$dadosEditar->data->imagem."' style='max-widht:100px; max-height:100px;'  />"; endif; ?>
                                                    <input type="file" name="foto" id="upload" value="Choose a file" accept="image/*" />
                                                    <input type="hidden" id="imagebase64" name="imagebase64">
                                                    <button type="button" class="upload-result">Cortar</button>
                                                </div>
                                                <div class="col-lg-6 col-md-6">
                                                    <div class="upload-demo-wrap" style="height: 255px;">
                                                        <div id="upload-demo"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <label for="inputEndereco">Endereco</label><br/>
                                            <input class="form-control consultorio" for="inputEndereco" value="<?php echo @$dadosEditar->data->endereco; ?>" name="endereco[endereco]">
                                            <label for="inputNumero">Numero</label><br/>
                                            <input class="form-control consultorio" for="inputNumero" value="<?php echo @$dadosEditar->data->numero; ?>" name="endereco[numero]">
                                            <label for="inputBairro">Bairro</label><br/>
                                            <input class="form-control consultorio" for="inputBairro" value="<?php echo @$dadosEditar->data->bairro; ?>" name="endereco[bairro]">
                                            <input type="hidden" value="<?php echo @$dadosEditar->data->cep; ?>" name="endereco[cep]">
                                            <?php
                                                require_once("model/estado.php");
                                                $estadoModel = new EstadoModel();
                                                $todosEstados = $estadoModel->BuscarTodos();
                                            ?>
                                            <div class="form-group">
                                                <label for="inputEstado">Estado</label>
                                                <select class="form-control estado" name="endereco[estado_id]">
                                                    <option> Selecione um estado</option>
                                                    <?php foreach ($todosEstados->data as $kEst => $vEst) : ?>
                                                        <option <?php if($vEst['id'] == @$dadosEditar->data->tb_estado_id){ echo "SELECTED"; } ?> rel="<?php echo $vEst['id']; ?>" value="<?php echo $vEst['id']; ?>"><?php echo $vEst['sigla']; ?></option>    
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputCep">Cidade</label>
                                                <select class="form-control cidade" name="endereco[tb_cidade_id]">
                                                    <?php if($dadosEditar->tb_cidade_id > 0){ ?>
                                                        <option value="<?php echo $dadosEditar->data->tb_cidade_id; ?>"> <?php echo $dadosEditar->cidade; ?> </option>
                                                    <?php }else{ ?>
                                                        <option> Selecione uma cidade</option>
                                                    <?php } ?>

                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputDesc">Descrição</label>
                                                <textarea class="form-control" name="descricao"></textarea>
                                            </div>
                                            <div class="form-group">
                                                <label for="inputSite">Site</label>
                                                <input type="text" class="form-control" name="site" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputEmail">Email</label>
                                                <input type="text" class="form-control" name="email" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputTelefone">Telefone</label>
                                                <input type="text" class="form-control" name="telefone" />
                                            </div>
                                            <div class="form-group">
                                                <label for="inputTelefone">Status</label>
                                                <select class="form-control" name="status">
                                                    <option value="0">Selecione um status</option>                                                    
                                                    <option value="0">Desativado</option>                                                    
                                                    <option value="1">Ativado</option>                                                    
                                                </select>
                                            </div>
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





















<?php













// -------------------------------------------------------------------------------------------------------------------------------------------------


?>

<?php elseif(@$_GET['medico'] > 0): ?>
    <?php
        if(@$_POST['nome']!=""){ 
            $retorno = $consultorio->save('POST', $nomeArquivo_save);
            $ultimoID = $consultorio->BuscarUltimaID();
    
            require_once("model/medico.php");
            $retorno = MedicoModel::saveMedicoConsultorio($ultimoID->id, $_GET['medico']);
        }

        $todasConsultorios = $consultorio->BuscarTodos();
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
                                | <a href="/gerenciar/convenio/medico/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >+ Convenio</a> 
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
                                <th>Consultorio</th>
                                <th>Opções</th>
                            </tr>
                        </thead>
                        <tbody class="tabelaConsultorio">
                            <?php foreach ($dadosMedico->consultorio as $k => $v) : ?>
                                <tr rel="<?php echo $v['id']; ?>">
                                    <td><?php echo $v['id']; ?></td>
                                    <td><?php echo $v['nome']; ?></td>
                                    <td>
                                        <a onclick="removerConsultorio(<?php echo $v['id']; ?>,<?php echo $_GET['medico']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a>
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
                                    <div class="form-group">
                                        <div class="input-group">
                                            <div class="input-group-addon">NOME</div>
                                            <input class="form-control cepBuscar" type="text" name="cep" value="" style="width: 50%; float:left;" />
                                            <input type="button" class="btnCep btn btn-primary" name="btnCep" value="Ok" />
                                        </div>
                                    </div>
                                    <input type="hidden" class="idMedico" name="idMedico" value="<?php echo ($_GET['medico']); ?>" />
                                    <div class="exibirConsultorios">
                                        <table id="dataTable" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Id</th>
                                                    <th>Consultorio</th>
                                                    <th>Opções</th>
                                                </tr>
                                            </thead>
                                            <tbody class="ulExibirConsultorio">
 
                                            </tbody>
                                        </table>

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
