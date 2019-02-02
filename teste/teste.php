<?php
$dados = array(
	"plan" => "D2202A86-2E2E-C299-9432-0F8E439C6452" ,
	"reference" => "MEU-CODIGO",
	"sender" => array(
		"name" => "José Comprador",
		"email" => "email@sandbox.pagseguro.com.br",
		"ip" => "1.1.1.1",
		"hash" => "hash",
		"phone" => array(
			"areaCode" => "99",
			"number" => "99999999"
		),
		"address" => array(
			"street" => "Av. PagSeguro",
			"number" => "9999",
			"complement" => "99o andar",
			"district" => "Jardim Internet",
			"city" => "Cidade Exemplo",
			"state" => "SP",
			"country" => "BRA",
			"postalCode" => "99999999"
		),
		"documents" => array(
			array(
				"type" => "CPF",
				"value" => "99999999999"
			)
		)
	),
	"paymentMethod" => array(
		"type" => "CREDITCARD",
		"creditCard" => array(
			"token" => "4C63F1BD5A0E47220F8DB2920325499D",
			"holder" => array(
				"name" => "JOSÉ COMPRADOR",
				"birthDate" => "20/12/1990",
				"documents" => array(
					array(
					  "type" => "CPF",
					  "value" => "99999999999"
					)
				),
				"phone" => array(
					"areaCode" => "99",
					"number" => "99999999"
				),
				"billingAddress" => array(
					"street" => "Av. PagSeguro",
					"number" => "9999",
					"complement" => "99o andar",
					"district" => "Jardim Internet",
					"city" => "Cidade Exemplo",
					"state" => "SP",
					"country" => "BRA",
					"postalCode" => "99999999"
				)
			)
		)
	)
);


	echo "<pre>"; print_r('-----------------------'); echo "</pre>";
	echo "<pre>"; print_r($dados); echo "</pre>";
	echo "<pre>"; print_r('-----------------------'); echo "</pre>";

?>