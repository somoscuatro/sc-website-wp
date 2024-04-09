<?php
/**
 * Initialize Theme.
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

// Setup Autoload.
require_once __DIR__ . '/autoload.php';

// Setup Dependencies.
$container = new Container();

( new Hook( $container ) )->register_hooks();

// Register CLI Commands.
( new CLI( $container ) )->register_commands();
