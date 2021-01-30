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
define('DB_NAME', 'everytq429');

/** MySQL database username */
define('DB_USER', 'everytq429');

/** MySQL database password */
define('DB_PASSWORD', '5eCBGR33rRRA');

/** MySQL hostname */
define('DB_HOST', 'everytq429.mysql.db:3306');

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
define('AUTH_KEY',         'IDgepCup5fBhvJPIT/A+V4VCdW+XukpbHFBqfgeAV0YpYNxlLYvAZktfXDjQ');
define('SECURE_AUTH_KEY',  'A8CkB4QbY5b8UknIQDIgYGgQyeOBg2wUdY2SztZpV4FI943CWTBBmR4SqH0D');
define('LOGGED_IN_KEY',    'Dh+D0YSo3dXUvQQzwjHtrDmMLMi7vACEcgorYT/prrjifmHhr7l+uGGJuXFa');
define('NONCE_KEY',        's2CxYa4XqUFDhBq4JLv/VF+2g0jBj2c4Gm+X3kCIR0pTVjsw6inx6DhuhyuM');
define('AUTH_SALT',        'pPurJp9zYcCXu2Ocw+xC0xmlKoIpT7XtJcG2ezT2SwmXeLuv+7ZKveyTywf4');
define('SECURE_AUTH_SALT', 'VJprEH8DZY+xfWEaBbT016FWT0eyDv+QKxRgvHBUHMgGIwHYDeGh5MQ6RcEm');
define('LOGGED_IN_SALT',   '1grrQ1nIiwp0utCFXSRJXc14IaU/3DP19wTGT9Wy2hKiQMORYEfDuI1jdiAA');
define('NONCE_SALT',       'f90V087BSiuo+azYE1qNsjvqW5GQW+9x3SZShe00WWau/MsZ4vV58rdvu2+z');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'mod269_';

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

/* Fixes "Add media button not working", see http://www.carnfieldwebdesign.co.uk/blog/wordpress-fix-add-media-button-not-working/ */
define('CONCATENATE_SCRIPTS', false );

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
