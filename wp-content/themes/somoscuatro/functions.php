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

use DI\Container;

if ( ! defined( 'ABSPATH' ) ) {
	// phpcs:ignore WordPress.Security.ValidatedSanitizedInput
	header( $_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found' );
	exit;
}

// Setup autoload.
require_once __DIR__ . '/autoload.php';

// Setup dependencies.
$container = new Container();

( new Hook( $container ) )->register_hooks();

// Register CLI commands.
( new CLI( $container ) )->register_commands();
