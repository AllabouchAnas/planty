<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'planty' );

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
define( 'AUTH_KEY',         'v;+<H)+)%AT$vZ?V;{<o<w0ltyF,t,o@GJj&NaWq&:9DwP|8ea*3Dm(j4H{JOX|9' );
define( 'SECURE_AUTH_KEY',  'OnJ8Fm%^GA_<n$ (ZVnS{YA~&]2D=i7?.aIc8HgOOx uHXsKNL,0^K:2y70dlFKP' );
define( 'LOGGED_IN_KEY',    '^=gl,WLg8n_%+ /=(N[-A#Ob?29_KNuRYVu38kQ}&DJn]x-4cujA~(VdIjv68Q_H' );
define( 'NONCE_KEY',        ' [jVd: [xs0bK 9u<xJ$zL4gs-*?&MK*<MvlFgPwjU*l8<A7 FCk06{J)=R@2vet' );
define( 'AUTH_SALT',        'X2,dWAQ`}!^Ue~ND/B u#R(}]*wIJbHhh3:L,e(N)mN]a0Qb%^^/uo11|RfRo^&&' );
define( 'SECURE_AUTH_SALT', 'mz@Xzur5 4qaZ*@p@X<>-9++^]_-DM2!A3L6H2Y%_V#(oIUJXc-!;cXd;@1O#HM9' );
define( 'LOGGED_IN_SALT',   '66xaxU[^A}xVFT|S6^Aet8Uxx#?@,Ei;6Z[;UMo)bhho./Ih2vk3AGvF%0L0(r I' );
define( 'NONCE_SALT',       'pYUPr{X(7S06ADo^PuD#.l0vw?r3}eRwld<q~V1p<od@k| Fah<-H+yo$mt&&<tR' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
