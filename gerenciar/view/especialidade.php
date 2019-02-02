<?php //header("Content-type: text/html; charset=utf-8");

require_once("model/especialidade.php");
$especialidade = new EspecialidadeModel();
?>

<?php if(@$_GET['medico'] <= 0): ?>

<?php
if(@$_GET['deletar']!=""){
	$especialidade->delete($_GET['deletar']);
}

if(@$_POST['nome']!=""){
	$especialidade->save();
}
if(isset($_GET['alterar'])):
	$dadosAlterar = $especialidade->BuscarPorCOD($_GET['alterar'])->data;
endif;
$todasEspecialidades = $especialidade->BuscarTodos();
?>
	<div class="content-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h4 class="page-head-line">Especialidade</h4>
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
								<th>Especialidade</th>
								<th>Opções</th>
							</tr>
						</thead>
						<tbody class="tabelaEspecialidade">
							<?php foreach ($todasEspecialidades->data as $k => $v) : ?>
								<tr rel="<?php echo $v['id']; ?>">
									<td><?php echo $v['id']; ?></td>
									<td><?php echo $v['nome']; ?></td>
									<td>
										 <a href="/gerenciar/especialidade/alterar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Alterar</a> 
										<a href="/gerenciar/especialidade/deletar/<?php echo $v['id']; ?>" class="btn btn-xs btn-danger"  >Deletar</a> </td>
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
									<?php if(@$dadosAlterar->id>0): ?>
										<label for="inputCep">Id</label>
										<input class="form-control id" name="id" value="<?php echo @$dadosAlterar->id; ?>" readonly="" /><br/>
									<?php endif; ?>
									<label for="inputCep">Especialidade</label>
									<input class="especialidade" name="nome" value="<?php echo @$dadosAlterar->nome; ?>">
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
		$todasEspecialidades = $especialidade->BuscarTodos();

		// ordenando itens
		foreach ($todasEspecialidades->data as $ke => $ve) :
			$info[] = $ve['nome'].'-'.$ve['id'];
		endforeach;
		sort($info);
		foreach ($info as $ki => $vi) :
			unset($aux);
			$aux = explode('-', $vi); 
			$info2[$ki]['id'] = $aux[1]; 
			$info2[$ki]['nome'] = $aux[0];
		endforeach;
		unset($todasEspecialidades->data);
		$todasEspecialidades->data = $info2;

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
								<a href="/gerenciar/convenio/medico/<?php echo $_GET['medico']; ?>"  class="btn btn-xs btn-info"  >+ Convenio</a> 
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
								<th>Especialidade</th>
								<th>Opções</th>
							</tr>
						</thead>
						<tbody class="tabelaEspecialidade">
							<?php foreach ($dadosMedico->especialidade as $k => $v) : ?>
								<tr rel="<?php echo $v['id']; ?>">
									<td><?php echo $v['id']; ?></td>
									<td><?php echo $v['nome']; ?></td>
									<td>
										<a onclick="removerEspecialidade(<?php echo $v['id']; ?>,<?php echo $_GET['medico']; ?>)" class="btn btn-xs btn-danger"  >Deletar</a> </td>
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
									<label for="inputCep">Especialidade</label>
									<input type="hidden" class="idMedico" name="idMedico" value="<?php echo ($_GET['medico']); ?>" />
									<select class="especialidade" name="especialidade_id">
										<option> Selecione uma especialidade</option>
										<?php foreach ($todasEspecialidades->data as $kEsp => $vEsp) : ?>
											<option rel="<?php echo $vEsp['id']; ?>" value="<?php echo $vEsp['id']; ?>"><?php echo $vEsp['nome']; ?></option>    
										<?php endforeach; ?>
									</select>
									<button type="button" class="btn btn-default adicionarEspecialidade">Adicionar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
