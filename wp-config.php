<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'safyyrep_ss_dbname115');

/** MySQL database username */
define('DB_USER', 'safyyrep_ss_d115');

/** MySQL database password */
define('DB_PASSWORD', 'rAjZmLkIJ55S');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY', 's)Su!v|RbNBu_&cTn{+$/H@MM@NuwndB(Y%&^^LTjV*FsPG}_=DlqhH@eBPrETI/Wr&LgBDM>UT-cWxaLfU_jTHQh^*o=)veTQ*=n&fOpIzQuwFPa?<^_B-$edD;Ff;+');
define('SECURE_AUTH_KEY', 'P|Xw$Ut)Me|{AAU&M+u[V[/EhLIWWPniw^}&zWwpAve|<RF[qU&g}H(>rA}FLTSlM+oZI/GR;keLlV*U$HBp|vGvSZPt>f]>Neby[<tALMUPlyrI}mgeD}nK-R]R!jOQ');
define('LOGGED_IN_KEY', '(fd]c{XokEf)wdc{c^Ubv&KA^^SWT=C[e*NFjXeBEINOPAn^b!G_Bi]!=<_hvEi^[rtHnr=*@}RwApGgaY(;&jrncrrLgfOGB;rP|VfNdniC[m@MW%+>y)W}Sj/b^XQt');
define('NONCE_KEY', 'Wex&jX/F%ofNV>Zs]ys[(D?D))i)|vMkn%P?Ci(q]I=DxR]gaNRhMFDx;wm!yaIS$duveTULm&]S>X&|=x/EcUokN*LIspGecc{yI};pgK&DSu^}+TeajenhYOPRnGA[');
define('AUTH_SALT', '/Gyh*rV<CbouCIew}YSIttF{yCJxbV;eEw/-IbtcA<CqpYPpcf|$^kMNFlIcxt<Fq(ptzl}PU[uyxyN$&/<WejZXKvI_kyxr<jDGW|MY;<FG[QgsTC&SmxTY/Sl+{hQX');
define('SECURE_AUTH_SALT', 'ht;S}jB&xwzYzyqQHbTp|$awAt|wCI)AozY$*%*rD__;^Sx{PA%>g=t^IG)/Ra<*gJP_pYBQ({J@_-gT/HMUUPvN[q?*{k[AW_f;[PQ&!iuoy=!Sge&%v/dYWo]}ijav');
define('LOGGED_IN_SALT', 'eWLC@QeO*cNPK<=*xEW!B/qkmR}U=k>SNE?@KYeV?E-=>u@%PUozjyAA{zoXJmz_}@LO<nbq;eojwXN}o]t@^<]V${X?xhy]en|zq(^|K{HLwQz;{Cb_%Tg)%|oS!QBL');
define('NONCE_SALT', 'HhPTND!nt!fNG;HOj&MH)_)uvQt^n_{MeqJ/iG&}A$;;dP<LL)I>PGc)]RE!!/)/&&DU<f|vHSG?dvHyn]{!sv;;(gtI}F<KRMOUuItr$b&&pR}vlTGo!_H]Ya;tmpjX');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_btgh_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
