<?php
/**
 * Initialize theme.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
	exit;
}

// Setup autoload.
require_once __DIR__ . '/autoload.php';

add_action( 'admin_init', __NAMESPACE__ . '\Admin::init' );

add_action( 'after_setup_theme', __NAMESPACE__ . '\Timber::init', 9 );
add_action( 'after_setup_theme', __NAMESPACE__ . '\Theme::after_setup_theme', 9 );
add_action( 'init', __NAMESPACE__ . '\Theme::init' );

add_action( 'plugins_loaded', __NAMESPACE__ . '\Theme::load_text_domain' );

if ( defined( 'WP_CLI' ) && WP_CLI ) {
	\WP_CLI::add_command( 'export-acf-blocks-fields', __NAMESPACE__ . '\Commands\Export_Acf_Blocks_Fields' );
}
