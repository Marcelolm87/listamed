<?php
require_once __DIR__ . '/../vendor/autoload.php';
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
	
	$token = $_SESSION['access_token']['access_token'];

	$data_inicial = (@$_POST['startTime']!="")    ? "&start-date=".date('Y-m-d', strtotime(RelatorioController::converteData($_POST['startTime'],'save'))) : "&start-date=".date('Y-m-d', strtotime('-15 days')) ;
	$data_final   = (@$_POST['data_final']!="")   ? "&end-date=".date('Y-m-d', strtotime(RelatorioController::converteData($_POST['data_final'],'save'))) : "&end-date=".date('Y-m-d') ;

	if(@$_POST['btnFiltrar']=="Filtrar"):
		$url = RelatorioController::montaQuery($_POST, $token);
	else:
		$url  = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A142173175$data_inicial$data_final&metrics=ga%3AtotalEvents&dimensions=ga%3AeventCategory%2Cga%3AeventAction%2Cga%3AeventLabel&sort=-ga%3AeventLabel&max-results=1000&access_token=$token";
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
		echo "Você não tem permissão para acessar esse conteudo, entre em contato com o administrador.";
		exit;
	}

	// TRAZENDO RESULTADOS DAS BUSCAS
	$url_busca  = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A142173175$data_inicial$data_final&metrics=ga%3AsearchUniques&dimensions=ga%3AsearchKeyword&max-results=1000&access_token=$token&sort=-ga%3AsearchUniques";

	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url_busca
	));

	$retorno_busca = curl_exec($curl);
	curl_close($curl);
	
	$retornoArray_busca  = json_decode($retorno_busca, true);
	$retornoObject_busca = json_decode($retorno_busca);
} else {
	$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gerenciar/oauth2callback.php';
	@header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
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
					<div class="input-group date">
						<label class="control-label input-label" for="startTime">Data Inicio:</label><br/>
						<input class="form-control" type="text" class="datetime" type="text" id="data_inicial" name="startTime" placeholder="Data inicial" />
					</div>
				</div>
				<div class="form-group">
					<div id="data_final_id"></div>
					<label class="control-label input-label" for="startTime">Data Final:</label><br/>
					<input class="form-control" type="text" class="datetime" type="text" id="data_final" name="data_final" placeholder="Data final" />
				</div>
				<div class="form-group" id="boxCategoria">
					<label class="control-label input-label" for="startTime">Escolha a pagina:</label>
					<br/><select class="form-control" name="pagina" >
						<option value=""></option>
						<option value="index">index</option>
						<option value="listagem"> listagem </option>
						<option value="profissiona"> profissional </option>
						<option value="centro"> centro </option>
					</select>		
				</div>
				<div class="form-group" id="boxAcao">
					<label class="control-label input-label" for="startTime">Escolha a ação:</label>
					<br/><select class="form-control" name="acao">
						<option value=""> Selecione uma opção </option>
						<option value="exibido"> exibido </option>
						<option value="clicado"> clicado </option>
						<option value="telefone"> telefone </option>
						<option value="site"> site </option>
						<option value="whatsapp"> whatsapp </option>
						<option value="agendamento"> agendamento </option>

					</select>
				</div>
				<div class="form-group" id="boxRotulo">
					<label class="control-label input-label" for="startTime">Rótulo:</label><br/>
					<input class="form-control" type="text" name="rotulo">
				</div>		
				<input name="btnFiltrar" class="btn btn-default" style="margin-top: 30px;" value="Filtrar" type="submit" />		
			</fieldset>
		</form>



<?php 
if((!empty($retornoArray))&&(@$retornoArray['totalResults']!=null)):

	if((@$retornoArray['totalResults'] >= @$retornoArray['query']['max-results'])&&(@$retornoArray['query']['max-results']!=null)){
		$exibindo = $retornoArray['query']['max-results'];
		$paginas  = ceil($retornoArray['totalResults']/$retornoArray['query']['max-results']);
	}else{
		$exibindo = $retornoArray['totalResults'];        
	}
?>

		<div class="info">

			Exibindo <?php echo $exibindo; ?> resultados de <?php echo @RelatorioController::converteData($retornoArray['query']['start-date'],'show'); ?> até <?php echo @RelatorioController::converteData($retornoArray['query']['end-date'],'show'); ?> 
			<?php if(@$retornoArray['query']['filters']!="") :?>
				filtrando por <?php echo $retornoArray['query']['filters']; ?>
			<?php endif; ?>
			<br/>
			Total de <?php echo $retornoArray['totalsForAllResults']['ga:totalEvents']; ?> itens, começando de <?php echo $retornoArray['query']['start-index']; ?> até <?php echo $retornoArray['query']['max-results']; ?> 

		</div>

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
						<td><?php echo $v[0] ?></td>
						<td><?php echo $v[1] ?></td>
						<td><?php echo $v[2] ?></td>
						<td><?php echo $v[3] ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php if(isset($retornoArray_busca['rows'])):?>
			<hr/>
			<table id="dataTable" class="table table-striped table-bordered table-hover">
				<thead>
					<tr>
						<th>Busca</th>
						<th>Total</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($retornoArray_busca['rows'] as $k => $v) : ?>
						<tr>
							<td><?php echo $v[0] ?></td>
							<td><?php echo $v[1] ?></td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	<?php else: ?>
		<p style="text-align:center; margin: 40px 0;">Não retornou nenhum resultado. </p>
	<?php endif; ?>
	<script type="text/javascript">
		function enviarEmail(){
			var email = document.getElementById("enviar_email").value;
			$.post( "ajax-enviar-email.php", {email: email, conteudo_email: '<?php echo $url; ?>' }).done(function( data ) {  
				alert( "Relatório enviado com sucesso!" );
			});
		}
	</script>
	<input type="button" class="btnImprimir" value="Imprimir" onClick="javascript:window.print()" />
	<input type="text" id="enviar_email" class="enviar_email" value="" />
	<input type="button" class="btnEnviarEmail" value="Enviar por Email" onClick="enviarEmail()" />

	</div>
</div>


<style type="text/css">
	.table-condensed > tbody > tr > td {
	    padding: 0px 5px;
	}

	@media print {
		.form-inline,
		.info,
		.dataTables_length,
		.form-control,
		.dataTables_paginate,
		.paging_simple_numbers,
		.dataTables_info,
		.btnImprimir,
		.menu-section,
		footer{
		    display: none;
		}
	}
</style>
