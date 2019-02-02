 <?php

 	if(($_POST['dados']!="")&&($_POST['dados']!=null)):
 		$dados = json_decode($_POST['dados']);

	 	foreach ($dados as $kd => $vd) :
	 		if(isset($busca)){
	 			$busca .= '--'.str_replace(' ', '-', strtolower(preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"),$vd)));
	 		}else{
	 			$busca = str_replace(" ", "-", strtolower($vd));
	 		}
	 	endforeach;
	 	$busca .= "--todos";

    	$urlBanner = "http://listamed.com.br/api/banner/buscar/".$busca;
 	else:
    	$urlBanner = "http://listamed.com.br/api/banner";
 	endif;

	$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  


    // buscando banners
    $responseBanners = json_decode(file_get_contents($urlBanner, false, stream_context_create($arrContextOptions)));
//    $responseBanners = json_decode(file_get_contents($urlBanner));

	foreach ($responseBanners->data as $kB => $vB):
		$urlBannerCount = "http://listamed.com.br/banner.php?id=".$vB->id;    
		$responseCount = json_decode(file_get_contents($urlBannerCount));
	?>
    <div class="page-medicos--blocks" >
        <a href="<?php echo $vB->link; ?>" target="_blank" >    
            <img style="max-width: 270px; max-height: 178px;" src="<?php echo $vB->imagem; ?>" />
        </a>
    </div>
<?php endforeach; ?>
