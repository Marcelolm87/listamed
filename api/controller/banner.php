<?php
require_once "classes/conexao.php";
require_once "model/banner.php";

class BannerController extends BannerModel {

	public static function BuscarTodos() {
		$sql = "SELECT 
					tb_banners.id,
					tb_banners.imagem,
					tb_banners.link,
					tb_banners.limite_visualizacao,
					tb_banners.limite_clique,
					tb_banners.data_inicio,
					tb_banners.data_fim,
					tb_banners.palavra_chave,
					(SELECT count(*) as visualizacoes FROM tb_banner_view where tb_banner_view.id_banner = tb_banners.id ) as visualizacoes,
					(SELECT count(*) FROM tb_banner_clique where tb_banner_clique.id_banner = tb_banners.id) as cliques
				FROM 
					tb_banners
				WHERE
					    (tb_banners.data_inicio = '0000-00-00' or tb_banners.data_inicio < now()) 
					and (tb_banners.data_fim = '0000-00-00' or tb_banners.data_fim > now()) 
					and (limite_visualizacao > (SELECT count(*) as visualizacoes FROM tb_banner_view where tb_banner_view.id_banner = tb_banners.id ) or limite_visualizacao = 0)
					and (limite_clique > (SELECT count(*) FROM tb_banner_clique where tb_banner_clique.id_banner = tb_banners.id) or limite_clique = 0)";
		
		$op = Conexao::getInstance()->prepare($sql);
		$op->execute();
		$retorno = (object) $op->fetchall(PDO::FETCH_ASSOC);

		if(!empty($retorno)):
			return (object) array(
				"valido" => "valido",
				"data" => $retorno
			);
		endif;
	}


	public static function BuscarBanners($dados) {

		$dados = str_replace('--', '_', $dados);
		$dados = str_replace('-', ' ', $dados);
		$dados = explode('_', $dados);
		unset($sql_busca);

		foreach ($dados as $kd => $vd) :
			if($sql_busca!=""){
				$sql_busca .= " or tb_banners.palavra_chave like '%".$vd."%' ";
			}else{
				$sql_busca = " and (tb_banners.palavra_chave like '%".$vd."%' ";
			}
		endforeach;
		$sql_busca .= ")";
		
		$sql = "SELECT 
					tb_banners.id,
					tb_banners.imagem,
					tb_banners.link,
					tb_banners.limite_visualizacao,
					tb_banners.limite_clique,
					tb_banners.data_inicio,
					tb_banners.data_fim,
					tb_banners.palavra_chave,
					(SELECT count(*) as visualizacoes FROM tb_banner_view where tb_banner_view.id_banner = tb_banners.id ) as visualizacoes,
					(SELECT count(*) FROM tb_banner_clique where tb_banner_clique.id_banner = tb_banners.id) as cliques
				FROM 
					tb_banners
				WHERE
					    (tb_banners.data_inicio = '0000-00-00' or tb_banners.data_inicio < now()) 
					and (tb_banners.data_fim = '0000-00-00' or tb_banners.data_fim > now()) 
					and (limite_visualizacao > (SELECT count(*) as visualizacoes FROM tb_banner_view where tb_banner_view.id_banner = tb_banners.id ) or limite_visualizacao = 0)
					and (limite_clique > (SELECT count(*) FROM tb_banner_clique where tb_banner_clique.id_banner = tb_banners.id) or limite_clique = 0)
					".$sql_busca;

//echo $sql;

		
		$op = Conexao::getInstance()->prepare($sql);
		$op->execute();
		$retorno = (object) $op->fetchall(PDO::FETCH_ASSOC);

		if(!empty($retorno)):
			return (object) array(
				"valido" => "valido",
				"data" => $retorno
			);
		endif;
	}

}

?>