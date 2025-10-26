<?php
/**
 * WordPress Configuration File - Safwa Tourism
 * 
 * INSTRUCTIONS:
 * 1. Copy this file to your WordPress root directory
 * 2. Rename to: wp-config.php
 * 3. Update the database settings below
 * 4. Save and reload WordPress
 */

// ** Database Settings - UPDATE THESE ** //

/** Database name - the database you created in phpMyAdmin */
define( 'DB_NAME', 'safwa_tourism' );

/** Database username - default for XAMPP is 'root' */
define( 'DB_USER', 'root' );

/** Database password - default for XAMPP is empty '' */
define( 'DB_PASSWORD', '' );

/** Database hostname - usually 'localhost' */
define( 'DB_HOST', 'localhost' );

/** Database charset */
define( 'DB_CHARSET', 'utf8mb4' );

/** Database collation type */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 * 
 * IMPORTANT: Generate new keys from: https://api.wordpress.org/secret-key/1.1/salt/
 * Replace the dummy text below with generated keys for security!
 */
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');
/**#@-*/

/**
 * WordPress database table prefix.
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
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */

// Increase memory limit (optional, but recommended)
define( 'WP_MEMORY_LIMIT', '256M' );

// Increase maximum upload file size
define( 'WP_MAX_UPLOAD_SIZE', '64M' );

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
