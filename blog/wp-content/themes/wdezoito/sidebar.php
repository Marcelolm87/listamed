<?php
/**
 *
 * @package Wdezoito
 */

$ip = $_SERVER['REMOTE_ADDR'];
$url = "http://www.geoplugin.net/json.gp?ip=$ip";

$content = json_decode(file_get_contents($url));
$cidadeIp = ($content->geoplugin_regionName=="São Paulo") ? "SP - ".$content->geoplugin_city : "SP - ".$content->geoplugin_city;
$cidade = $cidadeIp;

// buscando cidades cadastradas
$url = 'https://listamed.com.br/api/cidades/cadastradas/';
$arrContextOptions = array(
   "ssl"=>array(
       "verify_peer"=>false,
       "verify_peer_name"=>false,
   ),
);

$response = json_decode(file_get_contents($url, false, stream_context_create($arrContextOptions)));

?>
<ul class="listCategorias">
	<li id="categorias">
		<h3><?php _e('Categorias'); ?></h3>
		<ul>
			<?php wp_list_cats(); ?>
		</ul>
	</li>
<ul>


<br/>

<script type="text/javascript">
	function enviarForm(){
		var campoBuscar = document.getElementById('campoBuscar');
		var campoCidade = document.getElementById("campoCidade");
		var campoCidadeValue = campoCidade.options[campoCidade.selectedIndex].value;
		var error;
		if(campoBuscar.value.length>3){
		}else{
			campoBuscar.className = "erro";
			error = 'ok';
			$("#error-msg").fadeIn('slow');
			$("#error-msg").css({'display' : 'block'});
			$("#error-msg").addClass('fade-in');
		}
		if(campoCidadeValue>0){
		}

		if(error!="ok"){
		   window.location.href = '/listar/'+campoBuscar.value.trim().replace(" ","-")+'/'+campoCidadeValue;
		}
	}
</script>
<h3 class="tituloSidebarBusca">Buscar</h3>
<form method="post" class="formBuscar" name="formBuscar">
	<input type="text" id="campoBuscar" class="campoBuscar" placeholder="Buscar" />
	<select name="cidade" id="campoCidade">
		<option placeholder="Cidade" disabled selected>Cidade</option>
		<?php
		foreach ($response->data as $k => $v) {  ?>
			<option <?php echo ($v->cidade == $cidade) ? "SELECTED" : "" ;?><?php echo ($cidade == $v->id) ? "SELECTED" : "" ;?>  value="<?php echo $v->id; ?>"><?php echo $v->cidade; ?></option>
		<?php } ?>
	</select>
	<input type="button" onclick="enviarForm()" class="btnBuscar" value="Buscar" />
</form>