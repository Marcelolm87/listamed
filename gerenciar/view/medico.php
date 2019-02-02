<?php //header("Content-type: text/html; charset=utf-8"); 

require_once("model/estado.php");
$estadoModel = new EstadoModel();
$todosEstados = $estadoModel->BuscarTodos();

/*require_once("model/especialidade.php");
$especialidade = new EspecialidadeModel();
$todasEspecialidades = $especialidade->BuscarTodos();
*/
$nomeArquivo = null; 

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

    file_put_contents('upload/profissionais/'.$nomeArquivo_save, $data);
}

// se upload foi feito
if(@$_FILES['foto']):
endif;

if(@$_GET['deletar']>0):
    $obj->delete( $_GET['deletar'], false);
endif;

// retorna as informações
if(@$_GET['editar']!=""):
    $dadosEditar = MedicoModel::retornoFull($obj->BuscarPorCOD($_GET['editar']));
endif;

/* cria uma informação */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obj->save(null, $nomeArquivo_save);
    if(@$_GET['editar']!=""):
        $dadosEditar = MedicoModel::retornoFull($obj->BuscarPorCOD(@$_GET['editar']));
    endif;
//$valor = $obj->save();    
}

/* deleta uma informação */
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    if($_GET['id']!=""):
        $valor = $obj->BuscarPorCOD($_GET['id'], false);    

        require_once("model/endereco.php");
        $enderecoModel = new EnderecoModel();
        $enderecoModel->delete($valor->tb_endereco_id, 'false');

        $valor = $obj->delete($valor);
    else:
        $erro = array ("erro" => "Não foi possivel deletar o registro");
        echo json_encode($erro);
    endif;
}
$valor = $obj->BuscarTodos();
?>
<div class="content-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 class="page-head-line">Medicos</h4>
            </div>
        </div>
        <?php include("notificacao.php"); ?>

        <!-- INICIO FORMULARIO -->
        <div class="row ">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading painel-formulario-botao">
                        <?php echo (isset($_GET['editar'])) ? "EDITAR" : "INSERIR"; ?>
                    </div>
                    <div class="panel-body painel-formulario">
                        <?php if(isset($_GET['editar'])): ?>
                            <form action="/gerenciar/medico/editar/<?php echo $_GET['editar']; ?>" method="post" enctype="multipart/form-data">
                        <?php else: ?>
                            <form action="/gerenciar/medico/" method="post" enctype="multipart/form-data">
                        <?php endif; ?>
                            <?php if (isset($_GET['editar'])) : ?>
                                <?php 
                                    $especialidade = $dadosEditar->especialidade;
                                    $dadosEditar   = $dadosEditar->data;
                                ?>
                                    <?php if(@$_GET['editar']>0): ?>
                                          <a href="/gerenciar/especialidade/medico/<?php echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Especialidade</a> 
                                        | <a href="/gerenciar/convenio/medico/<?php echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Convenio</a> 
                                        | <a href="/gerenciar/consultorio/medico/<?php echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Consultorio</a> 
                                        <!-- | <a href="/gerenciar/experiencia/medico/<?php //echo $_GET['editar']; ?>"  class="btn btn-xs btn-info"  >+ Formação</a>  -->
                                    <?php endif; ?>
                                <div class="form-group">
                                    <label for="inputID">Id</label>
                                    <input type="text" readonly name="id" class="idMedico form-control" id="inputID" placeholder="ID" <?php if(isset($dadosEditar->id)) : echo "value='".$dadosEditar->id."'"; endif;?> />
                                </div>
                            <?php else: ?>
                                <input type="hidden" name="id" class="idMedico form-control" id="inputID" />
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="inputNome">Nome</label>
                                <input type="text" name="nome" class="form-control" id="inputNome" placeholder="Nome" <?php if(isset($dadosEditar->nome)) : echo "value='".$dadosEditar->nome."'"; endif;?> />
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <label for="inputFoto">Foto (195px x 195x)</label><br/>
                                    <?php if(isset($dadosEditar->imagem)) : echo "<img src='/gerenciar/upload/profissionais/$dadosEditar->imagem' style='max-widht:100px; max-height:100px;'  />"; endif;?>
                                    <input type="file" name="foto" id="upload" value="Choose a file" accept="image/*" />
                                    <input type="hidden" id="imagebase64" name="imagebase64">
                                    <button type="button" class="upload-result">Cortar</button>
                                </div>
                                <div class="col-lg-6 col-md-6">
                                    <div class="upload-demo-wrap">
                                        <div id="upload-demo"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputCrm">Crm</label>
                                <input type="text" name="crm" class="form-control" id="inputCrm" placeholder="Crm" <?php if(isset($dadosEditar->crm)) : echo "value='".$dadosEditar->crm."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputEspecialidade">Especialista em:</label>
                                <input type="text" name="especialidade_text" class="form-control" id="inputEspecialidade" placeholder="Especialidade" <?php if(isset($dadosEditar->especialidade_text)) : echo "value='".$dadosEditar->especialidade_text."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputEmail">Email</label>
                                <input type="text" name="email" class="form-control" id="inputEmail" placeholder="Email" <?php if(isset($dadosEditar->email)) : echo "value='".$dadosEditar->email."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputSite">Site</label>
                                <div class="input-group">
                                    <div class="input-group-addon">http://</div>
                                    <input type="text" name="site" class="form-control" id="inputSite" placeholder="www.dominio.com.br" <?php if(isset($dadosEditar->site)) : echo "value='".$dadosEditar->site."'"; endif;?> />
                                </div>
                            </div>
                            <hr/>
                            <div class="form-group">
                            <input type="hidden" name="tb_endereco_id" <?php if(isset($dadosEditar->tb_endereco_id)) : echo "value='".$dadosEditar->tb_endereco_id."'"; endif;?> />
                                <label for="inputEndereco">Endereço</label>
                                <input type="text" name="endereco[endereco]" class="form-control" id="inputEndereco" placeholder="Endereço" <?php if(isset($dadosEditar->endereco)) : echo "value='".$dadosEditar->endereco."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputNumero">Numero</label>
                                <input type="text" name="endereco[numero]" class="form-control" id="inputNumero" placeholder="Numero" <?php if(isset($dadosEditar->numero)) : echo "value='".$dadosEditar->numero."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputBairro">Bairro</label>
                                <input type="text" name="endereco[bairro]" class="form-control" id="inputBairro" placeholder="Bairro" <?php if(isset($dadosEditar->bairro)) : echo "value='".$dadosEditar->bairro."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputCep">Cep</label>
                                <input type="text" name="endereco[cep]" class="form-control" id="inputCep" placeholder="Cep" <?php if(isset($dadosEditar->cep)) : echo "value='".$dadosEditar->cep."'"; endif;?> />
                            </div>
                            <div class="form-group">
                                <label for="inputCep">Estado</label>
                                <select class="form-control estado" name="endereco[estado_id]">
                                    <option> Selecione um estado</option>
                                    <?php foreach ($todosEstados->data as $kEst => $vEst) : ?>
                                        <option <?php if($vEst['id'] == @$dadosEditar->tb_estado_id){ echo "SELECTED"; } ?> rel="<?php echo $vEst['id']; ?>" value="<?php echo $vEst['id']; ?>"><?php echo $vEst['sigla']; ?></option>    
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="inputCep">Cidade</label>
                                <select class="form-control cidade" name="endereco[tb_cidade_id]">
                                    <?php if($dadosEditar->tb_cidade_id > 0){ ?>
                                        <option value="<?php echo $dadosEditar->tb_cidade_id; ?>"> <?php echo $dadosEditar->cidade; ?> </option>
                                    <?php }else{ ?>
                                        <option> Selecione uma cidade</option>
                                    <?php } ?>

                                </select>
                            </div>
                            <hr/>
                            <div class="form-group">
                                <label for="inputTelefone">Telefone</label>
                                <input type="text" name="telefone" class="form-control" id="inputTelefone" placeholder="Telefone" <?php if(isset($dadosEditar->telefone)) : echo "value='".$dadosEditar->telefone."'"; endif;?> />
                                <input type="text" name="whatsapp" class="form-control" id="inputTelefone" placeholder="whatsapp" <?php if(isset($dadosEditar->whatsapp)) : echo "value='".$dadosEditar->whatsapp."'"; endif;?> />
                            </div>
                            <hr/>
                            <label for="inputCep">Status</label>
                            <select class="form-control status" name="status">
                                <option value="0"> Selecione um status</option>
                                <option <?php if(1 == @$dadosEditar->status){ echo "SELECTED"; } ?> value="1">Ativado</option>    
                                <option <?php if(0 == @$dadosEditar->status){ echo "SELECTED"; } ?> value="0">Desativado</option>   
                            </select><br/>

                            <hr/>
                            <label for="inputRedes">Redes Sociais</label>
                            
                            <div style="margin: 5px 0;" class="input-group">
                                <div class="input-group-addon">http://facebook.com/</div>
                                <input type="text" <?php if(isset($dadosEditar->facebook)) : echo "value='".$dadosEditar->facebook."'"; endif;?> name="facebook" class="form-control" id="inputFacebook" placeholder="Facebook" <?php if(isset($dadosEditar->social->facebook)) : echo "value='".$dadosEditar->social->facebook."'"; endif;?> />
                            </div>
                            <div style="margin: 5px 0;" class="input-group">
                                <div class="input-group-addon">http://instagram.com/</div>
                                <input type="text" <?php if(isset($dadosEditar->instagram)) : echo "value='".$dadosEditar->instagram."'"; endif;?> name="instagram" class="form-control" id="inputInstagram" placeholder="Instagram" <?php if(isset($dadosEditar->social->instagram)) : echo "value='".$dadosEditar->social->instagram."'"; endif;?> />
                            </div>
                            <div style="margin: 5px 0;" class="input-group">
                                <div class="input-group-addon">http://twitter.com/</div>
                                <input type="text" <?php if(isset($dadosEditar->twitter)) : echo "value='".$dadosEditar->twitter."'"; endif;?> name="twitter" class="form-control" id="inputTwitter" placeholder="Twitter" <?php if(isset($dadosEditar->social->twitter)) : echo "value='".$dadosEditar->social->twitter."'"; endif;?> />
                            </div>
                            <hr/>
                            <label for="inputTexto">Formação e Experiencia</label>
                            <textarea id="texto" class="form-control"  name="texto"> <?php if(isset($dadosEditar->texto)) : echo $dadosEditar->texto; endif;?> </textarea>
                            <br/>
                            <div class="form-group">
                                <label for="inputTelefone">Periodo</label><br/>
                                <?php $periodos = explode(',', $dadosEditar->periodo); ?>
                                <input type="checkbox" <?php if(in_array("manha",$periodos)): echo "CHECKED"; endif; ?> name="periodo[manha]" /> Manhã<br/>
                                <input type="checkbox" <?php if(in_array("tarde",$periodos)): echo "CHECKED"; endif; ?> name="periodo[tarde]" /> Tarde<br/>
                                <input type="checkbox" <?php if(in_array("noite",$periodos)): echo "CHECKED"; endif; ?> name="periodo[noite]" /> Noite<br/>
                            </div>
                            <div class="form-group">
                                <label for="inputEmailAgenda">Emails para receber agendamento (separe por virgula. Ex: mail@mail.com,mail2@mail.com ):</label><br/>
                                <input type="text" <?php if(isset($dadosEditar->agenda_email)) : echo "value='".$dadosEditar->agenda_email."'"; endif;?> name="agenda_email" class="form-control" id="inputAgendaEmail" placeholder="Email" />
                            </div>
                            <div class="form-group">
                                <label for="inputEmailAgenda">Telefones para receber agendamento (separe por virgula. Ex: 18981470000,18981470001):</label><br/>
                                <input type="text" <?php if(isset($dadosEditar->agenda_telefone)) : echo "value='".$dadosEditar->agenda_telefone."'"; endif;?> name="agenda_telefone" class="form-control" id="inputAgendaTelefone" placeholder="Telefone" />
                            </div>
                            <!-- <div class="form-group">
                                <label for="inputDesconto">Desconto:</label><br/>
                                <input readonly=""> type="text" <?php if(isset($dadosEditar->desconto)) : echo "value='".$dadosEditar->desconto."'"; endif;?> name="desconto" class="form-control" id="inputDesconto" placeholder="Desconto" />
                            </div> -->
                            <div class="form-group">
                                <label for="inputLinkArtigo">Link Artigo:</label><br/>
                                <input type="text" <?php if(isset($dadosEditar->link_artigo)) : echo "value='".$dadosEditar->link_artigo."'"; endif;?> name="link_artigo" class="form-control" id="inputLinkArtigo" placeholder="Link dos artigo" />
                            </div>
                            
                            <div class="form-group">
                                <label for="inputLinkArtigo">Destaque:</label><br/>
                                <select name="destaque" class="form-control">

                                    <option value="0"  <?php if(@$dadosEditar->destaque==0): ?> SELECTED <?php endif; ?> >Desativado</option>
                                    <option value="1"  <?php if(@$dadosEditar->destaque==1): ?> SELECTED <?php endif; ?> >Ativado</option>

                                </select>
                            </div>
                            <label for="inputTexto">Depoimento</label>
                            <textarea id="texto2" class="form-control"  name="depoimento"> <?php if(isset($dadosEditar->depoimento)) : echo $dadosEditar->depoimento; endif;?> </textarea>
                            <br/>

                            <button type="submit" class="btn btn-default">Salvar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- FIM FORMULARIO -->

        <!-- INICIO TABELA -->
        <div class="row" id="rowTabela">
            <div class="col-md-12">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Nome</th>
                            <th>CRM</th>
                            <th>Opções</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($valor->data as $k => $v) : ?>
                            <tr>
                            <td><?php echo $v['id']; ?></td>
                            <td><?php echo $v['nome']; ?></td>
                            <td><?php echo $v['crm']; ?></td>
                            <td>
                                <a href="/gerenciar/especialidade/medico/<?php echo $v['id']; ?>"  class="btn btn-xs btn-info"  >+ Especialidade</a> 
                            |   <a href="/gerenciar/convenio/medico/<?php echo $v['id']; ?>"  class="btn btn-xs btn-info"  >+ Convenio</a> 
                            |   <a href="/gerenciar/consultorio/medico/<?php echo $v['id']; ?>"  class="btn btn-xs btn-info"  >+ Consultorio</a> 
                           <!--  |   <a href="/gerenciar/experiencia/medico/<?php //echo $v['id']; ?>"  class="btn btn-xs btn-info"  >+ Formação</a>  -->
                            |   <a href="/gerenciar/medico/editar/<?php echo $v['id']; ?>"  class="btn btn-xs btn-danger"  >Editar</a> 
                            |   <a href="/gerenciar/medico/deletar/<?php echo $v['id']; ?>"  class="btn btn-xs btn-danger"  >Deletar</a> </td>
                            </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- FIM TABELA -->
        
        <a href="/gerenciar/medico" class="btn btn-xs btn-danger" style="float: right;" >Novo Registro</a>
    </div>
</div>
<!-- CONTENT-WRAPPER SECTION END-->
<style type="text/css">
    .croppie-container {
        width: 100%;
        height: 250px;
    }
</style>

