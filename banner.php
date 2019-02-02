<?php

	if($_GET['id']):
		$conexao = new PDO('mysql:host=186.227.47.32;dbname=listamed', 'listamed', 'YyRRgzz9h0nZ5uvI', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$conexao->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);

		$id = $_GET['id'];
		$data = date('Y-m-d H:i:s');

		$sql = "INSERT INTO tb_banner_view ( id_banner, data ) VALUES ( :id, :data )";
		$op = $conexao->prepare($sql);
		$op->bindValue(":id", $id);
		$op->bindValue(":data", $data);
		$op->execute();		
	endif;

?>