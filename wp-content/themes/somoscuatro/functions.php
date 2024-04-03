<?php
/**
 * Initialize theme.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Somoscuatro\Theme\Attributes\Hook;
use Somoscuatro\Theme\CLI\CLI;
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

// Register CLI commands.
( new CLI() )->register_commands();
