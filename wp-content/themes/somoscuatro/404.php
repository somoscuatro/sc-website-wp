<?php
/**
 * The 404 template file.
 *
 * @package somoscuatro-theme
 */

declare(strict_types=1);

namespace Somoscuatro\Theme;

use Timber\Timber as TimberLibrary;

$context = TimberLibrary::context();

$context['image'] = acf_get_attachment( get_theme_mod( '404_image' ) );
$context['text']  = get_theme_mod( '404_text' );

TimberLibrary::render( '404.twig', $context );
