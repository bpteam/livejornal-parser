<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'Z');

/** MySQL database password */
define('DB_PASSWORD', '123456');

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
define('AUTH_KEY',         'aC9_O+^TNJPc ;,G{Ye$3l3nn(-9~6zwk_R#T.>+HPdFiVCg}/X^Wff0*MR8:6OJ');
define('SECURE_AUTH_KEY',  '@JAV=ug95LecDh$03ZxlWQ<){MvSk^KqhU@eOxc#*jM/-Ix21X{RI?^x:j/&zW,y');
define('LOGGED_IN_KEY',    'YqnZ+Tge1lCUk|nNOyRxm1-|;Dh+ad=|c$!kY]-j}2ehox,vU|GJQ[D8-v&,Ujg<');
define('NONCE_KEY',        'hAo<{XPlOD/:3*O3Vr|;D$(V1h@s4VD^S@tDwe?bogX(&iRFxBR7-x3NiAXKIT/{');
define('AUTH_SALT',        'a+CW~qm*o7qCC/U-Ws:m9T!UD.( h*XQ<j50GL<|}13iO2#&FZ-Aw3%XG^]T-ww-');
define('SECURE_AUTH_SALT', 'mba]/:E<$q=~tO9Lg{A~qVT;[!/0Gn*WF&Goe !/NxDVf2f:6Uf$sE/ !#zwaM<{');
define('LOGGED_IN_SALT',   '1li:dsp++r&r8c=])wlGjRK;|e`Pr-=kRDDiKw[#`;|)iYdDj+#|xhIZUM-(Zc;X');
define('NONCE_SALT',       'kSm{Q5%f8>D:y,xjCc4_LekMc5479DNY +ugS#yvs[EhkR<-P~^TM1OJ/Alt&3g,');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
