<?php

require_once "../../vendor/autoload.php";

\PagSeguro\Library::initialize();
\PagSeguro\Library::cmsVersion()->setName("Nome")->setRelease("1.0.0");
\PagSeguro\Library::moduleVersion()->setName("Nome")->setRelease("1.0.0");

$preApproval = new \PagSeguro\Domains\Requests\PreApproval();

// Set the currency
$preApproval->setCurrency("BRL");

// Set a reference code for this payment request. It is useful to identify this payment
// in future notifications.
$preApproval->setReference("LISTAMED_TEST");

// Set shipping information for this payment request
/*$preApproval->setShipping()->setType(\PagSeguro\Enum\Shipping\Type::SEDEX);
$preApproval->setShipping()->setAddress()->withParameters(
    '01452002',
    'Av. Brig. Faria Lima',
    '1384',
    'apto. 114',
    'Jardim Paulistano',
    'São Paulo',
    'SP',
    'BRA'
);*/

// Set your customer information.
/*$preApproval->setSender()->setName('João Comprador');
$preApproval->setSender()->setEmail('email@comprador.com.br');
$preApproval->setSender()->setPhone()->withParameters(
    11,
    56273440
);*/

/*$preApproval->setSender()->setAddress()->withParameters(
    '01452002',
    'Av. Brig. Faria Lima',
    '1384',
    'apto. 114',
    'Jardim Paulistano',
    'São Paulo',
    'SP',
    'BRA'
);*/

/***
 * Pre Approval information
 */
$preApproval->setPreApproval()->setCharge('manual');
$preApproval->setPreApproval()->setName("Listamed - Plano de teste");
$preApproval->setPreApproval()->setDetails("Todo dia 30 será cobrado o valor de R,00 referente ao plano de teste do listamed.");
$preApproval->setPreApproval()->setAmountPerPayment('1.00');
$preApproval->setPreApproval()->setMaxAmountPerPeriod('200.00');
$preApproval->setPreApproval()->setPeriod('Monthly');
$preApproval->setPreApproval()->setMaxTotalAmount('2400.00');
$preApproval->setPreApproval()->setInitialDate('2017-09-21T10:20:00');
$preApproval->setPreApproval()->setFinalDate('2018-01-01T00:00:00');

$preApproval->setRedirectUrl("http://www.lojateste.com.br/redirect");
$preApproval->setReviewUrl("http://www.lojateste.com.br/review");

try {

    /**
     * @todo For checkout with application use:
     * \PagSeguro\Configuration\Configure::getApplicationCredentials()
     *  ->setAuthorizationCode("FD3AF1B214EC40F0B0A6745D041BF50D")
     */

echo "<pre>"; print_r('------------- inicio var:\PagSeguro\Configuration\Configure::getAccountCredentials() -------------'); echo "</pre>";
echo "<pre>"; print_r(\PagSeguro\Configuration\Configure::getAccountCredentials()); echo "</pre>";
echo "<pre>"; print_r('------------- final  var:\PagSeguro\Configuration\Configure::getAccountCredentials() -------------'); echo "</pre>";


    $response = $preApproval->register(
        \PagSeguro\Configuration\Configure::getAccountCredentials()
    );

    echo "<h2>Criando requisi&ccedil;&atilde;o de assinatura</h2>"
        . "<p>URL da assinatura: <strong>$response</strong></p>"
        . "<p><a title=\"URL da assinatura\" href=\"$response\" target=\_blank\">Ir para URL da assinatura.</a></p>";
} catch (Exception $e) {
    die($e->getMessage());
}
