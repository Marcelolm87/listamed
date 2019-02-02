<?php

	require "pagseguro/Checkout.class.php";

	$retorno = Checkout::doPayment();

$ip = $_SERVER["REMOTE_ADDR"];
if($ip=="187.73.214.66"){
	echo "<pre>"; print_r('-----------------------'); echo "</pre>";
	echo "<pre>"; print_r($retorno); echo "</pre>";
	echo "<pre>"; print_r('-----------------------'); echo "</pre>";
}


/*
	$dados = $_POST['dados']['paymentMethods'];
	foreach ($dados as $k => $v) :
		switch ($k) {
			case 'BOLETO':
				if($v['options']["BOLETO"]['status'] == "AVAILABLE"){
					echo '<img src="https://stc.pagseguro.uol.com.br/"'.$v['options']["BOLETO"]['images']['SMALL']['path'].'" />';
				}
				break;

			default:
				# code...
				break;
		}
	endforeach;*/


$ip = $_SERVER["REMOTE_ADDR"];
if($ip=="187.73.214.66"){
echo "<pre>"; print_r('-----------------------'); echo "</pre>";
echo "<pre>"; print_r($_POST); echo "</pre>";
echo "<pre>"; print_r('-----------------------'); echo "</pre>";
}

?>