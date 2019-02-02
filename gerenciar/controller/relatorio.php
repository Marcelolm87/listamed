<?php
require_once "classes/conexao.php";
require_once "controller/abstract.php";

class RelatorioController extends ControllerAbstract {

    function __construct() {
        //print "In BaseClass constructor\n";
    }

    public static function converteData($data, $banco) {
    	if ($banco=="save") {
    		$dataAux = explode('/', $data);
    		return $dataAux['2'].'-'.$dataAux['1'].'-'.$dataAux['0'];
    	}else{
    		$dataAux = explode('-', $data);
    		return $dataAux['2'].'/'.$dataAux['1'].'/'.$dataAux['0'];
    	}
    }

    public static function montaQuery($dados,$token){

    	if($dados['btnFiltrar']=="Filtrar"):
    		$filtros = "";
    		
            $data = date("Y-m-d", strtotime('-3 days'));
    		$data_inicial = (@$dados['startTime']!="") ? "&start-date=".date('Y-m-d', strtotime(self::converteData($dados['startTime'],'save'))) : "&start-date=".date('Y-m-d', strtotime('-15 days')) ;
    		$data_final   = (@$dados['data_final']!="")   ? "&end-date=".date('Y-m-d', strtotime(self::converteData($dados['data_final'],'save'))) : "&end-date=".date('Y-m-d') ;
    		$qtdeResultado = 1000;

			if ( (@$dados['pagina']!="")||(@$dados['rotulo']!="")||(@$dados['acao']!="") ):    		
	    		$filtros = '&filters=';
	    		if(@$dados['pagina']!=""):
                    $dados['pagina'] = str_replace(" ", "%20",$dados['pagina']);
                    $filter[0] = 'ga:eventCategory=~'.$dados['pagina'];
                    $filtros .= $filter[0];
                endif;
                if(@$dados['rotulo']!=""):
                    $dados['rotulo'] = str_replace(" ", "%20",$dados['rotulo']);
                    $filter[1] = 'ga:eventLabel=~'.$dados['rotulo'];
                    $filtros .= (@$filter[0]!="") ? ';'.$filter[1] :  $filter[1];
                endif;
                if(@$dados['acao']!=""):
                    $dados['acao'] = str_replace(" ", "%20",$dados['acao']);
                    $filter[2] = 'ga:eventAction=~'.$dados['acao'];
                    $filtros .= ((@$filter[0]!="")||(@$filter[1]!="")) ? ';'.$filter[2] :  $filter[2];
	    		endif;
			endif;

    		$url  = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A142173175$data_inicial$data_final&metrics=ga%3AtotalEvents&dimensions=ga%3AeventCategory%2Cga%3AeventAction%2Cga%3AeventLabel&sort=-ga%3AeventLabel$filtros&max-results=$qtdeResultado&access_token=$token";
            return $url;
		endif;
    }

    
}
?>