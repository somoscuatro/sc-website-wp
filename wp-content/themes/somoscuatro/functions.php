<?php
/**
 * Initialize theme.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Hook;
use Somoscuatro\Theme\Dependency_Injection\Container as Dependencies;
use Somoscuatro\Theme\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
	exit;
}

// Setup autoload.
require_once __DIR__ . '/autoload.php';

// Register dependencies.
$dependencies = new Dependencies();
$dependencies->add( 'Theme', fn ( $dependencies ) => new Theme( $dependencies ) );
$dependencies->add( 'Timber', fn ( $dependencies ) => new Timber( $dependencies ) );
$dependencies->add( 'ACF', fn() => new ACF() );

// Register WordPress hooks.
( new Hook( $dependencies ) )->register_hooks();

// if ( defined( 'WP_CLI' ) && WP_CLI ) {
// \WP_CLI::add_command( 'export-acf-blocks-fields', __NAMESPACE__ . '\Commands\Export_Acf_Blocks_Fields' );
// }
