<?php
// Load the Google API PHP Client Library.
require_once __DIR__ . '/vendor/autoload.php';

session_start();

/*Este é seu ID do cliente
669478999867-5uvse4trl5785h5c0qljvcomceaumpr6.apps.googleusercontent.com
Esta é sua chave secreta do cliente
OLYrGD7_qKMwqw2TwP8KDkyO */

$client = new Google_Client();
$client->setAuthConfig(__DIR__ . '/client_secrets.json');
$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);



// If the user has already authorized this app then get an access token
// else redirect to ask the user to authorize access to Google Analytics.
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {

  $client->setAccessToken($_SESSION['access_token']);
  $analytics = new Google_Service_AnalyticsReporting($client);

	$datainicial = "2017-03-01";
	$datafinal   = "2017-03-08";
	$filter      = "marcelo";
	$token       = $_SESSION['access_token']['access_token']; 
   
	$url  = "https://www.googleapis.com/analytics/v3/data/ga?ids=ga%3A142173175&start-date=$datainicial&end-date=$datafinal&metrics=ga%3AtotalEvents&dimensions=ga%3AeventCategory%2Cga%3AeventAction%2Cga%3AeventLabel&sort=-ga%3AeventLabel&filters=ga%3AeventLabel%3D~$filter&max-results=1000&access_token=$token";
	$curl = curl_init();

	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url
	));

	$retorno = curl_exec($curl);
	curl_close($curl);

} else {
  $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/gerenciar/oauth2callback.php';
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
}
?>

Exibindo resultados de xx/xx/xxxx até xx/xx/xxxx filtrando por xxxxxxx

total de xx itens, começando de xx até xx com xx paginas 

No total foram xx eventos

<table id="dataTable" class="table table-striped table-bordered table-hover">
<thead>
	<tr>
		<th>Categoria</th>
		<th>Ação</th>
		<th>Rotulo</th>
		<th>Total de eventos</th>
	</tr>
</thead>
<tbody>
	<?php //foreach ($valor->data as $k => $v) : ?>
		<tr>
			<td><?php echo "" ?></td>
			<td><?php echo "" ?></td>
			<td><?php echo "" ?></td>
		</tr>
	<?php //endforeach; ?>
</tbody>
</table>
