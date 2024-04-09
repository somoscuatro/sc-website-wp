<?php
/**
 * The Archive Services Template File.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context         = TimberLibrary::context();
$context['post'] = TimberLibrary::get_post_by(
	'slug',
	'services'
);

TimberLibrary::render( 'index.twig', $context );
