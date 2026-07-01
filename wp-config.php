<?php
/**
 * Local WordPress configuration for XAMPP.
 *
 * @package WordPress
 */

define( 'DB_NAME', 'alpha_edu' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY',         '`)y=?)l(,:QfMmg+z]^tu4f=lqw|95Y,==-Klb07C__5dC_Sc>@*xi1RMw:Qn8.`' );
define( 'SECURE_AUTH_KEY',  '@cG.,v7`^2C^To2QnQ|DD>kK[`K:0/2p:F`AD[!](%uYXwM`8E=9Nmt+MiDLFpBE' );
define( 'LOGGED_IN_KEY',    ')AE<0&A8Wu[U1U Vc`Q|vQ%<K6?Qk>{# ZaJBB]=7_Zym_c*CFt&#=L8X)UG!NBy' );
define( 'NONCE_KEY',        'JKL2p%tdq<Aw7nn~_`=|^nl#;I1*/3~ZT5Q!9Ha1^_T]<f{LS#*6v#%(jiZP@)|,' );
define( 'AUTH_SALT',        '/mtk{WQ;ngH]HE>xpuHmN]ab=eEotJa-,:;gIy&JW9m0W5*Q (f~q+2Vx*BR[j7g' );
define( 'SECURE_AUTH_SALT', '|*d=KPA*}Dh[lC)tI(M/.{iXC3FV@7[<#x$B,VFUeX#vkbkbaFFp&;_}P`oov6ef' );
define( 'LOGGED_IN_SALT',   'aNM)nYN0bH}YVul)FRpnLJMVP/ag+?G=u#2]YuYW/M8XGHvP<@(<{b|nx, my:kX' );
define( 'NONCE_SALT',       '*uvcV(;C{&O17:>jeDbQYAnNVs3X6A,9HZi*c&Bcm%/V=hp%m([[<8SWIKo#>FK9' );

$table_prefix = 'wp_';

define( 'WP_DEBUG', false );

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
