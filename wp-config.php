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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'kpku' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'ZX*EZlk(^}[S(e.g,=S`JUjAQqS0@RP9)rT}PkPsv`+qxl1.5=l8)Y3o QKhxxF^' );
define( 'SECURE_AUTH_KEY',  '@W3C~{eY&_}5R<Udb<*t0=JBi^%9N|IfSi8+TK^0D$o*9M3ifl|hH vF^hwkD#3O' );
define( 'LOGGED_IN_KEY',    '$UI{TKx/eO>HU`s|vlpCp/:(n-Me*y +[63kcuFEKWS9K +-bCnUb$;P%!4%+tKU' );
define( 'NONCE_KEY',        '>t9{V[&9,2g`x!0c.K@<JnJ[acz5V3wg}E066H~kr)(T?({_H/*lvhb^zV*5^*7e' );
define( 'AUTH_SALT',        'HluY}+z.;.i)}hhUkqmXK^p``_?fumR^l6|#Xoe*fhi8pl@Zu~.Hrz=aKnr:R+;4' );
define( 'SECURE_AUTH_SALT', '>3BFPQ_#nrQCLT*{^Qg{;&C;ngeP2BQU9RDD3g%3<P>C:zNt~o4gk9U|T`j{#CO}' );
define( 'LOGGED_IN_SALT',   '`,F`g-_rLtBl:,J!$}tbOG:KfU?OYK^RRkIyr._xW-OWnx>z:}txfhh$X#7kE$/8' );
define( 'NONCE_SALT',       '_y2;>hCT5O@t!X-UQ.Egu7Rp&h45]qK?jyj.@,U/z4NV`,5}(UnYz_37t*9s:ed9' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define( 'WP_DEBUG', false );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
