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
define( 'DB_NAME', 'gwCRAIk4QZopWq' );

/** MySQL database username */
define( 'DB_USER', 'gwCRAIk4QZopWq' );

/** MySQL database password */
define( 'DB_PASSWORD', 'kMG60uzjufO2f8' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost:3306' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',          'A&fosg,fiE N!2+~TYNT%y/@#9T;z($XV`YL=9(0*$=1f3Bof_<]kH,9gEE0WT-Q' );
define( 'SECURE_AUTH_KEY',   'pf$_qG>I`6Ka&}8VWtU9*N{7:/.xD frc90eJ^u7xW=,nW}bUKf@)%d+NJT{zY(4' );
define( 'LOGGED_IN_KEY',     '9O,{{ODFC69+$1mWk.`SJ!j^y*05gM9)6`hAgkkGk9OqH&<nxc>z9h1Ax^Yigt2O' );
define( 'NONCE_KEY',         '[|@c0=`!K#9&({h2?x&cz.5+ua<)cQg$-M.}i;bA<Fs&$Mv=B@G(wCCr{PtEHGSU' );
define( 'AUTH_SALT',         '9*{f]Xc[uG1<Vmls.`Ho xym?SPOiIWS_S[~m8fCSrQ_WWHTcrTcuV+  k]1J%>x' );
define( 'SECURE_AUTH_SALT',  '~[P;Y`!h>H0%_dh9>iDU .dYo%;a~>kOpm_*rBhxUJ(a`79$aJvo]1+G1C6<dlh<' );
define( 'LOGGED_IN_SALT',    '8+Vs{>byhbmmDOPQZx_b:wgwh{!v8_fw^;V$<A8i6ghSzF7#/J4/|dDA{K|`{GRf' );
define( 'NONCE_SALT',        '8VU9+82l0BNjFv$foJn6&)voVZowZ*KMW:cd5e(Q3bl~5gtzT&7|1[Nl_d-:vI a' );
define( 'WP_CACHE_KEY_SALT', 'Fg21@{nOWPQn%==a-4GKh66^4A]z}WI{@8RH(cK?R04Lst9@5,X=U~f_+vsgYHk+' );

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';




/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
