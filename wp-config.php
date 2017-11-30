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
define('DB_NAME', 'data2pap_testd2p');

/** MySQL database username */
define('DB_USER', 'data2pap_testd2p');

/** MySQL database password */
define('DB_PASSWORD', '4SE!!39phd');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         'zwgab1kdkr943lfnlpddqvdyklsvr7nk5vdedvx6t56xckgdgy9tind6ineqwzd8');
define('SECURE_AUTH_KEY',  'mdbml3gpqabynt1lyizbn5j3sxgwxoj4mdip6elcxtazevrx590s3q62xz7pib6e');
define('LOGGED_IN_KEY',    'zgkxovkn4pzcnolulacpoucbby1rpl1byjip3cy3twdr3c8jkqa8gwg8oc2yfeto');
define('NONCE_KEY',        '9yf1brbwrtulor27bjlj4rn8tbpm3nr4lwx3yoqi1ccg097ttqxceynem60flshj');
define('AUTH_SALT',        'ylfuagywn0nzsxoh9hlhz7kt2xggddb9omocekri8anj6xfueo2tvc7m4eppoq5k');
define('SECURE_AUTH_SALT', 'iou9obcp1seo0mntycfft5xssxxwfwhmcawfkga7q4xc4ebxmnu7bjzaod4rmoqk');
define('LOGGED_IN_SALT',   '4g8o9gvixplnpj0tul2f3ingns9hptoloqrj677k1entvyfnlyd3butoz8thuqe1');
define('NONCE_SALT',       'mgb8fwhmpa4pkmmflhgksb2zkfef42l10x6zulxzlup0xxikafqc9aoj62bzik07');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'testd2p_';

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
define( 'WP_MEMORY_LIMIT', '128M' );

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');

# define('WP_HOME','http://77.104.180.122/~data2pap/');
# define('WP_SITEURL','http://77.104.180.122/~data2pap/');

# Disables all core updates. Added by SiteGround Autoupdate:
define( 'WP_AUTO_UPDATE_CORE', false );
