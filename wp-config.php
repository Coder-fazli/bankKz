<?php

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u831367588_Bank' );

/** Database username */
define( 'DB_USER', 'u831367588_Kz' );

/** Database password */
define( 'DB_PASSWORD', 'Viktor1997#' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'wQ:-?!#:TkU*2dwM2&*>zIlPlt&sel!D&Gg>H%:>(t/>,=s]K^3=q@^a~<~G.,lq' );
define( 'SECURE_AUTH_KEY',   'F,~=+RE@(2<<2yY9K8}-H[Me/WAAxH[ATsplHhP!0Psc~64e}@<$mg$Y5:Y&vu=:' );
define( 'LOGGED_IN_KEY',     '2Po*> QT^{=N}D$5^h/RQ(5PbG{-Y{{S2?#4vB*)D*}~v&)OyF+mR[$b5;H*ZdzX' );
define( 'NONCE_KEY',         'sCi_!e{1,ZC!j PQBXLd^+T;GrO{f@eVw?_&781`cXTU?3X 2%4)z&Ri!4*qB|98' );
define( 'AUTH_SALT',         '@<%rW-U+^M%T^O^5x?kRiq;1u_=s}gy,^E|}>oW`sno_./@$(1f+e`s~oY0p/iGC' );
define( 'SECURE_AUTH_SALT',  'Ab3K&WgK*V&uFO^CAdN`qqCpMKE]mo@,BeUB8verUW8W6Z.jTMTWCSP+.=T|N]3,' );
define( 'LOGGED_IN_SALT',    'kYNJ@(T2A]=zW6N82H)Au.-W$w1(__/X4:dqqVJ9&9wUXX=u,ZUK)^d`@a%FaE=1' );
define( 'NONCE_SALT',        '*7>ohjt}^#A|SWXMkSO_35#//m_2Tw{6~TwI?V.^3QOtyk-o:,sqtZ,<TElBYQ:c' );
define( 'WP_CACHE_KEY_SALT', 'j/aSS/7^h~J{kiX-{PxgpsBnD8M9Qw]|/X%dVL1d)bdYd/REeH/lmf&/%;$A~vd}' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'e2e724fce0518d967050c2faf89092db' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
