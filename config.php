<?php
	$caminho = 'https://'.$_SERVER['HTTP_HOST'].'/';
	$caminhoOnline = 'https://'.$_SERVER['HTTP_HOST'].'/';
	$caminhoApi = 'http://'.$_SERVER['HTTP_HOST'].'/api/';

	$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  
?>
