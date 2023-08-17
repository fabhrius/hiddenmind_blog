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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'hiddenmind' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

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
define( 'AUTH_KEY',         '*+K<pXVo28wr!eT0Fq,5!>;go,ZVbQo/h>?UHH9Qn|I5GaOA~Zm6|+/N[fyfOtk8' );
define( 'SECURE_AUTH_KEY',  '<8!=LcO3F>;(VZ5xuWLGE|MQG5xIHt~J?RFjx9p3Q$%1:-*C[]rhBk:p/8y9Tg+r' );
define( 'LOGGED_IN_KEY',    'Xq*coE5kom@ZZMa>rfmyW:ClK4AOWi.U}MH-P!/Jg[IF,N:GtDus9rpWq7nPmUnW' );
define( 'NONCE_KEY',        '6cql/cT)Q1}8Hf5TrNj#7S&9ZCTaW{^qe9t>Kz1*V,DaGDm0tKU@&c6WT(KGFUu)' );
define( 'AUTH_SALT',        '0A9u,I&;,(zM&Gah=r15RU,bi[{E-=~9ewtq1iQ*FH-D3Of]AA@PH9Fbk3VUJ_|b' );
define( 'SECURE_AUTH_SALT', '}(E;_:KU-Nsj~b!@tr=T*5RFczT48:_;I %iMq&g/|l;m&W7w4&O :23F^KdcjTD' );
define( 'LOGGED_IN_SALT',   'Y7|u0K[MzBRg8;)(c*oRa)seIhD6YX=G?HKY P4`QM+p(:UhXJ!bi982S<W5o&yf' );
define( 'NONCE_SALT',       '1E);CQgsmyd|}EFiXD-pO&!4CDdVxG2Wf|yPU]s$?8V5.=6_XvgW@RsdnpGJ@L8`' );

/**#@-*/

/**
 * WordPress database table prefix.
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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
