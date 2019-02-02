<?php 

$url= 'https://listamed.com.br/api/page';

$arrContextOptions=array(
      "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  

$response = file_get_contents($url, false, stream_context_create($arrContextOptions));



		//	$sms =	json_decode(file_get_contents("https://listamed.com.br/api/page"));
			$sms =	file_get_contents("https://www.listamed.com.br/api/page");

echo "<pre>"; print_r('------------- inicio var: sms -------------'); echo "</pre>";
echo "<pre>"; print_r($response); echo "</pre>";
echo "<pre>"; print_r('------------- final  var: sms -------------'); echo "</pre>";
/*
	function cUrlFunction($url){
		$ch      = curl_init();
		$timeout = 10; // set to zero for no timeout
		curl_setopt ($ch, CURLOPT_URL, $url);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		
		$request_headers = array();
		$request_headers[] = "Authorization: Basic VEVNTk9USUNJQTppZW5rbU50Rw==";

		
		$request_headers[] = "Content-Type: application/json" ;
		$request_headers[] = "Accept: application/json";
                
		curl_setopt($ch, CURLOPT_HTTPHEADER, $request_headers);
	
		$txt     = curl_exec($ch);
		curl_close($ch);
		return $txt;

	}

	$url   = "http://api.allcancesms.com.br/account/1/balance";
	$res   =  cUrlFunction($url);
	
	
	$resJson = json_decode($res, false);

	echo "<pre>"; print_r('-----------------------'); echo "</pre>";
	echo "<pre>"; print_r($res); echo "</pre>";
	echo "<pre>"; print_r($resJson); echo "</pre>";
	echo "<pre>"; print_r('-----------------------'); echo "</pre>";
*/