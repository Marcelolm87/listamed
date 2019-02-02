<?php
	
	class PagSeguroData {
		
		private $sandbox;
		
		private $sandboxData = Array(
			

			/*'credentials' => array(
				"email" => "marcelolm@hotmail.com.br",
				"token" => "A12CF8F7DE7B493A927840D93FE0E9F0"
			),
			*/

/*			'credentials' => array(
				"email" => "marcelolm@hotmail.com.br",
				"token" => "6592BA9FED414F9BBF85203552C2BA58"
			),*/
			'credentials' => array(
				"email" => "marcelolm@hotmail.com.br",
				"token" => "1997DD5A6464BC8EE4811F91356D81D3"
			),
			
			
			'sessionURL' => "https://ws.sandbox.pagseguro.uol.com.br/v2/sessions",
			'transactionsURL' => "https://ws.sandbox.pagseguro.uol.com.br/v2/transactions",
			'javascriptURL' => "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"
		);
		
		private $productionData = Array(
			
			/*			'credentials' => array(
				"email" => "marcelolm@hotmail.com.br",
				"token" => "A12CF8F7DE7B493A927840D93FE0E9F0"
			),
			*/
/*			'credentials' => array(
				"email" => "marcelolm@hotmail.com.br",
				"token" => "6592BA9FED414F9BBF85203552C2BA58"
			),*/

			'credentials' => array(
				"email" => "marcelolm@hotmail.com.br",
				"token" => "1997DD5A6464BC8EE4811F91356D81D3"
			),
						
			'sessionURL' => "https://ws.pagseguro.uol.com.br/v2/sessions",
			'transactionsURL' => "https://ws.pagseguro.uol.com.br/v2/transactions",
			'javascriptURL' => "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js"
			
		);
		
		public function __construct($sandbox = false) {
			$this->sandbox = (bool)$sandbox;
		}
		
		private function getEnviromentData($key) {
			if ($this->sandbox) {
				return $this->sandboxData[$key];
			} else {
				return $this->productionData[$key];
			}
		}
		
		public function getSessionURL() {
			return $this->getEnviromentData('sessionURL');
		}
		
		public function getTransactionsURL() {
			return $this->getEnviromentData('transactionsURL');
		}
		
		public function getJavascriptURL() {
			return $this->getEnviromentData('javascriptURL');
		}
		
		public function getCredentials() {
			return $this->getEnviromentData('credentials');
		}
		
		public function isSandbox() {
			return (bool)$this->sandbox;
		}
		
	}
	
?>