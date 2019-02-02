<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../vendor/autoload.php';

if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	
	$token = $_SESSION['access_token']['access_token'];

	if(@$_POST['btnFiltrar']=="Filtrar"):
		$url = RelatorioController::montaQuery($_POST, $token);
	else:
		$datainicial = "2017-03-01";
		$datafinal   = "2017-03-08";
		$filter      = "marcelo";
		$url  = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A142173175&start-date=$datainicial&end-date=$datafinal&metrics=ga%3AtotalEvents&dimensions=ga%3AeventCategory%2Cga%3AeventAction%2Cga%3AeventLabel&sort=-ga%3AeventLabel&max-results=1000&access_token=$token";
	endif;

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url
	));

	$retorno = curl_exec($curl);
	curl_close($curl);

	$retornoArray  = json_decode($retorno, true);
	$retornoObject = json_decode($retorno);

	if(@$retornoArray['error']['code']==401){
		$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/listamed-back/gerenciar/oauth2callback.php';
		header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
	}

} else {
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/listamed-back/gerenciar/oauth2callback.php';
	header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}

if($retornoArray['totalResults'] >= $retornoArray['query']['max-results']){
	$exibindo = $retornoArray['query']['max-results'];
	$paginas  = ceil($retornoArray['totalResults']/$retornoArray['query']['max-results']);
}else{
	$exibindo = $retornoArray['totalResults'];        
}
?>

<div class="content-wrapper">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h4 class="page-head-line">Relatórios</h4>
			</div>
		</div>
		<form class="form-inline" action="" method="post">
			<fieldset>
				<div class="form-group">
					<label class="control-label input-label" for="startTime">Data Inicio:</label><br/>
					<input class="form-control" type="text" class="datetime" type="text" id="data_inicial" name="startTime" placeholder="Start Time" />
				</div>
				<div class="form-group">
					<label class="control-label input-label" for="startTime">Data Final:</label><br/>
					<input class="form-control" type="text" class="datetime" type="text" id="data_final" name="data_final" placeholder="Start Time" />
				</div>
				<div class="form-group">
					<label class="control-label input-label" for="startTime">Tipo de busca:</label>
					<br/><select class="form-control tipoBusca" name="tipo_busca" id="tipoBusca">
						<option value="1"> Pagina </option>
						<option value="2"> Ação </option>
						<option value="3"> Rotulo </option>
					</select>
				</div>					
				<div class="form-group" id="boxCategoria" style="">
					<label class="control-label input-label" for="startTime">Escolha a pagina:</label>
					<br/><select class="form-control" name="pagina" >
						<option value=""> Selecione uma opção </option>
						<option value="perfil"> Perfil </option>
						<option value="medicos"> Medicos </option>
					</select>		
				</div>
				<div class="form-group" id="boxAcao" style="">
					<label class="control-label input-label" for="startTime">Escolha a ação:</label>
					<br/><select class="form-control" name="acao">
						<option value=""> Selecione uma opção </option>
						<option value="Ver Telefone"> Ver Telefone </option>
						<option value="Ver Site"> Ver Site </option>
					</select>
				</div>
				<div class="form-group" id="boxRotulo" style="">
					<label class="control-label input-label" for="startTime">Rótulo:</label><br/>
					<input class="form-control" type="text" name="rotulo">
				</div>		
				<input name="btnFiltrar" value="Filtrar" type="submit" />		
			</fieldset>
		</form>

		Exibindo <?php echo $exibindo; ?> resultados de <?php echo @RelatorioController::converteData($retornoArray['query']['start-date'],'show'); ?> até <?php echo @RelatorioController::converteData($retornoArray['query']['end-date'],'show'); ?> 
		<?php if(@$retornoArray['query']['filters']!="") :?>
			filtrando por <?php echo $retornoArray['query']['filters']; ?>
		<?php endif; ?>
		<br/>
		Total de <?php echo $retornoArray['totalsForAllResults']['ga:totalEvents']; ?> itens, começando de <?php echo $retornoArray['query']['start-index']; ?> até <?php echo $retornoArray['query']['max-results']; ?> 

		<table id="dataTable" class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>Categoria</th>
					<th>Ação</th>
					<th>Rotulo</th>
					<th>Total de eventos</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($retornoArray['rows'] as $k => $v) : ?>
					<tr>
						<td><?php echo $v[1] ?></td>
						<td><?php echo $v[0] ?></td>
						<td><?php echo $v[2] ?></td>
						<td><?php echo $v[3] ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>